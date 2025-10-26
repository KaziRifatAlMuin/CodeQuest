<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

/**
 * Service to synchronize Codeforces handles and ratings for users.
 *
 * Assumptions made:
 * - We only check users who have `cf_handle` set (NOT NULL).
 * - If a handle is not found on Codeforces, the corresponding user row will be deleted
 *   (this follows the user's instruction to "delete that user ID"). This is a destructive
 *   operation — if you want a safer behavior (clear the handle instead), change the
 *   `delete` call below to an update that sets `cf_handle` => NULL.
 * - We batch handles (up to 100 per API call) to avoid excessive HTTP calls.
 */
class CodeforcesService
{
    /**
     * Synchronize all users with cf_handle set: if handle exists on CF, update max rating;
     * otherwise delete the user record.
     *
     * This method is intended to be called from a view composer (so it runs when the layout
     * renders). It catches HTTP and other exceptions and will skip on errors to avoid breaking
     * page renders.
     *
     * @return void
     */
    public function syncAllUserHandles(): void
    {
        // Fetch users with a cf_handle
        $users = User::whereNotNull('cf_handle')->select('user_id', 'cf_handle')->get();

        if ($users->isEmpty()) {
            return;
        }

        // Chunk in batches of 100 handles per Codeforces API call
        $chunks = $users->chunk(100);

        foreach ($chunks as $chunk) {
            $handles = $chunk->pluck('cf_handle')->all();

            try {
                $response = Http::get('https://codeforces.com/api/user.info', [
                    'handles' => implode(';', $handles),
                ]);

                if (!$response->successful()) {
                    // API error — skip this batch
                    continue;
                }

                $json = $response->json();
                if (!isset($json['status']) || $json['status'] !== 'OK' || empty($json['result'])) {
                    // No results for this batch — remove all users in this chunk
                    foreach ($chunk as $userRow) {
                        DB::delete('DELETE FROM users WHERE user_id = ?', [$userRow->user_id]);
                    }
                    continue;
                }

                // Map results by handle
                $resultMap = [];
                foreach ($json['result'] as $u) {
                    if (isset($u['handle'])) {
                        $resultMap[strtolower($u['handle'])] = $u;
                    }
                }

                // For every user in this chunk: update if found, else delete
                foreach ($chunk as $userRow) {
                    $handleKey = strtolower($userRow->cf_handle);

                    if (isset($resultMap[$handleKey])) {
                        $data = $resultMap[$handleKey];
                        $maxRating = $data['maxRating'] ?? 0;

                        DB::update('UPDATE users SET cf_max_rating = ?, handle_verified_at = ?, updated_at = NOW() WHERE user_id = ?', [
                            $maxRating,
                            now(),
                            $userRow->user_id,
                        ]);
                    } else {
                        // Handle not found on Codeforces: delete user record (per user request)
                        DB::delete('DELETE FROM users WHERE user_id = ?', [$userRow->user_id]);
                    }
                }
            } catch (\Throwable $e) {
                // On any error (HTTP issues, rate limits, etc.) skip and continue
                continue;
            }
        }
    }
}

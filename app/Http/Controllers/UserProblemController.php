<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProblem;
use App\Models\Problem;

class UserProblemController extends Controller
{
    /**
     * Mark a problem as solved using TRANSACTION for atomicity
     */
    public function markSolved(Request $request, Problem $problem)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'submission_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);

        // Use database transaction to ensure data consistency
        \DB::beginTransaction();
        
        try {
            // Find or create UserProblem record using Eloquent to trigger model events
            $userProblem = UserProblem::firstOrNew([
                'user_id' => $request->user_id,
                'problem_id' => $problem->problem_id
            ]);

            $userProblem->status = 'solved';
            $userProblem->solved_at = now();
            $userProblem->submission_link = $request->submission_link;
            $userProblem->notes = $request->notes;
            $userProblem->save();
            
            // Update problem statistics using stored procedure
            try {
                \DB::statement('CALL update_problem_statistics(?)', [$problem->problem_id]);
            } catch (\Exception $e) {
                // Fallback: manually update if procedure not available
                $problem->updateDynamicFields();
            }

            // Commit transaction if all successful
            \DB::commit();
            return redirect()->back()->with('success', 'Problem marked as solved!');
            
        } catch (\Exception $e) {
            // Rollback transaction on any error
            \DB::rollBack();
            return redirect()->back()->with('error', 'Failed to mark problem as solved: ' . $e->getMessage());
        }
    }

    /**
     * Toggle star on a problem using TRANSACTION
     */
    public function toggleStar(Request $request, Problem $problem)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
        ]);

        // Use database transaction
        \DB::beginTransaction();
        
        try {
            // Check if record exists
            $existing = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [
                $request->user_id,
                $problem->problem_id
            ]);

            if (!empty($existing)) {
                // Toggle the star
                $currentStarred = $existing[0]->is_starred;
                $newStarred = $currentStarred ? 0 : 1;
                \DB::update('UPDATE userproblems SET is_starred = ? WHERE user_id = ? AND problem_id = ?', [
                    $newStarred,
                    $request->user_id,
                    $problem->problem_id
                ]);
                $message = $newStarred ? 'Problem starred!' : 'Star removed!';
            } else {
                // Insert new record with star
                    \DB::insert('INSERT INTO userproblems (user_id, problem_id, status, is_starred, solved_at, submission_link, notes) VALUES (?, ?, ?, 1, NULL, NULL, NULL)', [
                    $request->user_id,
                    $problem->problem_id,
                    'unsolved'
                ]);
                $message = 'Problem starred!';
            }
            
            // Update problem statistics using stored procedure
            try {
                \DB::statement('CALL update_problem_statistics(?)', [$problem->problem_id]);
            } catch (\Exception $e) {
                $problem->updateDynamicFields();
            }

            // Commit transaction
            \DB::commit();
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            // Rollback on error
            \DB::rollBack();
            return redirect()->back()->with('error', 'Failed to toggle star: ' . $e->getMessage());
        }
    }

    /**
     * Update problem status (attempting, solved, etc.)
     */
    public function updateStatus(Request $request, Problem $problem)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'status' => 'required|in:unsolved,attempting,solved',
            'submission_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);

        // Use Eloquent to trigger model events
        $userProblem = UserProblem::firstOrNew([
            'user_id' => $request->user_id,
            'problem_id' => $problem->problem_id
        ]);

        $userProblem->status = $request->status;
        $userProblem->submission_link = $request->submission_link;
        $userProblem->notes = $request->notes;
        
        if ($request->status === 'solved') {
            $userProblem->solved_at = now();
        } else {
            $userProblem->solved_at = null;
        }
        
        $userProblem->save();
        
        // Manually update problem statistics
        $problem->updateDynamicFields();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    /**
     * Show the form for editing user-problem status
     * Authorization: User can only edit their own status or admin can edit any
     */
    public function edit(Problem $problem, $user)
    {
        if (auth()->id() != $user && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Get user using raw SQL
        $userData = \DB::select('SELECT * FROM users WHERE user_id = ? LIMIT 1', [$user]);
        if (empty($userData)) {
            abort(404, 'User not found.');
        }
        $user = \App\Models\User::hydrate($userData)[0];
        
        // Get user problem status using raw SQL
        $userProblemData = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [
            $user->user_id,
            $problem->problem_id
        ]);
        $userProblem = !empty($userProblemData) ? UserProblem::hydrate($userProblemData)[0] : null;

        return view('userproblem.edit', compact('problem', 'user', 'userProblem'));
    }

    /**
     * Update user-problem status and redirect back to problem
     * Authorization: User can only update their own status or admin can update any
     */
    public function update(Request $request, Problem $problem, $user)
    {
        if (auth()->id() != $user && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:unsolved,trying,solved',
            'notes' => 'nullable|string|max:1000',
            'submission_link' => 'nullable|url',
            'is_starred' => 'nullable|boolean',
        ]);

        // Use Eloquent to trigger model events
        $userProblem = UserProblem::firstOrNew([
            'user_id' => $user,
            'problem_id' => $problem->problem_id
        ]);

        $userProblem->status = $request->status;
        $userProblem->notes = $request->notes;
        $userProblem->submission_link = $request->submission_link;
        $userProblem->is_starred = $request->has('is_starred');
        
        if ($request->status === 'solved') {
            $userProblem->solved_at = now();
        } else {
            $userProblem->solved_at = null;
        }
        
        $userProblem->save();
        
        // Manually update problem statistics
        $problem->updateDynamicFields();

        return redirect()->route('problem.show', $problem)->with('success', 'Your problem status has been updated!');
    }
}

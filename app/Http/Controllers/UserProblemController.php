<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProblem;
use App\Models\Problem;

class UserProblemController extends Controller
{
    /**
     * Mark a problem as solved
     */
    public function markSolved(Request $request, Problem $problem)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'submission_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);

        // Check if record exists
        $existing = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [
            $request->user_id,
            $problem->problem_id
        ]);

        if (!empty($existing)) {
            // Update existing record
            \DB::update('UPDATE userproblems SET status = ?, solved_at = NOW(), submission_link = ?, notes = ? WHERE user_id = ? AND problem_id = ?', [
                'solved',
                $request->submission_link,
                $request->notes,
                $request->user_id,
                $problem->problem_id
            ]);
        } else {
            // Insert new record
            \DB::insert('INSERT INTO userproblems (user_id, problem_id, status, solved_at, submission_link, notes, is_starred) VALUES (?, ?, ?, NOW(), ?, ?, 0)', [
                $request->user_id,
                $problem->problem_id,
                'solved',
                $request->submission_link,
                $request->notes
            ]);
        }
        
        // Manually update problem statistics and user counts
        $problem->updateDynamicFields();
        \DB::update('UPDATE users SET solved_problems_count = (SELECT COUNT(*) FROM userproblems WHERE user_id = ? AND status = ?) WHERE user_id = ?', [
            $request->user_id, 'solved', $request->user_id
        ]);

        return redirect()->back()->with('success', 'Problem marked as solved!');
    }

    /**
     * Toggle star on a problem
     */
    public function toggleStar(Request $request, Problem $problem)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
        ]);

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
        
        // Manually update problem statistics (stars and popularity)
        $problem->updateDynamicFields();

        return redirect()->back()->with('success', $message);
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

        $solvedAt = $request->status === 'solved' ? 'NOW()' : 'NULL';

        // Check if record exists
        $existing = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [
            $request->user_id,
            $problem->problem_id
        ]);

        if (!empty($existing)) {
            // Update existing record
            if ($request->status === 'solved') {
                \DB::update('UPDATE userproblems SET status = ?, solved_at = NOW(), submission_link = ?, notes = ? WHERE user_id = ? AND problem_id = ?', [
                    $request->status,
                    $request->submission_link,
                    $request->notes,
                    $request->user_id,
                    $problem->problem_id
                ]);
            } else {
                \DB::update('UPDATE userproblems SET status = ?, solved_at = NULL, submission_link = ?, notes = ? WHERE user_id = ? AND problem_id = ?', [
                    $request->status,
                    $request->submission_link,
                    $request->notes,
                    $request->user_id,
                    $problem->problem_id
                ]);
            }
        } else {
            // Insert new record
            if ($request->status === 'solved') {
                \DB::insert('INSERT INTO userproblems (user_id, problem_id, status, solved_at, submission_link, notes, is_starred) VALUES (?, ?, ?, NOW(), ?, ?, 0)', [
                    $request->user_id,
                    $problem->problem_id,
                    $request->status,
                    $request->submission_link,
                    $request->notes
                ]);
            } else {
                \DB::insert('INSERT INTO userproblems (user_id, problem_id, status, solved_at, submission_link, notes, is_starred) VALUES (?, ?, ?, NULL, ?, ?, 0)', [
                    $request->user_id,
                    $problem->problem_id,
                    $request->status,
                    $request->submission_link,
                    $request->notes
                ]);
            }
        }
        
        // Manually update problem statistics and user counts
        $problem->updateDynamicFields();
        \DB::update('UPDATE users SET solved_problems_count = (SELECT COUNT(*) FROM userproblems WHERE user_id = ? AND status = ?) WHERE user_id = ?', [
            $request->user_id, 'solved', $request->user_id
        ]);

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

        $isStarred = $request->has('is_starred') ? 1 : 0;

        // Check if record exists
        $existing = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [
            $user,
            $problem->problem_id
        ]);

        if (!empty($existing)) {
            // Update existing record
            if ($request->status === 'solved') {
                \DB::update('UPDATE userproblems SET status = ?, solved_at = NOW(), submission_link = ?, notes = ?, is_starred = ? WHERE user_id = ? AND problem_id = ?', [
                    $request->status,
                    $request->submission_link,
                    $request->notes,
                    $isStarred,
                    $user,
                    $problem->problem_id
                ]);
            } else {
                \DB::update('UPDATE userproblems SET status = ?, solved_at = NULL, submission_link = ?, notes = ?, is_starred = ? WHERE user_id = ? AND problem_id = ?', [
                    $request->status,
                    $request->submission_link,
                    $request->notes,
                    $isStarred,
                    $user,
                    $problem->problem_id
                ]);
            }
        } else {
            // Insert new record
            if ($request->status === 'solved') {
                \DB::insert('INSERT INTO userproblems (user_id, problem_id, status, solved_at, submission_link, notes, is_starred) VALUES (?, ?, ?, NOW(), ?, ?, ?)', [
                    $user,
                    $problem->problem_id,
                    $request->status,
                    $request->submission_link,
                    $request->notes,
                    $isStarred
                ]);
            } else {
                \DB::insert('INSERT INTO userproblems (user_id, problem_id, status, solved_at, submission_link, notes, is_starred) VALUES (?, ?, ?, NULL, ?, ?, ?)', [
                    $user,
                    $problem->problem_id,
                    $request->status,
                    $request->submission_link,
                    $request->notes,
                    $isStarred
                ]);
            }
        }
        
        // Manually update problem statistics and user counts
        $problem->updateDynamicFields();
        \DB::update('UPDATE users SET solved_problems_count = (SELECT COUNT(*) FROM userproblems WHERE user_id = ? AND status = ?) WHERE user_id = ?', [
            $user, 'solved', $user
        ]);

        return redirect()->route('problem.show', $problem)->with('success', 'Your problem status has been updated!');
    }
}

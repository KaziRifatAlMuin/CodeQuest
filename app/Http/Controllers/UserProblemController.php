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

        $userProblem = UserProblem::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'problem_id' => $problem->problem_id,
            ],
            [
                'status' => 'solved',
                'solved_at' => now(),
                'submission_link' => $request->submission_link,
                'notes' => $request->notes,
            ]
        );

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

        $userProblem = UserProblem::firstOrCreate(
            [
                'user_id' => $request->user_id,
                'problem_id' => $problem->problem_id,
            ],
            [
                'status' => 'unsolved',
            ]
        );

        $userProblem->is_starred = !$userProblem->is_starred;
        $userProblem->save();

        $message = $userProblem->is_starred ? 'Problem starred!' : 'Star removed!';
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

        $data = [
            'status' => $request->status,
            'submission_link' => $request->submission_link,
            'notes' => $request->notes,
        ];

        if ($request->status === 'solved') {
            $data['solved_at'] = now();
        }

        UserProblem::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'problem_id' => $problem->problem_id,
            ],
            $data
        );

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

        $user = \App\Models\User::findOrFail($user);
        $userProblem = $problem->getUserStatus($user->user_id);

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

        $data = [
            'status' => $request->status,
            'notes' => $request->notes,
            'submission_link' => $request->submission_link,
            'is_starred' => $request->has('is_starred') ? true : false,
        ];

        if ($request->status === 'solved') {
            $data['solved_at'] = now();
        }

        UserProblem::updateOrCreate(
            [
                'user_id' => $user,
                'problem_id' => $problem->problem_id,
            ],
            $data
        );

        return redirect()->route('problem.show', $problem)->with('success', 'Your problem status has been updated!');
    }
}

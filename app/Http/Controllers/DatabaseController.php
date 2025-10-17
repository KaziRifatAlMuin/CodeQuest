<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    // Show as json all users in the database
    public function showUsers()
    {
        $users = DB::table('users')->get();
        return response()->json($users); // Return as JSON
    }

    // Show as json all problems in the database
    public function showProblems()
    {
        $problems = DB::table('problems')->get();
        return response()->json($problems); // Return as JSON
    }

    // Show as json all tags in the database
    public function showTags()
    {
        $tags = DB::table('tags')->get();
        return response()->json($tags); // Return as JSON
    }   

    // Show as json all problem tags in the database
    public function showProblemTags()
    {
        $problemTags = DB::table('problemtags')->get();
        return response()->json($problemTags); // Return as JSON
    }

    // Show as json all user problems in the database
    public function showUserProblems()
    {
        $userProblems = DB::table('userproblems')->get();
        return response()->json($userProblems); // Return as JSON
    }

    // Show as json all user friends in the database
    public function showFriends()
    {
        $friends = DB::table('friends')->get();
        return response()->json($friends); // Return as JSON
    }

    // Show as json all Editorials in the database
    public function showEditorials()
    {
        $editorials = DB::table('editorials')->get();
        return response()->json($editorials); // Return as JSON
    }

    // Show problems in problemset view
    public function showProblemset()
    {
        $problems = DB::table('problems')->get();
        return view('Problems.index', ['problems' => $problems]);
    }

    // Show single problem details
    public function showProblemDetails($id)
    {
        $problem = DB::table('problems')->where('problem_id', $id)->first();
        if (!$problem) {
            return response()->json(['message' => 'Problem not found'], 404);
        }
        return view('Problems.details', ['problem' => $problem]);
    }

    // Show users list view
    public function showUsersList()
    {
        $users = DB::table('users')->get();
        return view('Users.index', ['users' => $users]);
    }

    // Show single user details view
    public function showUserDetails($id)
    {
        $user = DB::table('users')->where('user_id', $id)->first();
        if (!$user) {
            abort(404, 'User not found');
        }
        return view('Users.details', ['user' => $user]);
    }

    // Show leaderboard view
    public function showLeaderboard()
    {
        $users = DB::table('users')
            ->orderBy('cf_max_rating', 'desc')
            ->get();
        return view('Users.leaderboard', ['users' => $users]);
    }

    // Show editorials list view
    public function showEditorialsList()
    {
        $editorials = DB::table('editorials')
            ->join('problems', 'editorials.problem_id', '=', 'problems.problem_id')
            ->join('users', 'editorials.author_id', '=', 'users.user_id')
            ->select(
                'editorials.*',
                'problems.title as problem_title',
                'users.name as author_name'
            )
            ->orderBy('editorials.created_at', 'desc')
            ->get();
        return view('Editorials.index', ['editorials' => $editorials]);
    }

    // Show single editorial details view
    public function showEditorialDetails($id)
    {
        $editorial = DB::table('editorials')
            ->join('problems', 'editorials.problem_id', '=', 'problems.problem_id')
            ->join('users', 'editorials.author_id', '=', 'users.user_id')
            ->select(
                'editorials.*',
                'problems.title as problem_title',
                'problems.rating as problem_rating',
                'problems.problem_link as problem_link',
                'users.name as author_name',
                'users.cf_handle as author_handle'
            )
            ->where('editorials.editorial_id', $id)
            ->first();
        
        if (!$editorial) {
            abort(404, 'Editorial not found');
        }
        return view('Editorials.details', ['editorial' => $editorial]);
    }

    // Show tags list view
    public function showTagsList()
    {
        $tags = DB::table('tags')
            ->leftJoin('problemtags', 'tags.tag_id', '=', 'problemtags.tag_id')
            ->select(
                'tags.*',
                DB::raw('COUNT(problemtags.problem_id) as problem_count')
            )
            ->groupBy('tags.tag_id', 'tags.tag_name')
            ->orderBy('problem_count', 'desc')
            ->get();
        return view('tags', ['tags' => $tags]);
    }
}

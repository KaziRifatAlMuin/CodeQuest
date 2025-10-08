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
        return view('Features.problemset', ['problems' => $problems]);
    }

    // Show single problem details
    public function showProblemDetails($id)
    {
        $problem = DB::table('problems')->where('problem_id', $id)->first();
        if (!$problem) {
            return response()->json(['message' => 'Problem not found'], 404);
        }
        return view('problem.details', ['problem' => $problem]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
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

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TagMasterController extends Controller
{
    public function index()
    {
        // Get tags with problem counts and solved counts for current user
        $tagMasters = DB::select("
            SELECT 
                t.tag_id,
                t.tag_name,
                COUNT(DISTINCT pt.problem_id) as problem_count,
                COUNT(DISTINCT CASE WHEN up.status = 'solved' THEN up.problem_id END) as solved_count
            FROM tags t
            INNER JOIN problemtags pt ON t.tag_id = pt.tag_id
            LEFT JOIN userproblems up ON pt.problem_id = up.problem_id AND up.user_id = ?
            GROUP BY t.tag_id, t.tag_name
            HAVING problem_count > 0
            ORDER BY solved_count DESC, problem_count DESC
        ", [auth()->id()]);

        return view('advanced.tag-masters', compact('tagMasters'));
    }
}

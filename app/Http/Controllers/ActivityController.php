<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        // UNION query combining different activities
        $activities = DB::select("
            SELECT 'solved' as activity_type, u.user_id, u.name as user_name, u.cf_max_rating as user_rating,
                   p.problem_id, p.title as problem_title, p.rating as problem_rating, up.solved_at as activity_date
            FROM userproblems up
            INNER JOIN users u ON up.user_id = u.user_id
            INNER JOIN problems p ON up.problem_id = p.problem_id
            WHERE up.status = 'solved' AND up.solved_at IS NOT NULL
            
            UNION ALL
            
            SELECT 'editorial' as activity_type, u.user_id, u.name as user_name, u.cf_max_rating as user_rating,
                   p.problem_id, p.title as problem_title, p.rating as problem_rating, e.created_at as activity_date
            FROM editorials e
            INNER JOIN users u ON e.author_id = u.user_id
            INNER JOIN problems p ON e.problem_id = p.problem_id
            
            ORDER BY activity_date DESC
            LIMIT 50
        ");

        return view('advanced.activity', compact('activities'));
    }
}

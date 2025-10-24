<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display statistics dashboard using SQL Views
     */
    public function index()
    {
        // Get data from user_statistics_view
        $topUsers = DB::select("
            SELECT * FROM user_statistics_view 
            ORDER BY rating_rank ASC 
            LIMIT 10
        ");

        // Get data from problem_statistics_view
        $topProblems = DB::select("
            SELECT * FROM problem_statistics_view 
            ORDER BY solved_count DESC, popularity DESC 
            LIMIT 10
        ");

        // Overall platform statistics
        $platformStats = DB::select("
            SELECT 
                (SELECT COUNT(*) FROM users) as total_users,
                (SELECT COUNT(*) FROM problems) as total_problems,
                (SELECT COUNT(*) FROM editorials) as total_editorials,
                (SELECT COUNT(*) FROM userproblems WHERE status = 'solved') as total_solutions
        ")[0];

        // Difficulty distribution using CASE and GROUP BY
        $difficultyStats = DB::select("
            SELECT 
                CASE 
                    WHEN rating < 1000 THEN 'Beginner'
                    WHEN rating < 1400 THEN 'Easy'
                    WHEN rating < 1800 THEN 'Medium'
                    WHEN rating < 2200 THEN 'Hard'
                    ELSE 'Expert'
                END as difficulty,
                COUNT(*) as count,
                AVG(solved_count) as avg_solved
            FROM problems
            GROUP BY difficulty
            ORDER BY MIN(rating)
        ");

        // Popular tags
        $popularTags = DB::select("
            SELECT 
                t.tag_name,
                COUNT(DISTINCT pt.problem_id) as problem_count
            FROM tags t
            INNER JOIN problemtags pt ON t.tag_id = pt.tag_id
            GROUP BY t.tag_id, t.tag_name
            ORDER BY problem_count DESC
            LIMIT 10
        ");

        return view('advanced.statistics', compact(
            'topUsers', 
            'topProblems', 
            'platformStats', 
            'difficultyStats',
            'popularTags'
        ));
    }
}

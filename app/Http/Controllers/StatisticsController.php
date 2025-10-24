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

    /**
     * Display user statistics using stored procedures and functions
     */
    public function userStats($id)
    {
        // Get user data
        $user = User::findOrFail($id);

        // Call stored procedure to update user statistics
        DB::statement('CALL update_user_statistics(?)', [$id]);

        // Get user statistics from view
        $userStats = DB::select("
            SELECT * FROM user_statistics_view 
            WHERE user_id = ?
        ", [$id])[0] ?? null;

        // Get user rank using function
        $userRank = DB::select("SELECT get_user_rank(?) as rank", [$id])[0]->rank ?? 0;

        // Get user progress percentage using function
        $progressPercent = DB::select("SELECT get_user_progress(?) as progress", [$id])[0]->progress ?? 0;

        // Get solved problems by difficulty using CASE and GROUP BY
        $solvedByDifficulty = DB::select("
            SELECT 
                CASE 
                    WHEN p.rating < 1000 THEN 'Beginner'
                    WHEN p.rating < 1400 THEN 'Easy'
                    WHEN p.rating < 1800 THEN 'Medium'
                    WHEN p.rating < 2200 THEN 'Hard'
                    ELSE 'Expert'
                END as difficulty,
                COUNT(*) as count,
                MIN(p.rating) as min_rating,
                MAX(p.rating) as max_rating,
                AVG(p.rating) as avg_rating
            FROM userproblems up
            INNER JOIN problems p ON up.problem_id = p.problem_id
            WHERE up.user_id = ? AND up.status = 'solved'
            GROUP BY difficulty
            ORDER BY MIN(p.rating)
        ", [$id]);

        // Get recent activity using UNION
        $recentActivity = DB::select("
            SELECT 'SOLVED' as type, p.title, up.solved_at as date 
            FROM userproblems up
            INNER JOIN problems p ON up.problem_id = p.problem_id
            WHERE up.user_id = ? AND up.status = 'solved'
            UNION ALL
            SELECT 'EDITORIAL' as type, p.title, e.created_at as date
            FROM editorials e
            INNER JOIN problems p ON e.problem_id = p.problem_id
            WHERE e.author_id = ?
            ORDER BY date DESC
            LIMIT 20
        ", [$id, $id]);

        // Get problem-solving streak using DATE functions
        $streakData = DB::select("
            SELECT 
                DATE(solved_at) as solve_date,
                COUNT(*) as problems_solved
            FROM userproblems
            WHERE user_id = ? AND status = 'solved' AND solved_at IS NOT NULL
            GROUP BY DATE(solved_at)
            ORDER BY solve_date DESC
            LIMIT 30
        ", [$id]);

        // Get tags mastered (all problems in tag solved)
        $masteredTags = DB::select("
            SELECT 
                t.tag_name,
                COUNT(DISTINCT up.problem_id) as solved,
                COUNT(DISTINCT pt.problem_id) as total
            FROM tags t
            INNER JOIN problemtags pt ON t.tag_id = pt.tag_id
            LEFT JOIN userproblems up ON pt.problem_id = up.problem_id 
                AND up.user_id = ? AND up.status = 'solved'
            GROUP BY t.tag_id, t.tag_name
            HAVING solved = total AND total > 0
            ORDER BY total DESC
        ", [$id]);

        return view('statistics.user', compact(
            'user',
            'userStats',
            'userRank',
            'progressPercent',
            'solvedByDifficulty',
            'recentActivity',
            'streakData',
            'masteredTags'
        ));
    }

    /**
     * Display problem statistics with detailed analytics
     */
    public function problemStats($id)
    {
        // Get problem data
        $problem = Problem::findOrFail($id);

        // Call stored procedure to update problem statistics
        DB::statement('CALL update_problem_statistics(?)', [$id]);

        // Get problem statistics from view
        $problemStats = DB::select("
            SELECT * FROM problem_statistics_view 
            WHERE problem_id = ?
        ", [$id])[0] ?? null;

        // Get difficulty category using function
        $difficultyCategory = DB::select("
            SELECT get_difficulty_category(rating) as category 
            FROM problems WHERE problem_id = ?
        ", [$id])[0]->category ?? 'Unknown';

        // Get solver distribution by rating using CASE and GROUP BY
        $solverDistribution = DB::select("
            SELECT 
                CASE 
                    WHEN u.cf_max_rating < 1000 THEN '< 1000'
                    WHEN u.cf_max_rating < 1400 THEN '1000-1399'
                    WHEN u.cf_max_rating < 1800 THEN '1400-1799'
                    WHEN u.cf_max_rating < 2200 THEN '1800-2199'
                    ELSE '2200+'
                END as rating_range,
                COUNT(DISTINCT up.user_id) as solver_count
            FROM userproblems up
            INNER JOIN users u ON up.user_id = u.user_id
            WHERE up.problem_id = ? AND up.status = 'solved'
            GROUP BY rating_range
            ORDER BY MIN(u.cf_max_rating)
        ", [$id]);

        // Get solving timeline using DATE functions
        $solvingTimeline = DB::select("
            SELECT 
                DATE_FORMAT(solved_at, '%Y-%m') as month,
                COUNT(*) as solves
            FROM userproblems
            WHERE problem_id = ? AND status = 'solved' AND solved_at IS NOT NULL
            GROUP BY month
            ORDER BY month DESC
            LIMIT 12
        ", [$id]);

        // Get top solvers with details using JOIN
        $topSolvers = DB::select("
            SELECT 
                u.user_id,
                u.name,
                u.cf_handle,
                u.cf_max_rating,
                up.solved_at,
                up.is_starred
            FROM userproblems up
            INNER JOIN users u ON up.user_id = u.user_id
            WHERE up.problem_id = ? AND up.status = 'solved'
            ORDER BY up.solved_at ASC
            LIMIT 10
        ", [$id]);

        // Get related problems using set operations (problems with same tags)
        $relatedProblems = DB::select("
            SELECT DISTINCT p2.problem_id, p2.title, p2.rating, p2.solved_count,
                   COUNT(DISTINCT pt2.tag_id) as common_tags
            FROM problemtags pt1
            INNER JOIN problemtags pt2 ON pt1.tag_id = pt2.tag_id
            INNER JOIN problems p2 ON pt2.problem_id = p2.problem_id
            WHERE pt1.problem_id = ? AND p2.problem_id != ?
            GROUP BY p2.problem_id, p2.title, p2.rating, p2.solved_count
            ORDER BY common_tags DESC, p2.popularity DESC
            LIMIT 5
        ", [$id, $id]);

        return view('statistics.problem', compact(
            'problem',
            'problemStats',
            'difficultyCategory',
            'solverDistribution',
            'solvingTimeline',
            'topSolvers',
            'relatedProblems'
        ));
    }

    /**
     * Display social network statistics
     */
    public function socialStats()
    {
        // Get data from social_network_view
        $socialConnections = DB::select("
            SELECT * FROM social_network_view 
            LIMIT 100
        ");

        // Get users with most followers using ORDER BY and LIMIT
        $topInfluencers = DB::select("
            SELECT user_id, name, cf_handle, followers_count, solved_problems_count
            FROM users
            WHERE followers_count > 0
            ORDER BY followers_count DESC
            LIMIT 20
        ");

        // Get friendship statistics using aggregate functions
        $friendshipStats = DB::select("
            SELECT 
                COUNT(*) as total_connections,
                COUNT(DISTINCT user_id) as users_with_friends,
                COUNT(DISTINCT friend_id) as users_being_followed,
                AVG(friend_count) as avg_friends_per_user
            FROM (
                SELECT user_id, COUNT(*) as friend_count
                FROM friends
                WHERE is_friend = 1
                GROUP BY user_id
            ) as friend_counts
        ")[0] ?? null;

        // Get mutual connections using INTERSECT concept (self-join)
        $mutualConnections = DB::select("
            SELECT 
                f1.user_id,
                u1.name as user_name,
                f1.friend_id,
                u2.name as friend_name
            FROM friends f1
            INNER JOIN friends f2 ON f1.user_id = f2.friend_id AND f1.friend_id = f2.user_id
            INNER JOIN users u1 ON f1.user_id = u1.user_id
            INNER JOIN users u2 ON f1.friend_id = u2.user_id
            WHERE f1.is_friend = 1 AND f2.is_friend = 1
            LIMIT 50
        ");

        return view('statistics.social', compact(
            'socialConnections',
            'topInfluencers',
            'friendshipStats',
            'mutualConnections'
        ));
    }

    /**
     * Bulk update all statistics using stored procedure
     */
    public function bulkUpdate()
    {
        try {
            // Call bulk update procedure
            DB::statement('CALL bulk_update_problem_statistics()');
            
            // Update all user statistics
            $users = User::all();
            foreach ($users as $user) {
                DB::statement('CALL update_user_statistics(?)', [$user->user_id]);
            }

            return redirect()->back()->with('success', 'All statistics updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating statistics: ' . $e->getMessage());
        }
    }
}

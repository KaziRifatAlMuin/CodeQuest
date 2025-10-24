<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $growthSnapshot = DB::select("
            SELECT 
                (SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as new_users_current,
                (SELECT COUNT(*) FROM users WHERE created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as new_users_previous,
                (SELECT COUNT(*) FROM userproblems WHERE status = 'solved' AND solved_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as solves_current,
                (SELECT COUNT(*) FROM userproblems WHERE status = 'solved' AND solved_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as solves_previous
        ")[0] ?? null;

        $changePercentage = function ($previous, $current) {
            if (is_null($previous) || $previous == 0) {
                return $current > 0 ? 100.0 : 0.0;
            }

            return (($current - $previous) / $previous) * 100;
        };

        $growthMetrics = [];
        if ($growthSnapshot) {
            $growthMetrics[] = (object) [
                'metric' => 'New Users (30d)',
                'current_value' => (int) $growthSnapshot->new_users_current,
                'change_percentage' => $changePercentage($growthSnapshot->new_users_previous, $growthSnapshot->new_users_current),
            ];

            $growthMetrics[] = (object) [
                'metric' => 'Problems Solved (30d)',
                'current_value' => (int) $growthSnapshot->solves_current,
                'change_percentage' => $changePercentage($growthSnapshot->solves_previous, $growthSnapshot->solves_current),
            ];
        }

        $weeklyTrendsRaw = DB::select("
            SELECT 
                YEARWEEK(up.solved_at, 1) as week_key,
                MIN(DATE(up.solved_at)) as week_start,
                COUNT(*) as submission_count,
                COUNT(DISTINCT up.user_id) as active_users
            FROM userproblems up
            WHERE up.status = 'solved' AND up.solved_at >= DATE_SUB(CURDATE(), INTERVAL 8 WEEK)
            GROUP BY week_key
            ORDER BY week_start DESC
        ");

        $weeklyTrends = collect($weeklyTrendsRaw)->map(function ($row) {
            $weekStart = $row->week_start ? Carbon::parse($row->week_start) : Carbon::now();

            return (object) [
                'week_start' => $weekStart->format('M d, Y'),
                'submission_count' => (int) ($row->submission_count ?? 0),
                'active_users' => (int) ($row->active_users ?? 0),
            ];
        })->all();

        $dailyActivityRaw = DB::select("
            SELECT 
                timeline.activity_date,
                COALESCE(solves.solved_count, 0) as solved_count,
                COALESCE(new_users.new_users, 0) as new_users
            FROM (
                SELECT DATE_SUB(CURDATE(), INTERVAL seq.day_offset DAY) as activity_date
                FROM (
                    SELECT 0 as day_offset UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL
                    SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13
                ) as seq
            ) timeline
            LEFT JOIN (
                SELECT DATE(solved_at) as activity_date, COUNT(*) as solved_count
                FROM userproblems
                WHERE status = 'solved' AND solved_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
                GROUP BY DATE(solved_at)
            ) solves ON solves.activity_date = timeline.activity_date
            LEFT JOIN (
                SELECT DATE(created_at) as activity_date, COUNT(*) as new_users
                FROM users
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
                GROUP BY DATE(created_at)
            ) new_users ON new_users.activity_date = timeline.activity_date
            ORDER BY timeline.activity_date DESC
        ");

        $dailyActivity = collect($dailyActivityRaw)->map(function ($row) {
            $date = $row->activity_date ? Carbon::parse($row->activity_date) : Carbon::now();

            return (object) [
                'activity_date' => $date->toDateString(),
                'formatted_date' => $date->format('M d, Y'),
                'solved_count' => (int) ($row->solved_count ?? 0),
                'new_users' => (int) ($row->new_users ?? 0),
            ];
        })->all();

        return view('advanced.analytics', [
            'growthMetrics' => $growthMetrics,
            'weeklyTrends' => $weeklyTrends,
            'dailyActivity' => $dailyActivity,
        ]);
    }

    public function leaderboard(Request $request)
    {
        return redirect()->route('leaderboard');
    }
}

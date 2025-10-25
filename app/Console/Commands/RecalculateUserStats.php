<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateUserStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recalculate-user-stats {--user_id= : Recalculate for specific user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate solved problems count and average rating for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user_id');
        
        if ($userId) {
            $this->recalculateForUser($userId);
        } else {
            $this->recalculateForAllUsers();
        }
        
        $this->info('User statistics recalculated successfully!');
    }
    
    private function recalculateForUser($userId)
    {
        $row = DB::select('
            SELECT 
                COUNT(*) as solved_count,
                COALESCE(SUM(problems.rating), 0) as total_rating
            FROM userproblems
            INNER JOIN problems ON userproblems.problem_id = problems.problem_id
            WHERE userproblems.user_id = ? AND userproblems.status = ?
        ', [$userId, 'solved']);
        
        $solvedCount = intval($row[0]->solved_count ?? 0);
        $totalRating = intval($row[0]->total_rating ?? 0);
        $avgRating = $solvedCount > 0 ? ($totalRating / $solvedCount) : 0;
        
        DB::update('
            UPDATE users 
            SET solved_problems_count = ?, average_problem_rating = ? 
            WHERE user_id = ?
        ', [$solvedCount, $avgRating, $userId]);
        
        $this->info("User $userId: solved_count=$solvedCount, avg_rating=$avgRating");
    }
    
    private function recalculateForAllUsers()
    {
        $users = DB::table('users')->select('user_id', 'name')->get();
        
        foreach ($users as $user) {
            $this->recalculateForUser($user->user_id);
        }
    }
}

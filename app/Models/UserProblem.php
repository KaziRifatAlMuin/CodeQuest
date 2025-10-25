<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class UserProblem extends Model
{
    protected $table = 'userproblems';
    protected $primaryKey = 'userproblem_id';
    public $timestamps = true; // Enable timestamps
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'problem_id',
        'status',
        'is_starred',
        'solved_at',
        'submission_link',
        'notes',
    ];

    protected $casts = [
        'is_starred' => 'boolean',
        'solved_at' => 'datetime',
    ];

    /**
     * Relationship: UserProblem belongs to Problem
     */
    public function problem()
    {
        return $this->belongsTo(Problem::class, 'problem_id', 'problem_id');
    }

    /**
     * Relationship: UserProblem belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Boot method to handle model events
     * Automatically updates problem statistics (solved_count, stars, popularity) and user stats
     */
    protected static function boot()
    {
        parent::boot();

        // After creating a UserProblem - update problem popularity & user stats
        static::created(function ($userProblem) {
            $userProblem->updateProblemStats();
            $userProblem->updateUserSolvedCountOnCreate();
        });

        // After updating a UserProblem - update problem popularity & user stats
        static::updated(function ($userProblem) {
            $userProblem->updateProblemStats();
            $userProblem->updateUserSolvedCountOnUpdate();
        });

        // After deleting a UserProblem - update problem popularity & user stats
        static::deleted(function ($userProblem) {
            $userProblem->updateProblemStats();
            $userProblem->updateUserSolvedCountOnDelete();
        });
    }

    /**
     * Update the related problem's statistics (solved_count, stars, popularity)
     */
    protected function updateProblemStats()
    {
        if ($this->problem) {
            $this->problem->updateDynamicFields();
        }
    }

    /**
     * Update user's solved_problems_count when a new solved record is created
     */
    protected function updateUserSolvedCountOnCreate()
    {
        if ($this->status === 'solved') {
            $this->recalculateUserStats();
        }
    }

    /**
     * Recalculate and update user's solved_problems_count and average_problem_rating
     */
    protected function updateUserSolvedCountOnUpdate()
    {
        $originalStatus = $this->getOriginal('status');
        $currentStatus = $this->status;

        if ($originalStatus === $currentStatus) {
            return; // nothing changed
        }

        // Recalculate from scratch to ensure accuracy
        $userId = $this->user_id;

        $row = \DB::select('
            SELECT COUNT(*) as solved_count, COALESCE(SUM(problems.rating), 0) as total_rating
            FROM userproblems
            INNER JOIN problems ON userproblems.problem_id = problems.problem_id
            WHERE userproblems.user_id = ? AND userproblems.status = ?
        ', [$userId, 'solved']);

        $solvedCount = intval($row[0]->solved_count ?? 0);
        $totalRating = intval($row[0]->total_rating ?? 0);
        $avgRating = $solvedCount > 0 ? ($totalRating / $solvedCount) : 0;

        \DB::update('UPDATE users SET solved_problems_count = ?, average_problem_rating = ? WHERE user_id = ?', [
            $solvedCount, $avgRating, $userId
        ]);

        // Handle solved_at timestamp
        if ($originalStatus === 'solved' && $currentStatus !== 'solved') {
            // If changed from solved -> not solved, clear solved_at
            if (!empty($this->userproblem_id)) {
                \DB::update('UPDATE userproblems SET solved_at = NULL WHERE userproblem_id = ?', [$this->userproblem_id]);
            }
        } elseif ($originalStatus !== 'solved' && $currentStatus === 'solved') {
            // If changed from not solved -> solved, set solved_at
            if (!empty($this->userproblem_id)) {
                $now = now();
                \DB::update('UPDATE userproblems SET solved_at = ? WHERE userproblem_id = ? AND solved_at IS NULL', [$now, $this->userproblem_id]);
            }
        }
    }

    /**
     * Update user's solved_problems_count when a solved record is deleted
     */
    protected function updateUserSolvedCountOnDelete()
    {
        // Note: $this->status should still be available on delete
        if ($this->status === 'solved') {
            $this->recalculateUserStats();
        }
    }

    /**
     * Recalculate and persist the user's solved_problems_count and average_problem_rating
     */
    protected function recalculateUserStats()
    {
        $userId = $this->user_id;

        $row = \DB::select('
            SELECT COUNT(*) as solved_count, COALESCE(SUM(problems.rating), 0) as total_rating
            FROM userproblems
            INNER JOIN problems ON userproblems.problem_id = problems.problem_id
            WHERE userproblems.user_id = ? AND userproblems.status = ?
        ', [$userId, 'solved']);

        $solvedCount = intval($row[0]->solved_count ?? 0);
        $totalRating = intval($row[0]->total_rating ?? 0);
        $avgRating = $solvedCount > 0 ? ($totalRating / $solvedCount) : 0;

        \DB::update('UPDATE users SET solved_problems_count = ?, average_problem_rating = ? WHERE user_id = ?', [
            $solvedCount, $avgRating, $userId
        ]);
    }
}

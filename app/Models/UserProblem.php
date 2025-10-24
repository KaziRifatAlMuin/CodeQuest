<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class UserProblem extends Model
{
    protected $table = 'userproblems';
    protected $primaryKey = 'userproblem_id';
    public $timestamps = false; // Table doesn't have created_at/updated_at columns
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
     * Increment user's solved_problems_count when a new solved record is created
     */
    protected function updateUserSolvedCountOnCreate()
    {
        if ($this->status === 'solved' && $this->user) {
            \DB::update('UPDATE users SET solved_problems_count = solved_problems_count + 1 WHERE user_id = ?', [$this->user->user_id]);
            $this->updateUserAverageProblemRating();
        }
    }

    /**
     * Adjust user's solved_problems_count when a record's status is updated
     */
    protected function updateUserSolvedCountOnUpdate()
    {
        if (!$this->user) {
            return;
        }

        $originalStatus = $this->getOriginal('status');
        $currentStatus = $this->status;

        if ($originalStatus === $currentStatus) {
            return; // nothing changed
        }

        // If changed from solved -> not solved => decrement
        if ($originalStatus === 'solved' && $currentStatus !== 'solved') {
            // Decrement but avoid negative counts
            \DB::update('UPDATE users SET solved_problems_count = GREATEST(solved_problems_count - 1, 0) WHERE user_id = ?', [$this->user->user_id]);

            // If the status changed from solved -> not solved, clear solved_at on this record
            if (!empty($this->userproblem_id)) {
                \DB::update('UPDATE userproblems SET solved_at = NULL WHERE userproblem_id = ?', [$this->userproblem_id]);
            }

            $this->updateUserAverageProblemRating();
            return;
        }

        // If changed from not solved -> solved => increment
        if ($originalStatus !== 'solved' && $currentStatus === 'solved') {
            \DB::update('UPDATE users SET solved_problems_count = solved_problems_count + 1 WHERE user_id = ?', [$this->user->user_id]);

            // Ensure this record has a solved_at timestamp (in case it wasn't set)
            if (!empty($this->userproblem_id)) {
                $now = now();
                \DB::update('UPDATE userproblems SET solved_at = ? WHERE userproblem_id = ? AND solved_at IS NULL', [$now, $this->userproblem_id]);
            }

            $this->updateUserAverageProblemRating();
            return;
        }
    }

    /**
     * Adjust user's solved_problems_count when a solved record is deleted
     */
    protected function updateUserSolvedCountOnDelete()
    {
        // Note: $this->status should still be available on delete
        if ($this->status === 'solved' && $this->user) {
            \DB::update('UPDATE users SET solved_problems_count = GREATEST(solved_problems_count - 1, 0) WHERE user_id = ?', [$this->user->user_id]);
            $this->updateUserAverageProblemRating();
        }
    }

    /**
     * Recalculate and persist the user's average_problem_rating (integer)
     * Calculation: integer(sum(problem.rating for all solved problems) / solved_count)
     */
    protected function updateUserAverageProblemRating()
    {
        if (!$this->user) {
            return;
        }

        $userId = $this->user->user_id;

        $row = \DB::select('
            SELECT COALESCE(SUM(problems.rating), 0) as total_rating, COUNT(*) as solved_count
            FROM userproblems
            INNER JOIN problems ON userproblems.problem_id = problems.problem_id
            WHERE userproblems.user_id = ? AND userproblems.status = ?
        ', [$userId, 'solved']);

        $total = intval($row[0]->total_rating ?? 0);
        $count = intval($row[0]->solved_count ?? 0);

        $avg = 0;
        if ($count > 0) {
            // integer result as requested
            $avg = intdiv($total, $count);
        }

        \DB::update('UPDATE users SET average_problem_rating = ? WHERE user_id = ?', [$avg, $userId]);
    }
}

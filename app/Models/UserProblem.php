<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
     */
    protected static function boot()
    {
        parent::boot();

        // After creating a UserProblem
        static::created(function ($userProblem) {
            $userProblem->updateProblemStats();
        });

        // After updating a UserProblem
        static::updated(function ($userProblem) {
            $userProblem->updateProblemStats();
        });

        // After deleting a UserProblem
        static::deleted(function ($userProblem) {
            $userProblem->updateProblemStats();
        });
    }

    /**
     * Update the related problem's statistics
     */
    protected function updateProblemStats()
    {
        if ($this->problem) {
            $this->problem->updateDynamicFields();
        }
    }
}

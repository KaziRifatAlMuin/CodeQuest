<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProblem extends Model
{
    protected $table = 'userproblems';
    
    protected $fillable = [
        'user_id',
        'problem_id',
        'status',
        'is_starred',
        'solved_at',
        'submission_link',
        'notes',
    ];
}

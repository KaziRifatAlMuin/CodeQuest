<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProblem extends Model
{
    protected $table = 'userproblems';
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
}

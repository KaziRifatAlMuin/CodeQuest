<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class problem extends Model
{
    protected $fillable = [
        'title',
        'problem_link',
        'rating',
        'solved_count',
        'stars',
        'popularity',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Problem extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'problem_link',
        'rating',
        'solved_count',
        'stars',
        'popularity',
    ];
}

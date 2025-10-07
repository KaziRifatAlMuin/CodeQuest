<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $fillable = [
        'problem_id',
        'author_id',
        'solution',
        'code',
        'upvotes',
        'downvotes',
    ];
}

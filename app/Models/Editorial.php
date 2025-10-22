<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Editorial extends Model
{
    use HasFactory;
    protected $fillable = [
        'problem_id',
        'author_id',
        'solution',
        'code',
        'upvotes',
        'downvotes',
    ];
}

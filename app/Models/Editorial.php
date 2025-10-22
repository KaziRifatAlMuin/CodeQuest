<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Editorial extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'editorial_id';
    
    protected $fillable = [
        'problem_id',
        'author_id',
        'solution',
        'code',
        'upvotes',
        'downvotes',
    ];

    /**
     * Relationship: Editorial belongs to a Problem
     */
    public function problem()
    {
        return $this->belongsTo(Problem::class, 'problem_id', 'problem_id');
    }

    /**
     * Relationship: Editorial belongs to an Author (User)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }
}

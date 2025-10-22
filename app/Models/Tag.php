<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tag_name',
    ];

    /**
     * Disable timestamps since migration doesn't include created_at/updated_at
     */
    public $timestamps = false;

    /**
     * Primary key for tags table is tag_id (not id)
     */
    protected $primaryKey = 'tag_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Get all problems associated with this tag
     */
    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'problemtags', 'tag_id', 'problem_id');
    }

    /**
     * Get the problem tags pivot records
     */
    public function problemTags()
    {
        return $this->hasMany(ProblemTag::class, 'tag_id');
    }

    /**
     * Get the count of problems using this tag
     */
    public function getProblemsCountAttribute()
    {
        return $this->problems()->count();
    }
}

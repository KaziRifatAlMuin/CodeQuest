<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProblemTag extends Model
{
    use HasFactory;
    
    protected $table = 'problemtags';
    
    protected $fillable = [
        'problem_id',
        'tag_id',
    ];
    
    public $timestamps = false;

    /**
     * Get the problem that this pivot belongs to
     */
    public function problem()
    {
        return $this->belongsTo(Problem::class, 'problem_id', 'problem_id');
    }

    /**
     * Get the tag that this pivot belongs to
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}

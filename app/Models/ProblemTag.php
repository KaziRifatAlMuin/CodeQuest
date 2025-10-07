<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemTag extends Model
{
    protected $table = 'problemtags';
    
    protected $fillable = [
        'problem_id',
        'tag_id',
    ];
    
    public $timestamps = false;
}

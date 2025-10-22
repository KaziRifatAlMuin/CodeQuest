<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProblemTag extends Model
{
    protected $table = 'problemtags';
    use HasFactory;
    protected $fillable = [
        'problem_id',
        'tag_id',
    ];
    
    public $timestamps = false;
}

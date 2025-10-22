<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Problem extends Model
{
    use HasFactory;

    protected $primaryKey = 'problem_id';

    protected $fillable = [
        'title',
        'problem_link',
        'rating',
        'solved_count',
        'stars',
        'popularity',
    ];

    /**
     * Relationship: Problem has many UserProblems
     */
    public function userProblems()
    {
        return $this->hasMany(UserProblem::class, 'problem_id', 'problem_id');
    }

    /**
     * Get users who solved this problem
     */
    public function solvedByUsers()
    {
        return $this->hasMany(UserProblem::class, 'problem_id', 'problem_id')
                    ->where('status', 'solved');
    }

    /**
     * Get users who starred this problem
     */
    public function starredByUsers()
    {
        return $this->hasMany(UserProblem::class, 'problem_id', 'problem_id')
                    ->where('is_starred', true);
    }

    /**
     * Update solved count dynamically
     */
    public function updateSolvedCount()
    {
        $this->solved_count = $this->solvedByUsers()->count();
        $this->save();
    }

    /**
     * Update stars count dynamically
     */
    public function updateStarsCount()
    {
        $this->stars = $this->starredByUsers()->count();
        $this->save();
    }

    /**
     * Update popularity (stars / solved_count ratio)
     */
    public function updatePopularity()
    {
        $solved = $this->solved_count ?? 0;
        $stars = $this->stars ?? 0;
        
        if ($solved > 0) {
            $this->popularity = round($stars / $solved, 3);
        } else {
            $this->popularity = 0;
        }
        
        $this->save();
    }

    /**
     * Update all dynamic fields
     */
    public function updateDynamicFields()
    {
        $this->updateSolvedCount();
        $this->updateStarsCount();
        $this->updatePopularity();
    }

    /**
     * Relationship: Problem has many Editorials
     */
    public function editorials()
    {
        return $this->hasMany(Editorial::class, 'problem_id', 'problem_id');
    }
}

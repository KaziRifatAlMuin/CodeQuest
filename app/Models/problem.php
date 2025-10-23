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
     * Update all dynamic fields efficiently in a single query
     */
    public function updateDynamicFields()
    {
        // Count solved users
        $solvedCount = $this->solvedByUsers()->count();
        
        // Count starred users
        $starsCount = $this->starredByUsers()->count();
        
        // Calculate popularity (stars / max stars across all problems)
        // Get the maximum stars count from all problems
        $maxStars = \DB::table('problems')->max('stars') ?? 1;
        
        $popularity = 0;
        if ($maxStars > 0) {
            // Store as decimal (0.0 to 1.0), will be displayed as percentage
            $popularity = round($starsCount / $maxStars, 4);
        }
        
        // Update all fields in a single query (more efficient)
        $this->update([
            'solved_count' => $solvedCount,
            'stars' => $starsCount,
            'popularity' => $popularity,
        ]);
    }

    /**
     * Get popularity as percentage with 2 decimal places (0.00-100.00)
     */
    public function getPopularityPercentageAttribute()
    {
        return number_format($this->popularity * 100, 2);
    }

    /**
     * Relationship: Problem has many Editorials
     */
    public function editorials()
    {
        return $this->hasMany(Editorial::class, 'problem_id', 'problem_id');
    }

    /**
     * Get all tags associated with this problem
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'problemtags', 'problem_id', 'tag_id');
    }

    /**
     * Get the problem tags pivot records
     */
    public function problemTags()
    {
        return $this->hasMany(ProblemTag::class, 'problem_id', 'problem_id');
    }

    /**
     * Get user-specific problem status
     */
    public function getUserStatus($userId)
    {
        return $this->userProblems()
                    ->where('user_id', $userId)
                    ->first();
    }
}

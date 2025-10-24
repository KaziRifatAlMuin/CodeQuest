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
        $count = \DB::select('SELECT COUNT(*) as total FROM userproblems WHERE problem_id = ? AND status = ?', [$this->problem_id, 'solved'])[0]->total;
        \DB::update('UPDATE problems SET solved_count = ?, updated_at = NOW() WHERE problem_id = ?', [$count, $this->problem_id]);
        $this->solved_count = $count;
    }

    /**
     * Update stars count dynamically
     */
    public function updateStarsCount()
    {
        $count = \DB::select('SELECT COUNT(*) as total FROM userproblems WHERE problem_id = ? AND is_starred = 1', [$this->problem_id])[0]->total;
        \DB::update('UPDATE problems SET stars = ?, updated_at = NOW() WHERE problem_id = ?', [$count, $this->problem_id]);
        $this->stars = $count;
    }

    /**
     * Update popularity (stars / solved_count ratio)
     */
    public function updatePopularity()
    {
        $solved = $this->solved_count ?? 0;
        $stars = $this->stars ?? 0;
        
        $popularity = 0;
        if ($solved > 0) {
            $popularity = round($stars / $solved, 3);
        }
        
        \DB::update('UPDATE problems SET popularity = ?, updated_at = NOW() WHERE problem_id = ?', [$popularity, $this->problem_id]);
        $this->popularity = $popularity;
    }

    /**
     * Update all dynamic fields efficiently in a single query
     */
    public function updateDynamicFields()
    {
        // Count solved users
        $solvedCount = \DB::select('SELECT COUNT(*) as total FROM userproblems WHERE problem_id = ? AND status = ?', [$this->problem_id, 'solved'])[0]->total;
        
        // Count starred users
        $starsCount = \DB::select('SELECT COUNT(*) as total FROM userproblems WHERE problem_id = ? AND is_starred = 1', [$this->problem_id])[0]->total;
        
        // Calculate popularity (stars / max stars across all problems)
        // Get the maximum stars count from all problems
        $maxStars = \DB::select('SELECT MAX(stars) as max_stars FROM problems')[0]->max_stars ?? 1;
        
        $popularity = 0;
        if ($maxStars > 0) {
            // Store as decimal (0.0 to 1.0), will be displayed as percentage
            $popularity = round($starsCount / $maxStars, 4);
        }
        
        // Update all fields in a single query (more efficient)
        \DB::update('UPDATE problems SET solved_count = ?, stars = ?, popularity = ?, updated_at = NOW() WHERE problem_id = ?', [
            $solvedCount,
            $starsCount,
            $popularity,
            $this->problem_id
        ]);
        
        // Update local properties
        $this->solved_count = $solvedCount;
        $this->stars = $starsCount;
        $this->popularity = $popularity;
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
        $userProblemData = \DB::select('SELECT * FROM userproblems WHERE problem_id = ? AND user_id = ? LIMIT 1', [$this->problem_id, $userId]);
        return !empty($userProblemData) ? \App\Models\UserProblem::hydrate($userProblemData)[0] : null;
    }
}

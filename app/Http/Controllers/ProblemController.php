<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource with filters
     */
    public function index(Request $request)
    {
        // Get all tags for filter options
        $tags = \App\Models\Tag::orderBy('tag_name', 'asc')->get();

        // Start query
        $problemsQuery = Problem::with('tags');

        // Filter by tags
        $selectedTags = $request->input('tags', []);
        if (!empty($selectedTags)) {
            $problemsQuery->whereHas('tags', function($query) use ($selectedTags) {
                $query->whereIn('tags.tag_id', $selectedTags);
            });
        }

        // Filter by rating range
        $minRating = $request->input('min_rating');
        $maxRating = $request->input('max_rating');
        
        if ($minRating !== null && $minRating !== '') {
            $problemsQuery->where('rating', '>=', $minRating);
        }
        
        if ($maxRating !== null && $maxRating !== '') {
            $problemsQuery->where('rating', '<=', $maxRating);
        }

        // Filter by starred only (for current user)
        $showStarred = $request->input('starred', false);
        if ($showStarred && auth()->check()) {
            $problemsQuery->whereHas('userProblems', function($query) {
                $query->where('user_id', auth()->id())
                      ->where('is_starred', true);
            });
        }

        $problems = $problemsQuery->orderBy('created_at', 'desc')->paginate(20);

        return view('problem.index', compact('problems', 'tags', 'selectedTags', 'showStarred'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = \App\Models\Tag::orderBy('tag_name', 'asc')->get();
        return view('problem.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'problem_link' => 'required|url',
            'rating' => 'required|integer|min:0|max:3500',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,tag_id',
        ]);

        // Initialize dynamic fields to 0
        $data['solved_count'] = 0;
        $data['stars'] = 0;
        $data['popularity'] = 0;

        // Extract tags before creating problem
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $problem = Problem::create($data);

        // Sync tags with the problem
        if (!empty($tags)) {
            $problem->tags()->sync($tags);
        }

        return redirect()->route('problem.index')->with('success', 'Problem created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Problem $problem)
    {
        $problem->load('tags');
        return view('problem.show', compact('problem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Problem $problem)
    {
        $tags = \App\Models\Tag::orderBy('tag_name', 'asc')->get();
        $problem->load('tags');
        return view('problem.edit', compact('problem', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Problem $problem)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'problem_link' => 'required|url',
            'rating' => 'required|integer|min:0|max:3500',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,tag_id',
        ]);

        // Don't allow manual update of solved_count, stars, or popularity
        // These are updated automatically via UserProblem events

        // Extract tags before updating problem
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $problem->update($data);

        // Sync tags with the problem
        $problem->tags()->sync($tags);

        return redirect()->route('problem.index')->with('success', 'Problem updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Problem $problem)
    {
        $problem->delete();
        return redirect()->route('problem.index')->with('success', 'Problem deleted successfully.');
    }
}

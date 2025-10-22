<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Problem;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource with tag statistics and filtering
     */
    public function index(Request $request)
    {
        // Get all tags with their problem counts
        $tags = Tag::withCount('problems')
            ->orderBy('tag_name', 'asc')
            ->get();

        // Get tag statistics for pie chart (ranked by problem_count desc)
        $tagStats = Tag::select('tags.tag_id', 'tags.tag_name', DB::raw('COUNT(problemtags.problem_id) as problem_count'))
            ->leftJoin('problemtags', 'tags.tag_id', '=', 'problemtags.tag_id')
            ->groupBy('tags.tag_id', 'tags.tag_name')
            ->orderBy('problem_count', 'desc')
            ->get();

        // Build chart colors by rank using 5 groups (0..4) each with 10 shades -> 50 colors
        $paletteGroups = [
            // soft blue group
            ['#E8F6FF','#DAF2FF','#D1F0FF','#C7EEFF','#BDEBFF','#DFF7F0','#E6FBF5','#F0FEF9','#EAF7FF','#E8F0FF'],
            // soft purple group
            ['#F5E8FF','#F0E1FF','#EBD9FF','#E6D1FF','#F6EAF9','#FFF0F6','#FFEFF8','#FCEFF5','#F8E6FF','#F3DFFF'],
            // soft yellow/amber group
            ['#FFF9E6','#FFF5D1','#FFF0B8','#FFF6DF','#FFF7E6','#FFFBE6','#FFF6CC','#FFF8D9','#FFF3CC','#FFF0E0'],
            // soft green group
            ['#E8FFF0','#DFFFE6','#D1FFEA','#CCFFF0','#E6FFF5','#E8FFF7','#F0FFF7','#EAFEF5','#E0FFF0','#D8FFF0'],
            // soft lavender/other pastels
            ['#F0E8FF','#EDE8FF','#F5EAF7','#EDEFFB','#F3E8FF','#F6F0FF','#EEF0FF','#F0F2FF','#F7F0FF','#F2EAF7'],
        ];

        $chartColors = [];
        foreach ($tagStats as $index => $t) {
            $rank = $index; // 0-based rank (0 = most used)
            $group = $rank % 5; // group index (0..4)
            $shade = (int) floor($rank / 5) % 10; // shade index 0..9
            $chartColors[] = $paletteGroups[$group][$shade];
        }

        // Filter problems based on selected tags
        $selectedTags = $request->input('tags', []);
        $filterMode = $request->input('mode', 'single'); // single or multiple
        $filterLogic = $request->input('logic', 'OR'); // OR or AND
        $showTags = $request->input('show_tags', 'yes'); // yes or no

        $problemsQuery = Problem::query();

        if (!empty($selectedTags)) {
            if ($filterMode === 'single' || $filterLogic === 'OR') {
                // Single select or OR logic: problems having ANY of the selected tags
                $problemsQuery->whereHas('tags', function($query) use ($selectedTags) {
                    $query->whereIn('tags.tag_id', $selectedTags);
                });
            } else {
                // Multiple select with AND logic: problems having ALL selected tags
                foreach ($selectedTags as $tagId) {
                    $problemsQuery->whereHas('tags', function($query) use ($tagId) {
                        $query->where('tags.tag_id', $tagId);
                    });
                }
            }
        }

        $problems = $problemsQuery->with('tags')->orderBy('created_at', 'desc')->paginate(20);

    return view('tag.index', compact('tags', 'tagStats', 'problems', 'selectedTags', 'filterMode', 'filterLogic', 'showTags', 'chartColors'));
    }

    /**
     * Admin listing of tags (for admin dashboard)
     */
    public function adminIndex()
    {
        // Only admins should reach here (route middleware enforces it)
        $tags = Tag::withCount('problems')->orderByDesc('problems_count')->paginate(30);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Manage a tag from admin dashboard (edit/delete)
     */
    public function manage(Tag $tag)
    {
        // Route middleware ensures only admins access this
        return view('tag.manage', compact('tag'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user is admin or moderator
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is admin or moderator
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name',
        ]);

        Tag::create($data);

        return redirect()->route('tag.index')->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $problems = $tag->problems()->with('tags')->paginate(20);
        return view('tag.show', compact('tag', 'problems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        // Check if user is admin or moderator
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        // Check if user is admin or moderator
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name,' . $tag->tag_id,
        ]);

        $tag->update($data);

        return redirect()->route('tag.index')->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Only admins can delete tags
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Delete the tag (problems will show null tags, not cascade delete)
        $tag->delete();

        return redirect()->route('tag.index')->with('success', 'Tag deleted successfully.');
    }
}

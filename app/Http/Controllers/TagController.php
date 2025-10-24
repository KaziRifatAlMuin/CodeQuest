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
        // Get all tags with their problem counts using raw SQL
        $tagsData = \DB::select('
            SELECT t.*, COUNT(pt.problem_id) as problems_count
            FROM tags t
            LEFT JOIN problemtags pt ON t.tag_id = pt.tag_id
            GROUP BY t.tag_id, t.tag_name
            ORDER BY t.tag_name ASC
        ');
        $tags = Tag::hydrate($tagsData);

        // Get tag statistics for pie chart (ranked by problem_count desc)
        $tagStats = \DB::select('
            SELECT tags.tag_id, tags.tag_name, COUNT(problemtags.problem_id) as problem_count
            FROM tags
            LEFT JOIN problemtags ON tags.tag_id = problemtags.tag_id
            GROUP BY tags.tag_id, tags.tag_name
            ORDER BY problem_count DESC
        ');
        $tagStats = Tag::hydrate($tagStats);

        // Build chart colors using 5 groups cycling by rank
        $colorGroups = [
            ['#E8F6FF', '#DAF2FF', '#D1F0FF', '#C7EEFF', '#BDEBFF', '#DFF7F0', '#E6FBF5', '#F0FEF9', '#EAF7FF', '#E8F0FF'],
            ['#F5E8FF', '#F0E1FF', '#EBD9FF', '#E6D1FF', '#F6EAF9', '#FFF0F6', '#FFEFF8', '#FCEFF5', '#F8E6FF', '#F3DFFF'],
            ['#FFF9E6', '#FFF5D1', '#FFF0B8', '#FFF6DF', '#FFF7E6', '#FFFBE6', '#FFF6CC', '#FFF8D9', '#FFF3CC', '#FFF0E0'],
            ['#E8FFF0', '#DFFFE6', '#D1FFEA', '#CCFFF0', '#E6FFF5', '#E8FFF7', '#F0FFF7', '#EAFEF5', '#E0FFF0', '#D8FFF0'],
            ['#F0E8FF', '#EDE8FF', '#F5EAF7', '#EDEFFB', '#F3E8FF', '#F6F0FF', '#EEF0FF', '#F0F2FF', '#F7F0FF', '#F2EAF7'],
        ];

        $chartColors = [];
        foreach ($tagStats as $rank => $tag) {
            $groupIndex = $rank % 5;
            $shadeIndex = (int) floor($rank / 5) % 10;
            $chartColors[] = $colorGroups[$groupIndex][$shadeIndex];
        }

        // Filter problems based on selected tags
        $selectedTags = $request->input('tags', []);
        $filterMode = $request->input('mode', 'single');
        $filterLogic = $request->input('logic', 'OR');
        $showTags = $request->input('show_tags', 'yes');

        $whereConditions = [];
        $params = [];

        if (!empty($selectedTags)) {
            if ($filterMode === 'single' || $filterLogic === 'OR') {
                $placeholders = implode(',', array_fill(0, count($selectedTags), '?'));
                $whereConditions[] = "p.problem_id IN (SELECT problem_id FROM problemtags WHERE tag_id IN ($placeholders))";
                $params = array_merge($params, $selectedTags);
            } else {
                // AND logic: problems having ALL selected tags
                foreach ($selectedTags as $tagId) {
                    $whereConditions[] = "p.problem_id IN (SELECT problem_id FROM problemtags WHERE tag_id = ?)";
                    $params[] = $tagId;
                }
            }
        }

        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
        
        // Get total count for pagination
        $totalCount = \DB::select("SELECT COUNT(*) as total FROM problems p $whereClause", $params)[0]->total;
        
        // Get paginated results
        $perPage = 20;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $problemsData = \DB::select("
            SELECT p.* FROM problems p
            $whereClause
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?
        ", array_merge($params, [$perPage, $offset]));
        
        $problems = Problem::hydrate($problemsData);
        
        // Load tags for each problem
        foreach ($problems as $problem) {
            $problemTags = \DB::select('
                SELECT t.* FROM tags t
                INNER JOIN problemtags pt ON t.tag_id = pt.tag_id
                WHERE pt.problem_id = ?
            ', [$problem->problem_id]);
            $problem->setRelation('tags', Tag::hydrate($problemTags));
        }
        
        // Create pagination manually
        $problems = new \Illuminate\Pagination\LengthAwarePaginator(
            $problems,
            $totalCount,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('tag.index', compact('tags', 'tagStats', 'problems', 'selectedTags', 'filterMode', 'filterLogic', 'showTags', 'chartColors'));
    }

    /**
     * Admin listing of tags (for admin dashboard)
     */
    public function adminIndex()
    {
        // Get tags with problem counts using raw SQL
        $perPage = 30;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $tagsData = \DB::select('
            SELECT t.*, COUNT(pt.problem_id) as problems_count
            FROM tags t
            LEFT JOIN problemtags pt ON t.tag_id = pt.tag_id
            GROUP BY t.tag_id, t.tag_name
            ORDER BY problems_count DESC
            LIMIT ? OFFSET ?
        ', [$perPage, $offset]);
        
        $totalTags = \DB::select('SELECT COUNT(*) as total FROM tags')[0]->total;
        $tags = Tag::hydrate($tagsData);
        
        // Create pagination manually
        $tags = new \Illuminate\Pagination\LengthAwarePaginator(
            $tags,
            $totalTags,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('tag.admin_index', compact('tags'));
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
     * Authorization: checkRole middleware
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     * Authorization: checkRole middleware
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name',
        ]);

        // Insert tag using raw SQL
        \DB::insert('INSERT INTO tags (tag_name) VALUES (?)', [$data['tag_name']]);

        return redirect()->route('tag.index')->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        // Get problems for this tag with pagination
        $perPage = 20;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $problemsData = \DB::select('
            SELECT p.* FROM problems p
            INNER JOIN problemtags pt ON p.problem_id = pt.problem_id
            WHERE pt.tag_id = ?
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?
        ', [$tag->tag_id, $perPage, $offset]);
        
        $totalProblems = \DB::select('
            SELECT COUNT(*) as total FROM problems p
            INNER JOIN problemtags pt ON p.problem_id = pt.problem_id
            WHERE pt.tag_id = ?
        ', [$tag->tag_id])[0]->total;
        
        $problems = Problem::hydrate($problemsData);
        
        // Load tags for each problem
        foreach ($problems as $problem) {
            $problemTags = \DB::select('
                SELECT t.* FROM tags t
                INNER JOIN problemtags pt ON t.tag_id = pt.tag_id
                WHERE pt.problem_id = ?
            ', [$problem->problem_id]);
            $problem->setRelation('tags', Tag::hydrate($problemTags));
        }
        
        // Create pagination manually
        $problems = new \Illuminate\Pagination\LengthAwarePaginator(
            $problems,
            $totalProblems,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('tag.show', compact('tag', 'problems'));
    }

    /**
     * Show the form for editing the specified resource.
     * Authorization: checkRole middleware
     */
    public function edit(Tag $tag)
    {
        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     * Authorization: checkRole middleware
     */
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name,' . $tag->tag_id . ',tag_id',
        ]);

        // Update tag using raw SQL
        \DB::update('UPDATE tags SET tag_name = ? WHERE tag_id = ?', [$data['tag_name'], $tag->tag_id]);

        return redirect()->route('tag.index')->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * Authorization: checkRole middleware
     */
    public function destroy(Tag $tag)
    {
        // Delete related problem tags first
        \DB::delete('DELETE FROM problemtags WHERE tag_id = ?', [$tag->tag_id]);
        
        // Delete the tag
        \DB::delete('DELETE FROM tags WHERE tag_id = ?', [$tag->tag_id]);
        
        return redirect()->route('tag.index')->with('success', 'Tag deleted successfully.');
    }
}

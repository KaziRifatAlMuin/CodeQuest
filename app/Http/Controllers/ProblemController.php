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
        // Get all tags for filter options using raw SQL
        $tagsData = \DB::select('SELECT * FROM tags ORDER BY tag_name ASC');
        $tags = \App\Models\Tag::hydrate($tagsData);

    // Get sorting parameters (default to created date)
    $sort = $request->input('sort', 'created');
        $direction = $request->input('direction', 'desc');
        
        // Build SQL query with filters
        $selectedTags = $request->input('tags', []);
        $minRating = $request->input('min_rating');
        $maxRating = $request->input('max_rating');
        $showStarred = $request->input('starred', false);
        $search = $request->input('search', '');
        
        $whereConditions = [];
        $params = [];
        
        // Search functionality using LIKE
        if (!empty($search)) {
            $whereConditions[] = "(p.title LIKE ? OR p.problem_link LIKE ? OR p.problem_id IN (
                SELECT DISTINCT pt.problem_id FROM problemtags pt 
                INNER JOIN tags t ON pt.tag_id = t.tag_id 
                WHERE t.tag_name LIKE ?
            ))";
            $searchPattern = "%{$search}%";
            $params[] = $searchPattern;
            $params[] = $searchPattern;
            $params[] = $searchPattern;
        }
        
        // Filter by tags using IN clause
        if (!empty($selectedTags)) {
            $placeholders = implode(',', array_fill(0, count($selectedTags), '?'));
            $whereConditions[] = "p.problem_id IN (SELECT problem_id FROM problemtags WHERE tag_id IN ($placeholders))";
            $params = array_merge($params, $selectedTags);
        }
        
        // Filter by rating range with BETWEEN
        if ($minRating !== null && $minRating !== '') {
            $whereConditions[] = 'p.rating >= ?';
            $params[] = $minRating;
        }
        
        if ($maxRating !== null && $maxRating !== '') {
            $whereConditions[] = 'p.rating <= ?';
            $params[] = $maxRating;
        }
        
        // Filter by starred only using EXISTS subquery
        if ($showStarred && auth()->check()) {
            $whereConditions[] = 'EXISTS (SELECT 1 FROM userproblems up WHERE up.problem_id = p.problem_id AND up.user_id = ? AND up.is_starred = 1)';
            $params[] = auth()->id();
        }
        
        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
        
        // Validate and set ORDER BY clause
        $validSorts = [
            'title' => 'p.title',
            'rating' => 'p.rating',
            'solved' => 'p.solved_count',
            'stars' => 'p.stars',
            'popularity' => 'p.popularity',
            'created' => 'p.created_at'
        ];
        
        $orderColumn = $validSorts[$sort] ?? 'p.popularity';
        $orderDirection = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        
        // Get total count for pagination using scalar subquery
        $totalCount = \DB::select("SELECT COUNT(*) as total FROM problems p $whereClause", $params)[0]->total;
        
        // Get paginated results with flexible per_page
        $perPage = \App\Helpers\SearchHelper::getPerPage($request->input('per_page', 25));
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        // Complex query with multiple JOINs and aggregations
        $problemsData = \DB::select("
            SELECT DISTINCT p.* FROM problems p
            $whereClause
            ORDER BY $orderColumn $orderDirection
            LIMIT ? OFFSET ?
        ", array_merge($params, [$perPage, $offset]));
        
        $problems = Problem::hydrate($problemsData);
        
        // Load tags for each problem using LEFT JOIN
        foreach ($problems as $problem) {
            $problemTags = \DB::select('
                SELECT t.* FROM tags t
                LEFT JOIN problemtags pt ON t.tag_id = pt.tag_id
                WHERE pt.problem_id = ?
                ORDER BY t.tag_name
            ', [$problem->problem_id]);
            $problem->setRelation('tags', \App\Models\Tag::hydrate($problemTags));
        }
        
        // Create pagination manually
        $problems = new \Illuminate\Pagination\LengthAwarePaginator(
            $problems,
            $totalCount,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('problem.index', compact('problems', 'tags', 'selectedTags', 'showStarred', 'search', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tagsData = \DB::select('SELECT * FROM tags ORDER BY tag_name ASC');
        $tags = \App\Models\Tag::hydrate($tagsData);
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

        // Extract tags before creating problem
        $tags = $data['tags'] ?? [];

        // Insert problem using raw SQL
        \DB::insert('INSERT INTO problems (title, problem_link, rating, solved_count, stars, popularity, created_at, updated_at) VALUES (?, ?, ?, 0, 0, 0, NOW(), NOW())', [
            $data['title'],
            $data['problem_link'],
            $data['rating']
        ]);
        
        // Get the last inserted problem
        $problemData = \DB::select('SELECT * FROM problems WHERE problem_link = ? ORDER BY problem_id DESC LIMIT 1', [$data['problem_link']]);
        $problem = Problem::hydrate($problemData)[0];

        // Sync tags with the problem
        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                \DB::insert('INSERT INTO problemtags (problem_id, tag_id) VALUES (?, ?)', [$problem->problem_id, $tagId]);
            }
        }

        return redirect()->route('problem.index')->with('success', 'Problem created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Problem $problem)
    {
        // Load tags for the problem
        $problemTags = \DB::select('
            SELECT t.* FROM tags t
            INNER JOIN problemtags pt ON t.tag_id = pt.tag_id
            WHERE pt.problem_id = ?
        ', [$problem->problem_id]);
        $problem->setRelation('tags', \App\Models\Tag::hydrate($problemTags));
        
        // Get submission history - all users who solved this problem
        $submissions = \DB::select('
            SELECT 
                up.user_id,
                up.solved_at,
                up.submission_link,
                up.notes,
                u.name as user_name,
                u.cf_handle,
                u.cf_max_rating
            FROM userproblems up
            INNER JOIN users u ON up.user_id = u.user_id
            WHERE up.problem_id = ? AND up.status = "solved" AND up.solved_at IS NOT NULL
            ORDER BY up.solved_at ASC
        ', [$problem->problem_id]);
        
        return view('problem.show', compact('problem', 'submissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Problem $problem)
    {
        $tagsData = \DB::select('SELECT * FROM tags ORDER BY tag_name ASC');
        $tags = \App\Models\Tag::hydrate($tagsData);
        
        // Load tags for the problem
        $problemTags = \DB::select('
            SELECT t.* FROM tags t
            INNER JOIN problemtags pt ON t.tag_id = pt.tag_id
            WHERE pt.problem_id = ?
        ', [$problem->problem_id]);
        $problem->setRelation('tags', \App\Models\Tag::hydrate($problemTags));
        
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

        // Extract tags before updating problem
        $tags = $data['tags'] ?? [];

        // Update problem using raw SQL
        \DB::update('UPDATE problems SET title = ?, problem_link = ?, rating = ?, updated_at = NOW() WHERE problem_id = ?', [
            $data['title'],
            $data['problem_link'],
            $data['rating'],
            $problem->problem_id
        ]);

        // Sync tags - delete old ones and insert new ones
        \DB::delete('DELETE FROM problemtags WHERE problem_id = ?', [$problem->problem_id]);
        foreach ($tags as $tagId) {
            \DB::insert('INSERT INTO problemtags (problem_id, tag_id) VALUES (?, ?)', [$problem->problem_id, $tagId]);
        }

        return redirect()->route('problem.index')->with('success', 'Problem updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Problem $problem)
    {
        // Delete related records first
        \DB::delete('DELETE FROM problemtags WHERE problem_id = ?', [$problem->problem_id]);
        \DB::delete('DELETE FROM userproblems WHERE problem_id = ?', [$problem->problem_id]);
        \DB::delete('DELETE FROM editorials WHERE problem_id = ?', [$problem->problem_id]);
        
        // Delete the problem
        \DB::delete('DELETE FROM problems WHERE problem_id = ?', [$problem->problem_id]);
        
        return redirect()->route('problem.index')->with('success', 'Problem deleted successfully.');
    }
}

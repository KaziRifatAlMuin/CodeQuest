<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editorial;
use App\Models\Problem;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource (sorted by last updated).
     */
    public function index(Request $request)
    {
        // Get sorting parameters
        $sort = $request->input('sort', 'updated');
        $direction = $request->input('direction', 'desc');
        
        // Search functionality
        $search = $request->input('search', '');
        $whereConditions = [];
        $params = [];
        
        if (!empty($search)) {
            $whereConditions[] = "(e.solution LIKE ? OR e.code LIKE ? OR p.title LIKE ? OR u.name LIKE ?)";
            $searchPattern = "%{$search}%";
            $params[] = $searchPattern;
            $params[] = $searchPattern;
            $params[] = $searchPattern;
            $params[] = $searchPattern;
        }
        
        $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
        
        // Validate and set ORDER BY clause
        $validSorts = [
            'updated' => 'e.updated_at',
            'created' => 'e.created_at',
            'author' => 'u.name',
            'problem' => 'p.title',
            'upvotes' => 'e.upvotes',
            'rating' => 'p.rating'
        ];
        
        $orderColumn = $validSorts[$sort] ?? 'e.updated_at';
        $orderDirection = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        
        // Get paginated editorials using raw SQL with flexible pagination
        $perPage = \App\Helpers\SearchHelper::getPerPage($request->input('per_page', 25));
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $editorialsData = \DB::select("
            SELECT e.*, 
                   p.title as problem_title, p.problem_link as problem_link, p.rating as problem_rating,
                   u.name as author_name, u.user_id as author_user_id
            FROM editorials e
            INNER JOIN problems p ON e.problem_id = p.problem_id
            INNER JOIN users u ON e.author_id = u.user_id
            $whereClause
            ORDER BY $orderColumn $orderDirection
            LIMIT ? OFFSET ?
        ", array_merge($params, [$perPage, $offset]));
        
        $totalEditorials = \DB::select("
            SELECT COUNT(*) as total FROM editorials e
            INNER JOIN problems p ON e.problem_id = p.problem_id
            INNER JOIN users u ON e.author_id = u.user_id
            $whereClause
        ", $params)[0]->total;
        
        $editorials = Editorial::hydrate($editorialsData);
        
        // Manually set relationships
        foreach ($editorials as $editorial) {
            $problemData = \DB::select('SELECT * FROM problems WHERE problem_id = ? LIMIT 1', [$editorial->problem_id]);
            $authorData = \DB::select('SELECT * FROM users WHERE user_id = ? LIMIT 1', [$editorial->author_id]);
            
            if (!empty($problemData)) {
                $editorial->setRelation('problem', Problem::hydrate($problemData)[0]);
            }
            if (!empty($authorData)) {
                $editorial->setRelation('author', \App\Models\User::hydrate($authorData)[0]);
            }
        }
        
        // Create pagination manually
        $editorials = new \Illuminate\Pagination\LengthAwarePaginator(
            $editorials,
            $totalEditorials,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('editorial.index', compact('editorials', 'search', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $problemId = $request->query('problem_id');
        $problem = null;
        
        if ($problemId) {
            $problemData = \DB::select('SELECT * FROM problems WHERE problem_id = ? LIMIT 1', [$problemId]);
            if (empty($problemData)) {
                abort(404, 'Problem not found.');
            }
            $problem = Problem::hydrate($problemData)[0];
        }
        
        return view('editorial.create', compact('problem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'problem_id' => 'required|exists:problems,problem_id',
                'solution' => 'required|string|min:10',
                'code' => 'nullable|string',
            ]);
            
            // Insert editorial using raw SQL
            \DB::insert('INSERT INTO editorials (problem_id, author_id, solution, code, upvotes, downvotes, created_at, updated_at) VALUES (?, ?, ?, ?, 0, 0, NOW(), NOW())', [
                $validated['problem_id'],
                auth()->user()->user_id,
                $validated['solution'],
                $validated['code'] ?? ''
            ]);
            
            return redirect()->route('problem.show', $validated['problem_id'])
                ->with('success', 'Editorial published successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Editorial creation error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error publishing editorial: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Editorial $editorial)
    {
        // Load problem and author relationships
        $problemData = \DB::select('SELECT * FROM problems WHERE problem_id = ? LIMIT 1', [$editorial->problem_id]);
        $authorData = \DB::select('SELECT * FROM users WHERE user_id = ? LIMIT 1', [$editorial->author_id]);
        
        if (!empty($problemData)) {
            $editorial->setRelation('problem', Problem::hydrate($problemData)[0]);
        }
        if (!empty($authorData)) {
            $editorial->setRelation('author', \App\Models\User::hydrate($authorData)[0]);
        }
        
        return view('editorial.show', compact('editorial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Editorial $editorial)
    {
        // Load problem relationship
        $problemData = \DB::select('SELECT * FROM problems WHERE problem_id = ? LIMIT 1', [$editorial->problem_id]);
        if (!empty($problemData)) {
            $editorial->setRelation('problem', Problem::hydrate($problemData)[0]);
        }
        
        return view('editorial.edit', compact('editorial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Editorial $editorial)
    {
        $data = $request->validate([
            'solution' => 'required|string',
            'code' => 'required|string',
        ]);
        
        // Update using raw SQL
        \DB::update('UPDATE editorials SET solution = ?, code = ?, updated_at = NOW() WHERE editorial_id = ?', [
            $data['solution'],
            $data['code'],
            $editorial->editorial_id
        ]);
        
        return redirect()->route('editorial.show', $editorial->editorial_id)
            ->with('success', 'Editorial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Editorial $editorial)
    {
        $problemId = $editorial->problem_id;
        
        // Delete using raw SQL
        \DB::delete('DELETE FROM editorials WHERE editorial_id = ?', [$editorial->editorial_id]);
        
        return redirect()->route('problem.show', $problemId)
            ->with('success', 'Editorial deleted successfully.');
    }

    /**
     * Upvote an editorial.
     */
    public function upvote(Editorial $editorial)
    {
        // Increment upvotes using raw SQL
        \DB::update('UPDATE editorials SET upvotes = upvotes + 1, updated_at = NOW() WHERE editorial_id = ?', [$editorial->editorial_id]);
        
        return back()->with('success', 'Editorial upvoted!');
    }

    /**
     * Downvote an editorial.
     */
    public function downvote(Editorial $editorial)
    {
        // Increment downvotes using raw SQL
        \DB::update('UPDATE editorials SET downvotes = downvotes + 1, updated_at = NOW() WHERE editorial_id = ?', [$editorial->editorial_id]);
        
        return back()->with('success', 'Editorial downvoted!');
    }
}

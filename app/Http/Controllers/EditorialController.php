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
    public function index()
    {
        $editorials = Editorial::with(['problem', 'author'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        return view('editorials.index', compact('editorials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $problemId = $request->query('problem_id');
        $problem = null;
        
        if ($problemId) {
            $problem = Problem::findOrFail($problemId);
        }
        
        return view('editorials.create', compact('problem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'problem_id' => 'required|integer|exists:problems,problem_id',
            'solution' => 'required|string',
            'code' => 'required|string',
        ]);
        
        // Set author_id to logged-in user
        $data['author_id'] = auth()->id();
        $data['upvotes'] = 0;
        $data['downvotes'] = 0;
        
        Editorial::create($data);
        
        return redirect()->route('problem.show', $data['problem_id'])
            ->with('success', 'Editorial created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Editorial $editorial)
    {
        $editorial->load(['problem', 'author']);
        return view('editorials.show', compact('editorial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Editorial $editorial)
    {
        $editorial->load('problem');
        return view('editorials.edit', compact('editorial'));
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
        
        $editorial->update($data);
        
        return redirect()->route('editorials.show', $editorial->editorial_id)
            ->with('success', 'Editorial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Editorial $editorial)
    {
        $problemId = $editorial->problem_id;
        $editorial->delete();
        
        return redirect()->route('problem.show', $problemId)
            ->with('success', 'Editorial deleted successfully.');
    }

    /**
     * Upvote an editorial.
     */
    public function upvote(Editorial $editorial)
    {
        $editorial->increment('upvotes');
        
        return back()->with('success', 'Editorial upvoted!');
    }

    /**
     * Downvote an editorial.
     */
    public function downvote(Editorial $editorial)
    {
        $editorial->increment('downvotes');
        
        return back()->with('success', 'Editorial downvoted!');
    }
}

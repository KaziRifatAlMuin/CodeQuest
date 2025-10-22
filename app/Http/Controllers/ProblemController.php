<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Order problems by creation date (newest first)
        $problems = Problem::orderBy('created_at', 'desc')->paginate(20);
        return view('problem.index', compact('problems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('problem.create');
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
        ]);

        // Initialize dynamic fields to 0
        $data['solved_count'] = 0;
        $data['stars'] = 0;
        $data['popularity'] = 0;

        Problem::create($data);
        return redirect()->route('problem.index')->with('success', 'Problem created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Problem $problem)
    {
        return view('problem.show', compact('problem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Problem $problem)
    {
        return view('problem.edit', compact('problem'));
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
        ]);

        // Don't allow manual update of solved_count, stars, or popularity
        // These are updated automatically via UserProblem events

        $problem->update($data);
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

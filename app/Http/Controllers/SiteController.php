<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;

class SiteController extends Controller
{
    // Static Pages
    public function home() {
        // Top 10 most popular problems (by popularity then solved_count)
        $topProblems = Problem::query()
            ->orderByDesc('popularity')
            ->orderByDesc('solved_count')
            ->take(10)
            ->get();

        // Top 10 rated users (by cf_max_rating)
        $topRatedUsers = User::query()
            ->orderByDesc('cf_max_rating')
            ->take(10)
            ->get();

        // Top 10 solvers by solved_problems_count
        $topSolvers = User::query()
            ->orderByDesc('solved_problems_count')
            ->take(10)
            ->get();

        return view('navigation.home', compact('topProblems', 'topRatedUsers', 'topSolvers'));
    }
    
    public function about() {
        // Provide some featured problems and users for the about page
        $featuredProblems = Problem::query()->orderByDesc('popularity')->take(6)->get();
        $featuredUsers = User::query()->orderByDesc('cf_max_rating')->take(6)->get();

        return view('navigation.about', compact('featuredProblems', 'featuredUsers'));
    }
    
    public function contact() {
        return view('navigation.contact');
    }
    
    public function welcome() {
        return view('navigation.welcome');
    }
    
    public function practice() {
        return view('navigation.practice');
    }

    // Utility Routes (for dynamic name and problem display)
    public function showName($nameValue)
    {
        return view('name', ['name' => $nameValue]);
    }

    public function showProblem($problem, $tag, $problem_no)
    {
        return view('problem', [
            'problem' => $problem,
            'tag' => $tag,
            'problem_no' => $problem_no
        ]);
    }

    // Account Routes
    public function profile()
    {
        return view('account.profile');
    }

    public function login()
    {
        return view('account.login');
    }

    public function register()
    {
        return view('account.register');
    }

    public function updateProfile()
    {
        return view('account.updateProfile');
    }

    public function forgotPassword()
    {
        return view('account.forgot-password');
    }

    public function logout()
    {
        // Logout logic
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }
}

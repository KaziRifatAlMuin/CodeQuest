<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;

class SiteController extends Controller
{
    // ============================================
    // PUBLIC PAGES
    // ============================================
    
    /**
     * Home page with top problems and users
     */
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
    
    /**
     * About page
     */
    public function about() 
    {
        $featuredProblems = Problem::query()->orderByDesc('popularity')->take(6)->get();
        $featuredUsers = User::query()->orderByDesc('cf_max_rating')->take(6)->get();

        return view('navigation.about', compact('featuredProblems', 'featuredUsers'));
    }
    
    /**
     * Contact page
     */
    public function contact() 
    {
        return view('navigation.contact');
    }
}

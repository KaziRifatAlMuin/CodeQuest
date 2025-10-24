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
        // Top 10 most popular problems (by popularity then solved_count) using raw SQL
        $topProblemsData = \DB::select('
            SELECT * FROM problems
            ORDER BY popularity DESC, solved_count DESC
            LIMIT 10
        ');
        $topProblems = Problem::hydrate($topProblemsData);

        // Top 10 rated users (by cf_max_rating) using raw SQL
        $topRatedUsersData = \DB::select('
            SELECT * FROM users
            ORDER BY cf_max_rating DESC
            LIMIT 10
        ');
        $topRatedUsers = User::hydrate($topRatedUsersData);

        // Top 10 solvers by solved_problems_count using raw SQL
        $topSolversData = \DB::select('
            SELECT * FROM users
            ORDER BY solved_problems_count DESC
            LIMIT 10
        ');
        $topSolvers = User::hydrate($topSolversData);

        return view('navigation.home', compact('topProblems', 'topRatedUsers', 'topSolvers'));
    }
    
    /**
     * About page
     */
    public function about() 
    {
        // Featured problems using raw SQL
        $featuredProblemsData = \DB::select('
            SELECT * FROM problems
            ORDER BY popularity DESC
            LIMIT 6
        ');
        $featuredProblems = Problem::hydrate($featuredProblemsData);
        
        // Featured users using raw SQL
        $featuredUsersData = \DB::select('
            SELECT * FROM users
            ORDER BY cf_max_rating DESC
            LIMIT 6
        ');
        $featuredUsers = User::hydrate($featuredUsersData);

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

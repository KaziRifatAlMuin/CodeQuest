<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    // Static Pages
    public function home() {
        return view('navigation.home');
    }
    
    public function about() {
        return view('navigation.about');
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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\myController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SingleActionController;

Route::get('/', [SiteController::class, 'home']);
Route::get('/home', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::get('/welcome', [SiteController::class, 'welcome']);
Route::get('/practice', [SiteController::class, 'practice']);


Route::get('/name/{nameValue}', [myController::class, 'showName']);
Route::get('/problem/{problem}/{tag}/{problem_no}', [myController::class, 'showProblem']);

// Routing Groups
Route::group(['prefix' => 'account'], function(){
    Route::get('/profile', [AccountController::class, 'profile']);
    Route::get('/login', [AccountController::class, 'login']);
    Route::get('/register', [AccountController::class, 'register']);
    Route::get('/updateProfile', [AccountController::class, 'updateProfile']);
    Route::get('/forgot-password', [AccountController::class, 'forgotPassword']);
    Route::get('/logout', [AccountController::class, 'logout']);
});

Route::get('/leaderboard', function(){
    $persons = [
        ['name' => 'Alice', 'rating' => 1500, 'id' => 1],
        ['name' => 'Bob', 'rating' => 1600, 'id' => 2],
        ['name' => 'Charlie', 'rating' => 1550, 'id' => 3],
        ['name' => 'David', 'rating' => 1700, 'id' => 4],
        ['name' => 'Eve', 'rating' => 1650, 'id' => 5],
        ['name' => 'Frank', 'rating' => 1580, 'id' => 6],
        ['name' => 'Grace', 'rating' => 1620, 'id' => 7],
        ['name' => 'Heidi', 'rating' => 1590, 'id' => 8],
        ['name' => 'Ivan', 'rating' => 1610, 'id' => 9],
        ['name' => 'Judy', 'rating' => 1570, 'id' => 10],
        ['name' => 'Mallory', 'rating' => 1540, 'id' => 11],
        ['name' => 'Niaj', 'rating' => 1530, 'id' => 12],
        ['name' => 'Olivia', 'rating' => 1510, 'id' => 13],
        ['name' => 'Peggy', 'rating' => 1560, 'id' => 14],
        ['name' => 'Sybil', 'rating' => 1430, 'id' => 15],
        ['name' => 'Trent', 'rating' => 1640, 'id' => 16],
        ['name' => 'Victor', 'rating' => 1370, 'id' => 17],
        ['name' => 'Wendy', 'rating' => 1280, 'id' => 18],
        ['name' => 'Xavier', 'rating' => 1690, 'id' => 19],
        ['name' => 'Yvonne', 'rating' => 1710, 'id' => 20],
        ['name' => 'Zara', 'rating' => 1520, 'id' => 21],
    ];
    return view('Features.leaderboard', ['persons' => $persons]);
});

Route::get('/users', function(){
    $persons = [
        ['name' => 'Alice', 'rating' => 1500, 'id' => 1],
        ['name' => 'Bob', 'rating' => 1600, 'id' => 2],
        ['name' => 'Charlie', 'rating' => 1550, 'id' => 3],
        ['name' => 'David', 'rating' => 1700, 'id' => 4],
        ['name' => 'Eve', 'rating' => 1650, 'id' => 5],
        ['name' => 'Frank', 'rating' => 1580, 'id' => 6],
        ['name' => 'Grace', 'rating' => 1620, 'id' => 7],
        ['name' => 'Heidi', 'rating' => 1590, 'id' => 8],
        ['name' => 'Ivan', 'rating' => 1610, 'id' => 9],
        ['name' => 'Judy', 'rating' => 1570, 'id' => 10],
        ['name' => 'Mallory', 'rating' => 1540, 'id' => 11],
        ['name' => 'Niaj', 'rating' => 1530, 'id' => 12],
        ['name' => 'Olivia', 'rating' => 1510, 'id' => 13],
        ['name' => 'Peggy', 'rating' => 1560, 'id' => 14],
        ['name' => 'Sybil', 'rating' => 1430, 'id' => 15],
        ['name' => 'Trent', 'rating' => 1640, 'id' => 16],
        ['name' => 'Victor', 'rating' => 1370, 'id' => 17],
        ['name' => 'Wendy', 'rating' => 1280, 'id' => 18],
        ['name' => 'Xavier', 'rating' => 1690, 'id' => 19],
        ['name' => 'Yvonne', 'rating' => 1710, 'id' => 20],
        ['name' => 'Zara', 'rating' => 1520, 'id' => 21],
    ];
    return view('Features.index', ['persons' => $persons]);
});

Route::get('/user/{id}', function($id){
    $persons = [
        ['name' => 'Alice', 'rating' => 1500, 'id' => 1],
        ['name' => 'Bob', 'rating' => 1600, 'id' => 2],
        ['name' => 'Charlie', 'rating' => 1550, 'id' => 3],
        ['name' => 'David', 'rating' => 1700, 'id' => 4],
        ['name' => 'Eve', 'rating' => 1650, 'id' => 5],
        ['name' => 'Frank', 'rating' => 1580, 'id' => 6],
        ['name' => 'Grace', 'rating' => 1620, 'id' => 7],
        ['name' => 'Heidi', 'rating' => 1590, 'id' => 8],
        ['name' => 'Ivan', 'rating' => 1610, 'id' => 9],
        ['name' => 'Judy', 'rating' => 1570, 'id' => 10],
        ['name' => 'Mallory', 'rating' => 1540, 'id' => 11],
        ['name' => 'Niaj', 'rating' => 1530, 'id' => 12],
        ['name' => 'Olivia', 'rating' => 1510, 'id' => 13],
        ['name' => 'Peggy', 'rating' => 1560, 'id' => 14],
        ['name' => 'Sybil', 'rating' => 1430, 'id' => 15],
        ['name' => 'Trent', 'rating' => 1640, 'id' => 16],
        ['name' => 'Victor', 'rating' => 1370, 'id' => 17],
        ['name' => 'Wendy', 'rating' => 1280, 'id' => 18],
        ['name' => 'Xavier', 'rating' => 1690, 'id' => 19],
        ['name' => 'Yvonne', 'rating' => 1710, 'id' => 20],
        ['name' => 'Zara', 'rating' => 1520, 'id' => 21],
    ];
    return view('Features.userdetails', ['user' => $persons[$id - 1]]);
});

Route::get('/problems', function(){
    $problems = [
        ['id' => 1, 'title' => 'Two Sum', 'difficulty' => 'Easy', 'rating' => 800, 'solved_count' => 15234, 'link' => 'https://codeforces.com/problemset/problem/71/A'],
        ['id' => 2, 'title' => 'Watermelon', 'difficulty' => 'Easy', 'rating' => 800, 'solved_count' => 14256, 'link' => 'https://codeforces.com/problemset/problem/4/A'],
        ['id' => 3, 'title' => 'Team', 'difficulty' => 'Easy', 'rating' => 800, 'solved_count' => 12765, 'link' => 'https://codeforces.com/problemset/problem/231/A'],
        ['id' => 4, 'title' => 'Beautiful Matrix', 'difficulty' => 'Easy', 'rating' => 800, 'solved_count' => 9543, 'link' => 'https://codeforces.com/problemset/problem/263/A'],
        ['id' => 5, 'title' => 'String Task', 'difficulty' => 'Medium', 'rating' => 1000, 'solved_count' => 6823, 'link' => 'https://codeforces.com/problemset/problem/118/A'],
        ['id' => 6, 'title' => 'Interesting Drink', 'difficulty' => 'Medium', 'rating' => 1100, 'solved_count' => 5678, 'link' => 'https://codeforces.com/problemset/problem/706/B'],
        ['id' => 7, 'title' => 'Taxi', 'difficulty' => 'Medium', 'rating' => 1100, 'solved_count' => 4567, 'link' => 'https://codeforces.com/problemset/problem/158/B'],
        ['id' => 8, 'title' => 'IQ Test', 'difficulty' => 'Hard', 'rating' => 1300, 'solved_count' => 3456, 'link' => 'https://codeforces.com/problemset/problem/25/A'],
        ['id' => 9, 'title' => 'Registration System', 'difficulty' => 'Hard', 'rating' => 1300, 'solved_count' => 2345, 'link' => 'https://codeforces.com/problemset/problem/4/C'],
        ['id' => 10, 'title' => 'Books', 'difficulty' => 'Hard', 'rating' => 1400, 'solved_count' => 1234, 'link' => 'https://codeforces.com/problemset/problem/279/B'],
    ];
    return view('Features.problems', ['problems' => $problems]);
});

Route::get('/tags', function(){
    $tags = [
        ['id' => 1, 'name' => 'math', 'problem_count' => 45, 'color' => 'primary'],
        ['id' => 2, 'name' => 'dp', 'problem_count' => 38, 'color' => 'success'],
        ['id' => 3, 'name' => 'graphs', 'problem_count' => 32, 'color' => 'info'],
        ['id' => 4, 'name' => 'trees', 'problem_count' => 28, 'color' => 'warning'],
        ['id' => 5, 'name' => 'greedy', 'problem_count' => 42, 'color' => 'danger'],
        ['id' => 6, 'name' => 'binary-search', 'problem_count' => 25, 'color' => 'secondary'],
        ['id' => 7, 'name' => 'strings', 'problem_count' => 35, 'color' => 'primary'],
        ['id' => 8, 'name' => 'data-structures', 'problem_count' => 40, 'color' => 'success'],
        ['id' => 9, 'name' => 'sorting', 'problem_count' => 30, 'color' => 'info'],
        ['id' => 10, 'name' => 'implementation', 'problem_count' => 50, 'color' => 'warning'],
    ];
    return view('Features.tags', ['tags' => $tags]);
});


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


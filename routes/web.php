<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\myController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SingleActionController;
use App\Http\Controllers\DatabaseController;

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

// Users Routes
Route::get('/users', [DatabaseController::class, 'showUsersList'])->name('users.index');
Route::get('/users/{id}', [DatabaseController::class, 'showUserDetails'])->name('users.details');
Route::get('/leaderboard', [DatabaseController::class, 'showLeaderboard'])->name('leaderboard');

// Show problems list (redirect to problemset)
Route::get('/problems', [DatabaseController::class, 'showProblemset'])->name('problems.index');

// Tags route
Route::get('/tags', [DatabaseController::class, 'showTagsList'])->name('tags.index');

// Show all json data from database tables

Route::get('/json_users', [DatabaseController::class, 'showUsers']);
Route::get('/json_problems', [DatabaseController::class, 'showProblems']);
Route::get('/json_tags', [DatabaseController::class, 'showTags']);
Route::get('/json_problemtags', [DatabaseController::class, 'showProblemTags']);
Route::get('/json_userproblems', [DatabaseController::class, 'showUserProblems']);
Route::get('/json_friends', [DatabaseController::class, 'showFriends']);
Route::get('/json_editorials', [DatabaseController::class, 'showEditorials']);

// Show problemset view (alternative route)
Route::get('/problemset', [DatabaseController::class, 'showProblemset']);
// Show single problem details
Route::get('/problems/{id}', [DatabaseController::class, 'showProblemDetails'])->name('problems.details');

// Editorial Routes
Route::get('/editorials', [DatabaseController::class, 'showEditorialsList'])->name('editorials.index');
Route::get('/editorials/{id}', [DatabaseController::class, 'showEditorialDetails'])->name('editorials.details');

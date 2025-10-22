<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProblemController;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/home', [SiteController::class, 'home'])->name('home.index');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/welcome', [SiteController::class, 'welcome'])->name('welcome');
Route::get('/practice', [SiteController::class, 'practice'])->name('practice');

// Utility Routes
Route::get('/name/{nameValue}', [SiteController::class, 'showName'])->name('name.show');
Route::get('/problem/{problem}/{tag}/{problem_no}', [SiteController::class, 'showProblem'])->name('problem.utility');

// Account Routes Group
Route::group(['prefix' => 'account'], function(){
    Route::get('/profile', [SiteController::class, 'profile'])->name('account.profile');
    Route::get('/login', [SiteController::class, 'login'])->name('account.login');
    Route::get('/register', [SiteController::class, 'register'])->name('account.register');
    Route::get('/updateProfile', [SiteController::class, 'updateProfile'])->name('account.updateProfile');
    Route::get('/forgot-password', [SiteController::class, 'forgotPassword'])->name('account.forgotPassword');
    Route::get('/logout', [SiteController::class, 'logout'])->name('account.logout');
});

// Users Routes (Public)
Route::get('/leaderboard', [DatabaseController::class, 'showLeaderboard'])->name('leaderboard');

// User Management Routes (CRUD) - Handled by UserController (Resource Controller)
// IMPORTANT: Specific routes like /create must come BEFORE {user} to avoid conflicts
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
Route::post('/users', [UserController::class, 'store'])->name('user.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');

// Problem Management Routes (CRUD) - Handled by ProblemController (Resource Controller)
// IMPORTANT: Specific routes like /create must come BEFORE {problem} to avoid conflicts
Route::get('/problems', [ProblemController::class, 'index'])->name('problem.index');
Route::get('/problems/create', [ProblemController::class, 'create'])->name('problem.create');
Route::post('/problems', [ProblemController::class, 'store'])->name('problem.store');
Route::get('/problems/{problem}/edit', [ProblemController::class, 'edit'])->name('problem.edit');
Route::put('/problems/{problem}', [ProblemController::class, 'update'])->name('problem.update');
Route::delete('/problems/{problem}', [ProblemController::class, 'destroy'])->name('problem.destroy');
Route::get('/problems/{problem}', [ProblemController::class, 'show'])->name('problem.show');

// User-Problem Interaction Routes
use App\Http\Controllers\UserProblemController;
Route::post('/problems/{problem}/mark-solved', [UserProblemController::class, 'markSolved'])->name('problem.markSolved');
Route::post('/problems/{problem}/toggle-star', [UserProblemController::class, 'toggleStar'])->name('problem.toggleStar');
Route::post('/problems/{problem}/update-status', [UserProblemController::class, 'updateStatus'])->name('problem.updateStatus');

// Tags route
Route::get('/tags', [DatabaseController::class, 'showTagsList'])->name('tags.index');

// Show all json data from database tables
Route::get('/json_users', [DatabaseController::class, 'showUsers'])->name('json.users');
Route::get('/json_problems', [DatabaseController::class, 'showProblems'])->name('json.problems');
Route::get('/json_tags', [DatabaseController::class, 'showTags'])->name('json.tags');
Route::get('/json_problemtags', [DatabaseController::class, 'showProblemTags'])->name('json.problemtags');
Route::get('/json_userproblems', [DatabaseController::class, 'showUserProblems'])->name('json.userproblems');
Route::get('/json_friends', [DatabaseController::class, 'showFriends'])->name('json.friends');
Route::get('/json_editorials', [DatabaseController::class, 'showEditorials'])->name('json.editorials');

// Show problemset view (alternative route pointing to resource controller)
Route::get('/problemset', [ProblemController::class, 'index'])->name('problemset');

// Editorial Routes
Route::get('/editorials', [DatabaseController::class, 'showEditorialsList'])->name('editorials.index');
Route::get('/editorials/{id}', [DatabaseController::class, 'showEditorialshow'])->name('editorials.show');

// Admin Routes - Only dashboard; Management links to resource controllers
Route::prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DatabaseController::class, 'adminDashboard'])->name('admin.dashboard');
});

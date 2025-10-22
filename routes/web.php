<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\UserController;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/home', [SiteController::class, 'home'])->name('home.index');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/welcome', [SiteController::class, 'welcome'])->name('welcome');
Route::get('/practice', [SiteController::class, 'practice'])->name('practice');

// Utility Routes
Route::get('/name/{nameValue}', [SiteController::class, 'showName'])->name('name.show');
Route::get('/problem/{problem}/{tag}/{problem_no}', [SiteController::class, 'showProblem'])->name('problem.show');

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
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// Show problems list (redirect to problemset)
Route::get('/problems', [DatabaseController::class, 'showProblemset'])->name('problems.index');

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

// Show problemset view (alternative route)
Route::get('/problemset', [DatabaseController::class, 'showProblemset'])->name('problemset');
// Show single problem details
Route::get('/problems/{id}', [DatabaseController::class, 'showProblemDetails'])->name('problems.details');

// Editorial Routes
Route::get('/editorials', [DatabaseController::class, 'showEditorialsList'])->name('editorials.index');
Route::get('/editorials/{id}', [DatabaseController::class, 'showEditorialDetails'])->name('editorials.details');

// Admin Routes
Route::prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DatabaseController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // Admin Problems Management
    Route::get('/problems', [DatabaseController::class, 'adminProblemsList'])->name('admin.problems.index');
    Route::get('/problems/create', [DatabaseController::class, 'adminProblemsCreate'])->name('admin.problems.create');
    Route::get('/problems/{id}/edit', [DatabaseController::class, 'adminProblemsEdit'])->name('admin.problems.edit');
    Route::post('/problems', [DatabaseController::class, 'adminProblemsStore'])->name('admin.problems.store');
    Route::put('/problems/{id}', [DatabaseController::class, 'adminProblemsUpdate'])->name('admin.problems.update');
    Route::delete('/problems/{id}', [DatabaseController::class, 'adminProblemsDestroy'])->name('admin.problems.destroy');
    
    // Admin Users Management
    Route::get('/users', [DatabaseController::class, 'adminUsersList'])->name('admin.users.index');
    Route::get('/users/create', [DatabaseController::class, 'adminUsersCreate'])->name('admin.users.create');
    Route::get('/users/{id}/edit', [DatabaseController::class, 'adminUsersEdit'])->name('admin.users.edit');
    Route::post('/users', [DatabaseController::class, 'adminUsersStore'])->name('admin.users.store');
    Route::put('/users/{id}', [DatabaseController::class, 'adminUsersUpdate'])->name('admin.users.update');
    Route::delete('/users/{id}', [DatabaseController::class, 'adminUsersDestroy'])->name('admin.users.destroy');
    
    // Admin Editorials Management
    Route::get('/editorials', [DatabaseController::class, 'adminEditorialsList'])->name('admin.editorials.index');
    Route::get('/editorials/create', [DatabaseController::class, 'adminEditorialsCreate'])->name('admin.editorials.create');
    Route::get('/editorials/{id}/edit', [DatabaseController::class, 'adminEditorialsEdit'])->name('admin.editorials.edit');
    Route::post('/editorials', [DatabaseController::class, 'adminEditorialsStore'])->name('admin.editorials.store');
    Route::put('/editorials/{id}', [DatabaseController::class, 'adminEditorialsUpdate'])->name('admin.editorials.update');
    Route::delete('/editorials/{id}', [DatabaseController::class, 'adminEditorialsDestroy'])->name('admin.editorials.destroy');
    
    // Admin Tags Management
    Route::get('/tags', [DatabaseController::class, 'adminTagsList'])->name('admin.tags.index');
    Route::get('/tags/create', [DatabaseController::class, 'adminTagsCreate'])->name('admin.tags.create');
    Route::get('/tags/{id}/edit', [DatabaseController::class, 'adminTagsEdit'])->name('admin.tags.edit');
    Route::post('/tags', [DatabaseController::class, 'adminTagsStore'])->name('admin.tags.store');
    Route::put('/tags/{id}', [DatabaseController::class, 'adminTagsUpdate'])->name('admin.tags.update');
    Route::delete('/tags/{id}', [DatabaseController::class, 'adminTagsDestroy'])->name('admin.tags.destroy');
});

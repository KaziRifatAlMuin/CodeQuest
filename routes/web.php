<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\UserProblemController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\ValidUser;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Public Routes - Accessible to everyone
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/home', [SiteController::class, 'home'])->name('home.index');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');

// Guest Only Routes - Only for non-authenticated users
Route::middleware('guest')->group(function () {
    Route::get('/account/login', [AccountController::class, 'showLogin'])->name('account.login');
    Route::post('/account/login', [AccountController::class, 'login']);
    Route::get('/account/register', [AccountController::class, 'showRegister'])->name('account.register');
    Route::post('/account/register', [AccountController::class, 'register']);
    Route::get('/account/forgot-password', [AccountController::class, 'showForgotPassword'])->name('account.forgotPassword');
    Route::post('/account/forgot-password', [AccountController::class, 'sendResetLink'])->name('password.email');
    Route::get('/account/reset-password/{token}', [AccountController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/account/reset-password', [AccountController::class, 'resetPassword'])->name('password.update');
});

// Authenticated Routes - Requires login
Route::middleware('auth')->group(function () {
    // Handle Verification (required before email verification)
    Route::get('/account/handle-verification', [AccountController::class, 'showHandleVerification'])->name('account.handleVerification');
    Route::post('/account/handle-verification', [AccountController::class, 'verifyHandle'])->name('account.verifyHandle');
    
    // Email Verification Routes
    Route::get('/email/verify', [AccountController::class, 'showEmailVerification'])->name('verification.notice');
    Route::post('/email/verification-notification', [AccountController::class, 'resendEmailVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('home')->with('success', 'Email verified successfully!');
    })->middleware('signed')->name('verification.verify');
    
    // Profile and Logout
    Route::get('/account/profile', [AccountController::class, 'showProfile'])->name('account.profile');
    Route::get('/account/edit-profile', [AccountController::class, 'showEditProfile'])->name('account.editProfile');
    Route::post('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::delete('/account/delete-profile-picture', [AccountController::class, 'deleteProfilePicture'])->name('account.deleteProfilePicture');
    Route::post('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    
    // Protected Routes - Requires verified email and handle
    Route::middleware(['verified'])->group(function () {
        Route::get('/welcome', [SiteController::class, 'welcome'])->name('welcome');
        Route::get('/practice', [SiteController::class, 'practice'])->name('practice');
        
        // Utility Routes
        Route::get('/name/{nameValue}', [SiteController::class, 'showName'])->name('name.show');
        Route::get('/problem/{problem}/{tag}/{problem_no}', [SiteController::class, 'showProblem'])->name('problem.utility');
        
        // Users Routes (Public within auth)
        Route::get('/leaderboard', [DatabaseController::class, 'showLeaderboard'])->name('leaderboard');
        
        // User Management Routes (CRUD)
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/users', [UserController::class, 'store'])->name('user.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');
        
        // Problem Management Routes (CRUD)
        Route::get('/problems', [ProblemController::class, 'index'])->name('problem.index');
        Route::get('/problems/create', [ProblemController::class, 'create'])->name('problem.create');
        Route::post('/problems', [ProblemController::class, 'store'])->name('problem.store');
        Route::get('/problems/{problem}/edit', [ProblemController::class, 'edit'])->name('problem.edit');
        Route::put('/problems/{problem}', [ProblemController::class, 'update'])->name('problem.update');
        Route::delete('/problems/{problem}', [ProblemController::class, 'destroy'])->name('problem.destroy');
        Route::get('/problems/{problem}', [ProblemController::class, 'show'])->name('problem.show');
        Route::get('/problemset', [ProblemController::class, 'index'])->name('problemset');
        
        // User-Problem Interaction Routes
        Route::post('/problems/{problem}/mark-solved', [UserProblemController::class, 'markSolved'])->name('problem.markSolved');
        Route::post('/problems/{problem}/toggle-star', [UserProblemController::class, 'toggleStar'])->name('problem.toggleStar');
        Route::post('/problems/{problem}/update-status', [UserProblemController::class, 'updateStatus'])->name('problem.updateStatus');
        
        // Tags route
        Route::get('/tags', [DatabaseController::class, 'showTagsList'])->name('tags.index');
        
        // Editorial Routes
        Route::get('/editorials', [DatabaseController::class, 'showEditorialsList'])->name('editorials.index');
        Route::get('/editorials/{id}', [DatabaseController::class, 'showEditorialshow'])->name('editorials.show');
        
        // JSON Data Routes (for debugging/API)
        Route::get('/json_users', [DatabaseController::class, 'showUsers'])->name('json.users');
        Route::get('/json_problems', [DatabaseController::class, 'showProblems'])->name('json.problems');
        Route::get('/json_tags', [DatabaseController::class, 'showTags'])->name('json.tags');
        Route::get('/json_problemtags', [DatabaseController::class, 'showProblemTags'])->name('json.problemtags');
        Route::get('/json_userproblems', [DatabaseController::class, 'showUserProblems'])->name('json.userproblems');
        Route::get('/json_friends', [DatabaseController::class, 'showFriends'])->name('json.friends');
        Route::get('/json_editorials', [DatabaseController::class, 'showEditorials'])->name('json.editorials');
        
        // Admin Routes - Only for admins
        Route::middleware('can:admin')->prefix('admin')->group(function () {
            Route::get('/dashboard', [DatabaseController::class, 'adminDashboard'])->name('admin.dashboard');
        });
    });
});

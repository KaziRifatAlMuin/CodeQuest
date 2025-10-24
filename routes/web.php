<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\UserProblemController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// ============================================
// PUBLIC ROUTES (Accessible to everyone)
// ============================================
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/home', [SiteController::class, 'home'])->name('home.index');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/leaderboard', [UserController::class, 'leaderboard'])->name('leaderboard');

// ============================================
// GUEST ROUTES (Non-authenticated users only)
// ============================================
Route::middleware(['guest','setUserTimezone'])->group(function () {
    Route::get('/account/login', [AccountController::class, 'showLogin'])->name('account.login');
    Route::post('/account/login', [AccountController::class, 'login']);
    Route::get('/account/register', [AccountController::class, 'showRegister'])->name('account.register');
    Route::post('/account/register', [AccountController::class, 'register']);
    Route::get('/account/forgot-password', [AccountController::class, 'showForgotPassword'])->name('account.forgotPassword');
    Route::post('/account/forgot-password', [AccountController::class, 'sendResetLink'])->name('password.email');
    Route::get('/account/reset-password/{token}', [AccountController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/account/reset-password', [AccountController::class, 'resetPassword'])->name('password.update');
});

// ============================================
// AUTHENTICATED ROUTES
// ============================================
Route::middleware(['auth','setUserTimezone'])->group(function () {
    
    // ---- Account Management ----
    Route::get('/account/handle-verification', [AccountController::class, 'showHandleVerification'])->name('account.handleVerification');
    Route::post('/account/handle-verification', [AccountController::class, 'verifyHandle'])->name('account.verifyHandle');
    Route::get('/email/verify', [AccountController::class, 'showEmailVerification'])->name('verification.notice');
    Route::post('/email/verification-notification', [AccountController::class, 'resendEmailVerification'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('home')->with('success', 'Email verified successfully!');
    })->middleware('signed')->name('verification.verify');
    Route::get('/account/profile', [AccountController::class, 'showProfile'])->name('account.profile');
    Route::get('/account/edit-profile', [AccountController::class, 'showEditProfile'])->name('account.editProfile');
    Route::post('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::delete('/account/delete-profile-picture', [AccountController::class, 'deleteProfilePicture'])->name('account.deleteProfilePicture');
    Route::post('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    
    // ============================================
    // VERIFIED USER ROUTES (Email + Handle verified)
    // ============================================
    Route::middleware(['verified'])->group(function () {
        
        // ---- User Routes ----
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create')->middleware('checkRole:moderator,admin');
        Route::post('/users', [UserController::class, 'store'])->name('user.store')->middleware('checkRole:moderator,admin');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('checkRole:moderator,admin');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update')->middleware('checkRole:moderator,admin');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('checkRole:admin');
        
        // ---- Friend Routes ----
        Route::get('/users/{user}/followers', [FriendController::class, 'followers'])->name('friend.followers');
        Route::get('/users/{user}/following', [FriendController::class, 'followings'])->name('friend.following');
        Route::post('/users/{user}/follow', [FriendController::class, 'follow'])->name('friend.follow');
        Route::match(['post', 'delete'], '/users/{user}/unfollow', [FriendController::class, 'unfollow'])->name('friend.unfollow');
        
        // ---- Problem Routes ----
        Route::get('/problems', [ProblemController::class, 'index'])->name('problem.index');
        Route::get('/problemset', [ProblemController::class, 'index'])->name('problemset');
        Route::get('/problems/create', [ProblemController::class, 'create'])->name('problem.create');
        Route::post('/problems', [ProblemController::class, 'store'])->name('problem.store');
        Route::get('/problems/{problem}', [ProblemController::class, 'show'])->name('problem.show');
        Route::get('/problems/{problem}/edit', [ProblemController::class, 'edit'])->name('problem.edit')->middleware('checkRole:moderator,admin');
        Route::put('/problems/{problem}', [ProblemController::class, 'update'])->name('problem.update')->middleware('checkRole:moderator,admin');
        Route::delete('/problems/{problem}', [ProblemController::class, 'destroy'])->name('problem.destroy')->middleware('checkRole:admin');
        
        // ---- User-Problem Interaction ----
        Route::post('/problems/{problem}/mark-solved', [UserProblemController::class, 'markSolved'])->name('problem.markSolved');
        Route::post('/problems/{problem}/toggle-star', [UserProblemController::class, 'toggleStar'])->name('problem.toggleStar');
        Route::post('/problems/{problem}/update-status', [UserProblemController::class, 'updateStatus'])->name('problem.updateStatus');
        Route::get('/problems/{problem}/user/{user}/edit', [UserProblemController::class, 'edit'])->name('userProblem.edit');
        Route::put('/problems/{problem}/user/{user}', [UserProblemController::class, 'update'])->name('userProblem.update');
        
        // ---- Tag Routes ----
        Route::get('/tags', [TagController::class, 'index'])->name('tag.index');
        Route::get('/tags/create', [TagController::class, 'create'])->name('tag.create')->middleware('checkRole:moderator,admin');
        Route::post('/tags', [TagController::class, 'store'])->name('tag.store')->middleware('checkRole:moderator,admin');
        Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tag.show');
        Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tag.edit')->middleware('checkRole:moderator,admin');
        Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tag.update')->middleware('checkRole:moderator,admin');
        Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tag.destroy')->middleware('checkRole:admin');
        
        // ---- Editorial Routes ----
        Route::get('/editorials', [EditorialController::class, 'index'])->name('editorial.index');
        Route::get('/editorials/create', [EditorialController::class, 'create'])->name('editorial.create');
        Route::post('/editorials', [EditorialController::class, 'store'])->name('editorial.store');
        Route::get('/editorials/{editorial}', [EditorialController::class, 'show'])->name('editorial.show');
        Route::post('/editorials/{editorial}/upvote', [EditorialController::class, 'upvote'])->name('editorial.upvote');
        Route::post('/editorials/{editorial}/downvote', [EditorialController::class, 'downvote'])->name('editorial.downvote');
        Route::get('/editorials/{editorial}/edit', [EditorialController::class, 'edit'])->name('editorial.edit')->middleware('editorialOwner');
        Route::put('/editorials/{editorial}', [EditorialController::class, 'update'])->name('editorial.update')->middleware('editorialOwner');
        Route::delete('/editorials/{editorial}', [EditorialController::class, 'destroy'])->name('editorial.destroy')->middleware('checkRole:admin');
        
        // ---- Admin Routes ----
        Route::prefix('admin')->middleware('checkRole:admin')->group(function () {
            Route::get('/dashboard', [AccountController::class, 'adminDashboard'])->name('admin.dashboard');
            Route::post('/users/{user}/update-role', [AccountController::class, 'updateUserRole'])->name('admin.updateUserRole');
            Route::get('/tags', [TagController::class, 'adminIndex'])->name('admin.tags.index');
            Route::get('/tags/{tag}/manage', [TagController::class, 'manage'])->name('admin.tags.manage');
        });
    });
});

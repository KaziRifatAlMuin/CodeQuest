<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\myController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SingleActionController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'showHome']);
Route::get('/home', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::get('/welcome', [SiteController::class, 'welcome']);

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

Route::get('/single', SingleActionController::class);

Route::get('/practice', function () {
    return view('practice');
});


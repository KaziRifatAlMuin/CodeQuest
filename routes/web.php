<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\myController;

Route::get('/', [SiteController::class, 'home']);
Route::get('/home', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/contact', [SiteController::class, 'contact']);

Route::get('/name/{nameValue}', [myController::class, 'showName']);
Route::get('/problem/{problem}/{tag}/{problem_no}', [myController::class, 'showProblem']);
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    function home() {
        return view('home');
    }
    function about() {
        return view('about');
    }
    function contact() {
        return view('contact');
    }
    function welcome() {
        return view('welcome');
    }
    function practice() {
        return view('practice');
    }
}

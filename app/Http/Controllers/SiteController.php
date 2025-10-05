<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    function home() {
        return view('Home');
    }
    function about() {
        return view('About');
    }
    function contact() {
        return view('Contact') ;
    }
}

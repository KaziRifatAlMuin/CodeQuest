<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    function home() {
        return view('navigation.Home');
    }
    function about() {
        return view('navigation.About');
    }
    function contact() {
        return view('navigation.Contact') ;
    }
    function welcome() {
        return view('navigation.Welcome') ;
    }
    function practice() {
        return view('navigation.Practice') ;
    }
}

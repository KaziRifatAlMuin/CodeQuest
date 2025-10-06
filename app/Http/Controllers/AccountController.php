<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function profile(){
        return "<h1>This is profile page</h1>";
    }

    public function login(){
        return "<h1>This is login page</h1>";
    }

    public function register(){
        return "<h1>This is register page</h1>";
    }

    public function updateProfile(){
        return "<h1>This is update profile page</h1>";
    }

    public function forgotPassword(){
        return "<h1>This is forgot password page</h1>";
    }

    public function logout(){
        return "<h1>This is logout page</h1>";
    }
}

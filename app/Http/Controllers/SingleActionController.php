<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SingleActionController extends Controller
{
    // invoke method is used for single action controller
    public function __invoke()
    {
        return "<h1>This is single action controller</h1>";
    }
}

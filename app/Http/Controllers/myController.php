<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class myController extends Controller
{
    public function showName($nameValue) {
        return "<h1> Hello, $nameValue </h1>";
    }

    public function showProblem($problem, $tag, $problem_no) {
        // return "<h1> Problem: $problem </h1>
        //         <h2> Tag: $tag </h2>
        //         <h3> Problem No: $problem_no </h3>";
        return view('Problem', compact('problem', 'tag', 'problem_no'));
    }
}

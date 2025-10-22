<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        echo "CheckUserRole middleware executed.";
        $checkrole = $request->user()->role;
        if ($checkrole == $role) {
            return $next($request);
        } else {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
    }
}

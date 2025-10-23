<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Check if authenticated user has required role
     * 
     * Usage: Route::get('/admin', ...)->middleware('checkRole:admin');
     * Usage: Route::get('/manage', ...)->middleware('checkRole:admin,moderator');
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized. Please login to continue.');
        }

        $userRole = $request->user()->role;

        if (!in_array($userRole, $roles)) {
            // Check if it's an AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthorized. You do not have permission to perform this action.',
                    'required_roles' => $roles,
                    'your_role' => $userRole
                ], 403);
            }

            // For web requests, show alert via session
            return redirect()->back()->with('error', 'Unauthorized. You do not have permission to perform this action.');
        }

        return $next($request);
    }
}

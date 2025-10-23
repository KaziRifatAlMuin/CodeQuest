<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Editorial;

class CheckEditorialOwnership
{
    /**
     * Check if user is the editorial author or an admin
     * Allows only the author or admin to edit their editorial
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $editorial = $request->route('editorial');
        
        if (!$editorial instanceof Editorial) {
            abort(404, 'Editorial not found.');
        }
        
        $user = $request->user();
        
        // Allow if user is the author or an admin
        if ($user->user_id === $editorial->author_id || $user->role === 'admin') {
            return $next($request);
        }
        
        abort(403, 'Unauthorized. You can only edit your own editorials.');
    }
}

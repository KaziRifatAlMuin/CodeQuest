<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserTimezone
{
    /**
     * Read timezone from cookie `user_timezone` and set PHP default timezone for the request.
     * If not present, default to Asia/Dhaka.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tz = $request->cookie('user_timezone');
        if (empty($tz)) {
            $tz = 'Asia/Dhaka';
        }

        // Basic validation: allow only common timezone strings (avoid injections)
        try {
            // @phpstan-ignore-next-line
            date_default_timezone_set($tz);
        } catch (\Throwable $e) {
            date_default_timezone_set('Asia/Dhaka');
        }

        return $next($request);
    }
}

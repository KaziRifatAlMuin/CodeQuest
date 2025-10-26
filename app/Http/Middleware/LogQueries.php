<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\QueryLoggerService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to log SQL queries and persist them across requests.
 * 
 * For AJAX requests: Appends query data to JSON responses
 * For regular requests: Stores queries in session for display after redirect
 */
class LogQueries
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        $queryLogger = app(QueryLoggerService::class);
        $queries = $queryLogger->getQueries();
        
        // Always store queries in session for the next request (after redirects)
        // This captures queries from POST/PUT/DELETE actions
        if (count($queries) > 0) {
            $queryLogger->storeInSession();
        }
        
        // For AJAX requests, append query data to response
        if ($request->ajax() || $request->wantsJson()) {
            // If response is JSON, add queries to it
            if ($response->headers->get('Content-Type') === 'application/json' || 
                strpos($response->headers->get('Content-Type'), 'application/json') !== false) {
                
                $content = $response->getContent();
                $data = json_decode($content, true);
                
                if (is_array($data)) {
                    $data['_queries'] = $queries;
                    $data['_query_count'] = count($queries);
                    $response->setContent(json_encode($data));
                }
            }
        }
        
        return $response;
    }
}

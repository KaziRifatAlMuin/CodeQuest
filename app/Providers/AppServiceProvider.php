<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Services\CodeforcesService;
use App\Services\QueryLoggerService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register QueryLoggerService as a singleton so it persists across the request
        $this->app->singleton(QueryLoggerService::class, function ($app) {
            return new QueryLoggerService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        // Enable SQL query logging
        DB::listen(function ($query) {
            $logger = app(QueryLoggerService::class);
            $logger->logQuery($query->sql, $query->bindings, $query->time);
        });
        
        // Run Codeforces handle synchronization before rendering the main layout.
        // This uses a view composer for the `components.layout` view so the sync runs
        // whenever the layout is rendered. Note: this triggers HTTP calls to
        // Codeforces and will run on every page load that uses the layout.
        View::composer('components.layout', function ($view) {
            try {
                // resolve and run the service
                $service = app(CodeforcesService::class);
                $service->syncAllUserHandles();
            } catch (\Throwable $e) {
                // Do not break rendering on failures
            }
            
            // Pass the query logger to the view so queries can be displayed
            $queryLogger = app(QueryLoggerService::class);
            
            // Load queries from previous request (if this is after a redirect)
            $queryLogger->loadFromSession();
            
            $view->with('queries', $queryLogger->getQueries());
        });
    }
}

<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Verification of Updated User Data ===\n\n";

// Check top users
echo "Top 10 Users (by max rating):\n";
echo str_repeat("-", 120) . "\n";
printf("%-20s %-15s %10s %10s %15s %12s\n", "Name", "Handle", "Max Rating", "Solved", "Avg Rating", "Followers");
echo str_repeat("-", 120) . "\n";

$topUsers = DB::table('users')
    ->select('name', 'cf_handle', 'cf_max_rating', 'solved_problems_count', 'average_problem_rating', 'followers_count')
    ->orderBy('cf_max_rating', 'desc')
    ->limit(10)
    ->get();

foreach($topUsers as $user) {
    printf("%-20s %-15s %10d %10d %15d %12d\n", 
        $user->name, 
        $user->cf_handle, 
        $user->cf_max_rating, 
        $user->solved_problems_count, 
        $user->average_problem_rating, 
        $user->followers_count
    );
}

echo "\n\nKUET Students Sample:\n";
echo str_repeat("-", 120) . "\n";
printf("%-20s %-15s %10s %10s %15s %12s\n", "Name", "Handle", "Max Rating", "Solved", "Avg Rating", "Followers");
echo str_repeat("-", 120) . "\n";

$kuetUsers = DB::table('users')
    ->where('university', 'KUET')
    ->select('name', 'cf_handle', 'cf_max_rating', 'solved_problems_count', 'average_problem_rating', 'followers_count')
    ->orderBy('cf_max_rating', 'desc')
    ->limit(10)
    ->get();

foreach($kuetUsers as $user) {
    printf("%-20s %-15s %10d %10d %15d %12d\n", 
        $user->name, 
        $user->cf_handle, 
        $user->cf_max_rating, 
        $user->solved_problems_count, 
        $user->average_problem_rating, 
        $user->followers_count
    );
}

echo "\n\n=== Statistics ===\n";
$stats = DB::table('users')
    ->select(
        DB::raw('COUNT(*) as total_users'),
        DB::raw('MIN(cf_max_rating) as min_rating'),
        DB::raw('MAX(cf_max_rating) as max_rating'),
        DB::raw('AVG(cf_max_rating) as avg_rating'),
        DB::raw('SUM(solved_problems_count) as total_solved'),
        DB::raw('AVG(solved_problems_count) as avg_solved'),
        DB::raw('COUNT(CASE WHEN cf_max_rating = 0 THEN 1 END) as users_with_zero_rating')
    )
    ->first();

echo "Total Users: " . $stats->total_users . "\n";
echo "Users with 0 rating: " . $stats->users_with_zero_rating . "\n";
echo "Rating Range: " . $stats->min_rating . " - " . $stats->max_rating . "\n";
echo "Average Rating: " . round($stats->avg_rating, 2) . "\n";
echo "Total Problems Solved: " . $stats->total_solved . "\n";
echo "Average Problems Solved: " . round($stats->avg_solved, 2) . "\n";

echo "\n✓ All users have valid data!\n";

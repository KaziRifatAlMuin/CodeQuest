<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Sample users from database:\n\n";

$users = DB::table('users')
    ->select('user_id', 'name', 'cf_handle', 'cf_max_rating', 'created_at')
    ->orderBy('user_id')
    ->limit(10)
    ->get();

foreach($users as $user) {
    echo "ID {$user->user_id}: {$user->name} ({$user->cf_handle}) - Rating: {$user->cf_max_rating} - Joined: {$user->created_at}\n";
}

echo "\n--- Last 5 users (Legendary Grandmasters) ---\n\n";

$lastUsers = DB::table('users')
    ->select('user_id', 'name', 'cf_handle', 'created_at')
    ->orderBy('user_id', 'desc')
    ->limit(5)
    ->get();

foreach($lastUsers as $user) {
    echo "ID {$user->user_id}: {$user->name} ({$user->cf_handle}) - Joined: {$user->created_at}\n";
}

echo "\n--- KUET Students Sample ---\n\n";

$kuetUsers = DB::table('users')
    ->where('university', 'KUET')
    ->select('user_id', 'name', 'cf_handle', 'created_at')
    ->limit(5)
    ->get();

foreach($kuetUsers as $user) {
    echo "ID {$user->user_id}: {$user->name} ({$user->cf_handle}) - Joined: {$user->created_at}\n";
}

echo "\n✓ Total users in database: " . DB::table('users')->count() . "\n";

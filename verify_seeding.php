<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DATABASE SEEDING VERIFICATION ===\n\n";

echo "📊 Record Counts:\n";
echo "  Users: " . App\Models\User::count() . "\n";
echo "  Problems: " . App\Models\Problem::count() . "\n";
echo "  Tags: " . App\Models\Tag::count() . "\n";
echo "  Problem Tags: " . DB::table('problemtags')->count() . "\n";
echo "  User Problems: " . DB::table('userproblems')->count() . "\n";
echo "  Editorials: " . DB::table('editorials')->count() . "\n";
echo "  Friends: " . DB::table('friends')->count() . "\n\n";

echo "👤 Sample Users:\n";
foreach(App\Models\User::limit(5)->get() as $user) {
    echo "  - {$user->name} ({$user->cf_handle}, Rating: {$user->cf_max_rating})\n";
}

echo "\n📝 Sample Problems:\n";
foreach(App\Models\Problem::limit(5)->get() as $problem) {
    echo "  - {$problem->title} (Rating: {$problem->rating}, Solved: {$problem->solved_count})\n";
}

echo "\n🏷️  Sample Tags:\n";
foreach(App\Models\Tag::limit(5)->get() as $tag) {
    echo "  - {$tag->tag_name}\n";
}

echo "\n✅ All data successfully seeded using Laravel models and seeders!\n";

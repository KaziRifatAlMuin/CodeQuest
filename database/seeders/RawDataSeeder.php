<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RawDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("Reading JSON files...");
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Seed Users
        $this->seedFromJson('users', 'users.json');
        
        // Seed Problems
        $this->seedFromJson('problems', 'problems.json');
        
        // Seed Tags
        $this->seedFromJson('tags', 'tags.json');
        
        // Seed Problem Tags
        $this->seedFromJson('problemtags', 'problemtags.json');
        
        // Seed User Problems
        $this->seedFromJson('userproblems', 'userproblems.json');
        
        // Seed Editorials
        $this->seedFromJson('editorials', 'editorials.json');
        
        // Seed Friends
        $this->seedFromJson('friends', 'friends.json');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info("\nDatabase seeding completed!");
        $this->command->info("Users: " . DB::table('users')->count());
        $this->command->info("Problems: " . DB::table('problems')->count());
        $this->command->info("Tags: " . DB::table('tags')->count());
        $this->command->info("Problem Tags: " . DB::table('problemtags')->count());
        $this->command->info("User Problems: " . DB::table('userproblems')->count());
        $this->command->info("Editorials: " . DB::table('editorials')->count());
        $this->command->info("Friends: " . DB::table('friends')->count());
    }
    
    private function seedFromJson(string $table, string $filename): void
    {
        $jsonPath = database_path("json/{$filename}");
        
        if (!file_exists($jsonPath)) {
            $this->command->warn("JSON file not found: {$filename}");
            return;
        }
        
        $this->command->info("Seeding {$table} from {$filename}...");
        
        $json = file_get_contents($jsonPath);
        $data = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error("JSON decode error in {$filename}: " . json_last_error_msg());
            return;
        }
        
        if (empty($data)) {
            $this->command->warn("No data found in {$filename}");
            return;
        }
        
        // Insert data in chunks to avoid memory issues
        $chunks = array_chunk($data, 100);
        $totalInserted = 0;
        
        foreach ($chunks as $chunk) {
            DB::table($table)->insert($chunk);
            $totalInserted += count($chunk);
        }
        
        $this->command->info("✓ Inserted {$totalInserted} records into {$table}");
    }
}

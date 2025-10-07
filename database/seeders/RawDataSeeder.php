<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RawDataSeeder extends Seeder
{
    public function run(): void
    {
        // Path to your SQL file
        $sqlFile = database_path('SQL/2_insert_data.sql');
        
        if (!file_exists($sqlFile)) {
            $this->command->error("SQL file not found at: {$sqlFile}");
            return;
        }

        $this->command->info("Reading SQL file...");
        
        // Read the SQL file
        $sql = file_get_contents($sqlFile);
        
        // Extract and execute each INSERT statement
        $this->command->info("Processing SQL statements...");
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Extract users INSERT
        if (preg_match('/INSERT INTO `users`.*?VALUES\s*(.*?);/s', $sql, $matches)) {
            $this->command->info("Inserting users...");
            $usersInsert = "INSERT INTO users (name,email,password,role,cf_handle,cf_max_rating,solved_problems_count,average_problem_rating,profile_picture,bio,country,university,followers_count,created_at,updated_at) VALUES " . $matches[1];
            DB::unprepared($usersInsert);
        }
        
        // Extract problems INSERT
        if (preg_match('/INSERT INTO `problems`.*?VALUES\s*(.*?);/s', $sql, $matches)) {
            $this->command->info("Inserting problems...");
            $problemsInsert = "INSERT INTO problems (title,problem_link,rating,solved_count,stars,popularity,created_at,updated_at) VALUES " . $matches[1];
            DB::unprepared($problemsInsert);
        }
        
        // Extract tags INSERT
        if (preg_match('/INSERT INTO `tags`.*?VALUES\s*(.*?);/s', $sql, $matches)) {
            $this->command->info("Inserting tags...");
            $tagsInsert = "INSERT INTO tags (tag_name) VALUES " . $matches[1];
            DB::unprepared($tagsInsert);
        }
        
        // Extract problemtags INSERT
        if (preg_match('/INSERT INTO `problemtags`.*?VALUES\s*(.*?);/s', $sql, $matches)) {
            $this->command->info("Inserting problem tags...");
            $problemTagsInsert = "INSERT INTO problemtags (problem_id,tag_id) VALUES " . $matches[1];
            DB::unprepared($problemTagsInsert);
        }
        
        // Extract userproblems INSERT
        if (preg_match('/INSERT INTO `userproblems`.*?VALUES\s*(.*?);/s', $sql, $matches)) {
            $this->command->info("Inserting user problems...");
            $userProblemsInsert = "INSERT INTO userproblems (user_id,problem_id,status,is_starred,solved_at,submission_link,notes) VALUES " . $matches[1];
            DB::unprepared($userProblemsInsert);
        }
        
        // Extract editorials INSERT
        if (preg_match('/INSERT INTO `editorials`.*?VALUES\s*(.*?);/s', $sql, $matches)) {
            $this->command->info("Inserting editorials...");
            $editorialsInsert = "INSERT INTO editorials (problem_id,author_id,solution,code,upvotes,downvotes,created_at,updated_at) VALUES " . $matches[1];
            DB::unprepared($editorialsInsert);
        }
        
        // Extract friends INSERT
        if (preg_match('/INSERT INTO `friends`.*?VALUES\s*(.*?);/s', $sql, $matches)) {
            $this->command->info("Inserting friends...");
            $friendsInsert = "INSERT INTO friends (user_id,friend_id,is_friend,created_at,updated_at) VALUES " . $matches[1];
            DB::unprepared($friendsInsert);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info("Database seeding completed!");
        $this->command->info("Users: " . DB::table('users')->count());
        $this->command->info("Problems: " . DB::table('problems')->count());
        $this->command->info("Tags: " . DB::table('tags')->count());
        $this->command->info("Problem Tags: " . DB::table('problemtags')->count());
        $this->command->info("User Problems: " . DB::table('userproblems')->count());
        $this->command->info("Editorials: " . DB::table('editorials')->count());
        $this->command->info("Friends: " . DB::table('friends')->count());
    }
}

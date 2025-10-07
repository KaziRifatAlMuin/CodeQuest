# Database Seeding Documentation

## Overview
Successfully seeded the CodeQuest database with realistic Codeforces data using Laravel models and seeders.

## Seeded Data Statistics
- **Users**: 30 (including famous competitive programmers like tourist, Petr, Benq, jiangly, etc.)
- **Problems**: 122 (real Codeforces problems with valid links)
- **Tags**: 25 (math, dp, graphs, trees, greedy, binary-search, etc.)
- **Problem Tags**: 232 (problem-tag relationships)
- **User Problems**: 114 (user-problem solve relationships)
- **Editorials**: 50 (problem editorials with solutions)
- **Friends**: 60 (user friend relationships)

## Models
All models are located in `app/Models/`:
1. **User.php** - Enhanced with CF-related fields (cf_handle, cf_max_rating, etc.)
2. **Problem.php** - With Codeforces problem links
3. **Tag.php** - Algorithm/data structure tags
4. **ProblemTag.php** - Many-to-many relationship between problems and tags
5. **UserProblem.php** - User solve history and problem status
6. **Editorial.php** - Problem solutions and editorials
7. **Friend.php** - User friend relationships

## Seeders
Located in `database/seeders/`:
1. **DatabaseSeeder.php** - Main seeder that calls RawDataSeeder
2. **RawDataSeeder.php** - Imports all data from populate_data.sql
3. **populate_data.sql** - Contains all the SQL INSERT statements

## How to Use

### Fresh Migration and Seed
```bash
php artisan migrate:fresh --seed
```

### Seed Only (without migrating)
```bash
php artisan db:seed
```

### Reset and Re-seed
```bash
php artisan migrate:fresh --seed
```

### Verify Seeded Data
```bash
php verify_seeding.php
```

## Data Features
- **Realistic CF Handles**: tourist, Petr, Benq, ecnerwala, jiangly, neal, etc.
- **Valid Problem Links**: All problems link to real Codeforces problems
- **Diverse Ratings**: Problems range from 800 (beginner) to 1900 (advanced)
- **Complete Relationships**: Users, problems, tags, and friends are all interconnected
- **Historical Data**: Created/updated timestamps span from 2020 to 2025

## Sample Data

### Sample User
```php
Name: Gennady Korotkevich
Email: tourist@example.com
CF Handle: tourist
Max Rating: 3822
Bio: Legendary grandmaster, IOI gold medalist
Country: Belarus
University: ITMO
```

### Sample Problem
```php
Title: Way Too Long Words
Link: https://codeforces.com/problemset/problem/71/A
Rating: 800
Solved Count: 150,234
Stars: 950
Popularity: 0.95
```

## Technical Details
- All passwords are hashed using `Hash::make('password')`
- Foreign key checks are handled properly during seeding
- RawDataSeeder uses regex to extract and execute SQL INSERT statements
- Data is seeded in proper order to respect foreign key constraints

## Verification Command
```bash
php artisan tinker --execute="
    echo 'Users: ' . App\Models\User::count() . PHP_EOL;
    echo 'Problems: ' . App\Models\Problem::count() . PHP_EOL;
    echo 'First User: ' . App\Models\User::first()->name . PHP_EOL;
"
```

Or use the verification script:
```bash
php verify_seeding.php
```

## Success! ✅
All data has been successfully seeded into the database using Laravel models and seeders!

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

 

# CodeQuest

> A Laravel-powered platform to discover, track, and discuss programming problems. Built for competitive programmers with rich search, tagging, leaderboards, editorials, social following, and a SQL “Quest” playground — all optimized for MySQL and Windows/XAMPP.

---

## What you can do

- Browse a curated problemset with full-text search, tag filters, rating ranges, sort, and pagination
- Mark progress per problem: unsolved/trying/solved, add notes and submission links, star favorites
- Write and vote on editorials for each problem (owner can edit; admins can remove)
- See a leaderboard ranked by Codeforces max rating, solved count, and average solved rating
- Follow/unfollow users; view followers and following lists
- Explore tags with problem counts, filtering modes (single/AND/OR), and visual summaries
- Run ad‑hoc read-only queries against the platform database using the built-in SQL Quest
- View advanced analytics and activity feeds powered by SQL views and window functions
- Manage tags and roles from an admin dashboard (roles: user, moderator, admin)

---

## Data model (tables and key fields)

- users (PK user_id): name, email, password, role[user|moderator|admin], cf_handle, cf_max_rating, solved_problems_count, average_problem_rating, profile_picture, bio(<=200), country, university, followers_count, email_verified_at, handle_verified_at, timestamps
- problems (PK problem_id): title, problem_link, rating, solved_count, stars, popularity (0..1, stars/maxStars), timestamps
- tags (PK tag_id): tag_name
- problemtags (PK problemtag_id): problem_id FK→problems, tag_id FK→tags, unique(problem_id, tag_id)
- userproblems (PK userproblem_id): user_id FK→users, problem_id FK→problems, status[unsolved|trying|solved], is_starred, solved_at, submission_link, notes
- editorials (PK editorial_id): problem_id FK→problems, author_id FK→users, solution, code, upvotes, downvotes, timestamps
- friends (PK relationship_id): user_id FK→users, friend_id FK→users, is_friend, timestamps

Advanced SQL pack in `database/SQL/` adds:
- Views: `user_statistics_view`, `problem_statistics_view`, `editorial_statistics_view`, `social_network_view`
- Procedures: `update_problem_statistics`, `update_user_statistics`, `bulk_update_problem_statistics`, `get_user_leaderboard`
- Functions: `get_user_rank`, `get_difficulty_category`, `get_user_progress`, `get_editorial_quality`
- Triggers to keep aggregates consistent (optional)

---

## Tech stack

- Laravel 12, PHP 8.2
- MySQL (InnoDB), window functions, views, procedures, triggers
- Vite 7, Tailwind CSS 4, Bootstrap 5 for UI assets
- Authentication with email verification and Codeforces handle verification

---

## Architecture highlights

• Raw SQL where it adds value (window functions, manual pagination, analytics) combined with Eloquent hydration for models
• Helpers for UX: `App\\Helpers\\RatingHelper` (Codeforces colors/titles), `App\\Helpers\\SearchHelper` (pagination inputs, highlighting)
• Clear domain models: `User`, `Problem`, `Tag`, `ProblemTag`, `UserProblem`, `Editorial`, `Friend`
• Middleware and policies-like gates: `verified`, `checkRole`, `editorialOwner`, `setUserTimezone`
• Feature-focused controllers and routes (see `routes/web.php`)

---

## Local setup (Windows + XAMPP or PHP built-in)
```powershell
# from a directory of your choice
cd C:\\xampp\\htdocs
git clone https://github.com/KaziRifatAlMuin/CodeQuest.git
cd CodeQuest
composer install
npm install

# Create .env and set APP_KEY
copy .env.example .env
php artisan key:generate

# Configure DB in .env (XAMPP defaults)
# DB_DATABASE=codequest_db; DB_USERNAME=root; DB_PASSWORD=

# Migrate and seed with JSON data
php artisan migrate:fresh --seed

# Run the app and Vite
php artisan serve
npm run dev

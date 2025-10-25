# Pages & Features — Detailed Tour

This document expands the "Pages & Features" section for the CodeQuest site. It contains per-page descriptions, UX notes, recommended screenshots (placeholders provided), and quick references to the controllers, models, and views to inspect when modifying behavior.

Note: The main README preserves the Laravel logo as requested. If you want this content copied into README.md directly, I can do that in small patches once the patch tool is stable; for now this lives in docs/PAGES_AND_FEATURES.md and README can link to it.

---

## How to use this file

- Each page below includes:
  - Short description of the page's purpose.
  - Key actions a user can take.
  - UX notes and suggested screenshot(s).
  - Where to look in the codebase (controllers, views, models, helpers) to update or extend the feature.

- Screenshots are referenced as `docs/screenshots/<page>.png`. They are placeholders now; replace them with real PNGs if you capture UI images.

---

## Home / Landing

Purpose
- Public landing page showcasing recent problems, editorials, and top users.

Key actions
- Browse featured or trending problems.
- Quick search to find problems by title, tag or difficulty.

UX notes
- Prominent search bar at top with tag suggestions and autocomplete.
- Sections: Featured Problems, Top Rated Users, Recent Editorials.

Screenshot (placeholder)
- docs/screenshots/home.png

Where to edit
- Controller: `App\Http\Controllers\SiteController::home`
- Models: `App\Models\Problem`, `App\Models\User`, `App\Models\Editorial`
- Views: resources/views/home.blade.php (or `views/site/home` depending on conventions)

Notes
- `SiteController::home` uses raw SQL for aggregated queries and then hydrates models. If you need to change what appears on the home page, update the SQL in that method or switch to Eloquent queries.

---

## Problems Listing (Browse)

Purpose
- Browse and filter all problems.

Key actions
- Filter by tag, difficulty, or popularity.
- Sort by newest, most solved, or top-rated.
- Pagination and per-page settings.

UX notes
- Left sidebar for tags and filters.
- Main list with problem title, difficulty, tags, solved count, and a star/favorite icon.

Screenshot (placeholder)
- docs/screenshots/problems_list.png

Where to edit
- Controller: `App\Http\Controllers\ProblemController::index`
- Model: `App\Models\Problem` (attributes: difficulty, solved_count, stars)
- Views: resources/views/problems/index.blade.php
- Helpers: `App\Helpers\SearchHelper` for highlighting and paginating search results

Notes
- ProblemController often uses raw SQL — be careful when adding filters: either expand the SQL safely, or use Eloquent + eager loading to maintain readability.

---

## Problem Detail

Purpose
- Show a full problem statement, tags, editorial links, stats, and user interactions.

Key actions
- Read the problem statement and editorial(s).
- Mark as solved, add notes, rate the problem, or star it.
- View solution history, comments or votes (if implemented).

UX notes
- Problem header: title, difficulty badge, solved count, author.
- Tabs or collapsible sections: Statement, Editorials, Submissions/Solutions.

Screenshot (placeholder)
- docs/screenshots/problem_detail.png

Where to edit
- Controller: `App\Http\Controllers\ProblemController::show`
- Related controllers: `UserProblemController` for mark-solved and star toggles
- Models: `App\Models\Problem`, `App\Models\UserProblem`, `App\Models\Editorial`
- Views: resources/views/problems/show.blade.php

Notes
- `UserProblem::boot()` updates user and problem metrics when userproblem records are created/updated/deleted; keep this in mind when changing the user-solved workflow.

---

## Editorials

Purpose
- Publish editorial content explaining solutions, approaches, or walkthroughs per problem.

Key actions
- Read editorial content, see author, date, and linked problems.
- Create or edit editorial if the user has permission (editor role).

UX notes
- Editorial page shows rich text (Markdown/HTML) with code blocks and in-line images.
- Include "Related problems" or navigation links to the referenced problem pages.

Screenshot (placeholder)
- docs/screenshots/editorial.png

Where to edit
- Controller: `App\Http\Controllers\EditorialController`
- Model: `App\Models\Editorial`
- Views: resources/views/editorial/*.blade.php
- Middleware: editorial owner verification `editorialOwner` (in app/Http/Middleware)

Notes
- Editorial creation is protected (check middleware `checkRole` or `editorialOwner`) — update these middleware classes if you change permission flows.

---

## Tags & Tag Pages

Purpose
- Categorize problems and provide tag-specific listings.

Key actions
- View problems by tag.
- For admins: create/rename/merge tags.

UX notes
- Tag cloud or list of popular tags.
- Tag page shows top problems for that tag and related tags.

Screenshot (placeholder)
- docs/screenshots/tag_page.png

Where to edit
- Controller: `App\Http\Controllers\TagController`
- Model: `App\Models\Tag`, `App\Models\ProblemTag`
- Views: resources/views/tags/*.blade.php

Notes
- Problem–Tag relations are stored in `problemtags` pivot table; migrations define the schema in database/migrations.

---

## User Profile & Account

Purpose
- Show user summary, solved problems, rating, and handles (e.g., Codeforces handle).

Key actions
- View solved problems, accuracy, average rating given and received.
- Edit account settings (password, email, handles).

UX notes
- Profile header: avatar, username, handle verification state.
- Tabs for Overview, Problems, Activity, Settings.

Screenshot (placeholder)
- docs/screenshots/user_profile.png

Where to edit
- Controller: `App\Http\Controllers\UserController`, `App\Http\Controllers\AccountController`
- Models: `App\Models\User`, `App\Models\UserProblem`
- Views: resources/views/account/* and resources/views/users/*
- Helpers: `App\Helpers\RatingHelper` for rendering badges/colors

Notes
- The account flows use email verification and (optionally) third-party handle verification (e.g., Codeforces) — see `AccountController` for the handle verification logic.

---

## Friends / Social

Purpose
- Follow or befriend other users and view friends' activity.

Key actions
- Send and accept friend requests, follow/unfollow, view friend activity feed.

UX notes
- Inline friend button on profiles.
- Activity feed shows recent solves, new editorials, and comments.

Screenshot (placeholder)
- docs/screenshots/friends.png

Where to edit
- Controller: `App\Http\Controllers\FriendController`
- Model: `App\Models\Friend`
- Views: resources/views/friends/*

Notes
- Friend relationships are stored in `friends` table; check migration and seeding for structure and test data.

---

## Quest (SQL Builder / Analytics Playground)

Purpose
- A safe, guided SQL query builder and explorer for analytics (for admins or power users).

Key actions
- Select tables and up to 5 columns, auto-generate JOINs when possible.
- Run queries with a LIMIT (safety limit applied) and view results paginated.

UX notes
- Presents columns as selectable checkboxes and attempts to auto-suggest joins.
- Shows executed SQL and download/export options for results.

Screenshot (placeholder)
- docs/screenshots/quest.png

Where to edit
- Controller: `App\Http\Controllers\QuestController` (important methods: sanitizeColumnName(), buildFromClause(), getJoinCondition())
- Views: resources/views/quest/*.blade.php

Notes
- QuestController limits number of selected columns to 5 and sets a maximum LIMIT (currently used to avoid heavy queries). Its sanitization logic is critical: do not bypass it unless you replicate equivalent protection.

---

## Admin Dashboard

Purpose
- Overview of platform metrics, user activity, pending editorial reviews, and moderation tools.

Key actions
- Manage users, tags, problems; view usage metrics and run seed/migration helper tasks.

UX notes
- Key KPI tiles (total users, active today, problems solved today), charts, and action lists.

Screenshot (placeholder)
- docs/screenshots/admin_dashboard.png

Where to edit
- Controllers: `App\Http\Controllers\StatisticsController`, `App\Http\Controllers\AnalyticsController`
- Views: resources/views/admin/*

Notes
- Many of the metrics are implemented via raw SQL for performance; be careful when changing aggregated queries.

---

## Search

Purpose
- Global site search across problems, users, and editorials.

Key actions
- Keyword search with highlighting and filter by type.

UX notes
- Fast suggestions (type ahead) and highlighted matches in results.

Screenshot (placeholder)
- docs/screenshots/search.png

Where to edit
- Helpers: `App\Helpers\SearchHelper`
- Controller(s): search endpoints are likely in `SiteController` or dedicated `SearchController`
- Views: resources/views/components/search/*

Notes
- SearchHelper contains functions for highlight() and building query conditions; update it when altering highlight behavior.

---

## Ratings and Stars

Purpose
- Allow users to rate problems and star/bookmark problems.

Key actions
- Rate a problem (1–5), give feedback, toggle star for quick access later.

UX notes
- Ratings shown as badge + color via `RatingHelper` (class/color/title mapping).
- Star icon toggles state without page reload (AJAX preferred).

Screenshot (placeholder)
- docs/screenshots/ratings.png

Where to edit
- Helpers: `App\Helpers\RatingHelper`
- Controllers: rating logic may be in `ProblemController` or `UserProblemController`
- Models: `App\Models\UserProblem`, `App\Models\Problem`

Notes
- When updating ratings, check code that recalculates aggregate ratings and solved counts (model observers or `UserProblem::boot()` event handlers).

---

## Notifications & Activity Feed

Purpose
- Inform users about friend activity, editorial comments, and admin announcements.

Key actions
- View activity feed, mark notifications as read.

UX notes
- Compact timeline with icons for activity types (solve, editorial, follow).

Screenshot (placeholder)
- docs/screenshots/activity.png

Where to edit
- Controllers: `App\Http\Controllers\ActivityController`
- Views: resources/views/activity/*

Notes
- Database schema for activity/notifications (if present) may be separate tables — search `migrations` for `notifications` or `activity` tables.

---

## API Endpoints (if any)

Purpose
- Provide JSON endpoints for frontend SPA or third-party integrations.

Key actions
- Return paginated problems, user stats, and search results.

Where to edit
- Controllers: any controller methods that return JSON (look for `return response()->json(...)` or API-specific controllers)
- Routes: `routes/web.php` may include some API-like routes; check `routes/api.php` if present.

Notes
- Ensure API endpoints are properly rate-limited and authenticated where needed. If transforming data shapes, prefer Resource classes (Laravel API Resource) for consistent outputs.

---

## Developer Notes & Quick Links

Quick references to files that control major features:

- Home: `app/Http/Controllers/SiteController.php`
- Problems: `app/Http/Controllers/ProblemController.php`, model `app/Models/Problem.php`
- User problems (solving, rating, starring): `app/Http/Controllers/UserProblemController.php`, model `app/Models/UserProblem.php`
- Editorials: `app/Http/Controllers/EditorialController.php`, model `app/Models/Editorial.php`
- Tags: `app/Http/Controllers/TagController.php`, models `app/Models/Tag.php`, `app/Models/ProblemTag.php`
- Quest playground: `app/Http/Controllers/QuestController.php`
- Helpers: `app/Helpers/RatingHelper.php`, `app/Helpers/SearchHelper.php`
- Routes: `routes/web.php`
- Database seeds and JSON fixtures: `database/seeders/RawDataSeeder.php`, `database/json/`
- Advanced SQL artifacts: `database/SQL/3_advanced_features.sql`

Edge cases and safety
- Quest functionality: never bypass the column count and sanitization checks.
- Bulk operations (e.g., recalculating ratings) should be queued where possible to avoid long request times.
- When using raw SQL, always sanitize inputs or use parameter binding to avoid injection risks.

---

## Website Screenshots 
- docs/screenshots/1.png
- docs/screenshots/2.png
- docs/screenshots/3.png
- docs/screenshots/4.png
- docs/screenshots/5.png
- docs/screenshots/6.png
- docs/screenshots/7.png
- docs/screenshots/8.png
- docs/screenshots/9.png
- docs/screenshots/10.png
- docs/screenshots/11.png
- docs/screenshots/12.png
- docs/screenshots/13.png
- docs/screenshots/14.png
- docs/screenshots/15.png


For best results, capture at 1440×900 or 1920×1080, crop to highlight relevant UI portions, and compress images to under 300KB for Git.

---

## Next steps I can take for you

- Insert this content into `README.md` in smaller, atomic patches so the file contains the Pages & Features section directly. (I attempted to patch README earlier but the patch tool experienced runtime errors; I can try again in small pieces.)
- Add the screenshot files for you if you provide captures.
- Create a clickable Table of Contents in README linking to the sections added here.

If you'd like me to copy this content into `README.md` now, tell me whether to
- (A) Append it at the bottom, or
- (B) Insert it under a specific heading.

---

End of Pages & Features tour.

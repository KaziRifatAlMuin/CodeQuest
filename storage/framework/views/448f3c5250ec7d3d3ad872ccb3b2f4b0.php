<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> SQL Quest - Query Builder <?php $__env->endSlot(); ?>

    <div id="quest-root" class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="hero-section text-center py-5 mb-4">
                    <div class="hero-content">
                        <h1 class="hero-title">SQL Quest</h1>
                        <p class="hero-subtitle">Interactive Database Query Playground</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fas fa-database"></i>
                                <span id="selectedTablesCount">0</span> Tables
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-columns"></i>
                                <span id="selectedColumnsCount">0</span>/5 Columns
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Display -->
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Query Error:</strong>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Main Query Builder -->
        <form action="<?php echo e(route('quest.execute')); ?>" method="POST" id="queryForm">
            <?php echo csrf_field(); ?>
            
            <!-- Table Selection Section -->
            <div class="section-header mb-4">
                <h2><i class="fas fa-table"></i> Step 1: Select Tables</h2>
                <p class="text-muted">Choose tables to query from. Click on a table card to select it and unlock column options.</p>
            </div>

            <div class="row g-4 mb-5" id="tableSelection">
                <!-- Users Table -->
                <div class="col-lg-4 col-md-6">
                    <div class="table-card" data-table="users" data-alias="U">
                        <div class="table-card-header">
                            <div class="table-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5>Users</h5>
                            <span class="table-alias">U</span>
                        </div>
                        <div class="table-card-body">
                            <div class="columns-section">
                                <h6>Available Columns:</h6>
                                <div class="column-checkboxes">
                                    <label><input type="checkbox" value="U.user_id" disabled> ID</label>
                                    <label><input type="checkbox" value="U.name" disabled> Name</label>
                                    <label><input type="checkbox" value="U.email" disabled> Email</label>
                                    <label><input type="checkbox" value="U.cf_handle" disabled> CF Handle</label>
                                    <label><input type="checkbox" value="U.cf_max_rating" disabled> Max Rating</label>
                                    <label><input type="checkbox" value="U.country" disabled> Country</label>
                                    <label><input type="checkbox" value="U.university" disabled> University</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Problems Table -->
                <div class="col-lg-4 col-md-6">
                    <div class="table-card" data-table="problems" data-alias="P">
                        <div class="table-card-header">
                            <div class="table-icon">
                                <i class="fas fa-puzzle-piece"></i>
                            </div>
                            <h5>Problems</h5>
                            <span class="table-alias">P</span>
                        </div>
                        <div class="table-card-body">
                            <div class="columns-section">
                                <h6>Available Columns:</h6>
                                <div class="column-checkboxes">
                                    <label><input type="checkbox" value="P.problem_id" disabled> ID</label>
                                    <label><input type="checkbox" value="P.title" disabled> Title</label>
                                    <label><input type="checkbox" value="P.rating" disabled> Rating</label>
                                    <label><input type="checkbox" value="P.solved_count" disabled> Solved Count</label>
                                    <label><input type="checkbox" value="P.stars" disabled> Stars</label>
                                    <label><input type="checkbox" value="P.popularity" disabled> Popularity</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags Table -->
                <div class="col-lg-4 col-md-6">
                    <div class="table-card" data-table="tags" data-alias="T">
                        <div class="table-card-header">
                            <div class="table-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h5>Tags</h5>
                            <span class="table-alias">T</span>
                        </div>
                        <div class="table-card-body">
                            <div class="columns-section">
                                <h6>Available Columns:</h6>
                                <div class="column-checkboxes">
                                    <label><input type="checkbox" value="T.tag_id" disabled> ID</label>
                                    <label><input type="checkbox" value="T.tag_name" disabled> Tag Name</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UserProblems Table -->
                <div class="col-lg-4 col-md-6">
                    <div class="table-card" data-table="userproblems" data-alias="UP">
                        <div class="table-card-header">
                            <div class="table-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h5>User Problems</h5>
                            <span class="table-alias">UP</span>
                        </div>
                        <div class="table-card-body">
                            <div class="columns-section">
                                <h6>Available Columns:</h6>
                                <div class="column-checkboxes">
                                    <label><input type="checkbox" value="UP.userproblem_id" disabled> ID</label>
                                    <label><input type="checkbox" value="UP.status" disabled> Status</label>
                                    <label><input type="checkbox" value="UP.is_starred" disabled> Starred</label>
                                    <label><input type="checkbox" value="UP.solved_at" disabled> Solved At</label>
                                    <label><input type="checkbox" value="UP.submission_link" disabled> Submission</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Editorials Table -->
                <div class="col-lg-4 col-md-6">
                    <div class="table-card" data-table="editorials" data-alias="E">
                        <div class="table-card-header">
                            <div class="table-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h5>Editorials</h5>
                            <span class="table-alias">E</span>
                        </div>
                        <div class="table-card-body">
                            <div class="columns-section">
                                <h6>Available Columns:</h6>
                                <div class="column-checkboxes">
                                    <label><input type="checkbox" value="E.editorial_id" disabled> ID</label>
                                    <label><input type="checkbox" value="E.solution" disabled> Solution</label>
                                    <label><input type="checkbox" value="E.code" disabled> Code</label>
                                    <label><input type="checkbox" value="E.upvotes" disabled> Upvotes</label>
                                    <label><input type="checkbox" value="E.downvotes" disabled> Downvotes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ProblemTags Table -->
                <div class="col-lg-4 col-md-6">
                    <div class="table-card" data-table="problemtags" data-alias="PT">
                        <div class="table-card-header">
                            <div class="table-icon">
                                <i class="fas fa-link"></i>
                            </div>
                            <h5>Problem Tags</h5>
                            <span class="table-alias">PT</span>
                        </div>
                        <div class="table-card-body">
                            <div class="columns-section">
                                <h6>Available Columns:</h6>
                                <div class="column-checkboxes">
                                    <label><input type="checkbox" value="PT.problem_id" disabled> Problem ID</label>
                                    <label><input type="checkbox" value="PT.tag_id" disabled> Tag ID</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Query Options Section -->
            <div class="section-header mb-4">
                <h2><i class="fas fa-cogs"></i> Step 2: Query Options</h2>
                <p class="text-muted">Configure WHERE conditions, sorting, and other query parameters.</p>
            </div>

            <div class="row g-4 mb-5">
                <!-- WHERE Conditions -->
                <div class="col-lg-6">
                    <div class="query-option-card">
                        <div class="card-header">
                            <h5><i class="fas fa-filter"></i> WHERE Conditions</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Available Columns for Conditions:</label>
                                <div id="whereColumnsHelp" class="where-columns-help">
                                    <em>Select tables to see all available columns for WHERE conditions</em>
                                </div>
                            </div>
                            <textarea 
                                class="form-control" 
                                id="whereClause" 
                                name="where_clause" 
                                rows="4" 
                                placeholder="Example: U.cf_max_rating > 1500 AND P.rating >= 1000 AND U.university = 'MIT'"></textarea>
                            <small class="form-text text-muted">
                                Use table aliases (U, P, T, UP, E, PT) and any column from selected tables
                            </small>
                        </div>
                    </div>
                </div>

                <!-- ORDER BY -->
                <div class="col-lg-6">
                    <div class="query-option-card">
                        <div class="card-header">
                            <h5><i class="fas fa-sort"></i> Sorting</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <label class="form-label">Order By Column:</label>
                                    <select class="form-select" id="orderBy" name="order_by">
                                        <option value="">Select column to sort by</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Direction:</label>
                                    <select class="form-select" name="order_direction">
                                        <option value="ASC">Ascending</option>
                                        <option value="DESC">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Query Preview and Execute -->
            <div class="query-preview-section mb-5">
                <div class="query-preview-card">
                    <div class="card-header">
                        <h5><i class="fas fa-code"></i> Generated Query</h5>
                        <div class="query-stats">
                            <span class="stat">Tables: <span id="queryTableCount">0</span></span>
                            <span class="stat">Columns: <span id="queryColumnCount">0</span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <pre id="queryPreview" class="query-preview">SELECT columns FROM tables WHERE conditions ORDER BY column;</pre>
                        <div class="query-actions">
                            <button type="submit" class="btn btn-execute" id="executeBtn" disabled
                                style="background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%) !important; background-image: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%) !important; color: var(--light) !important; border: none !important;">
                                <i class="fas fa-play"></i> Execute Query
                            </button>
                            <button type="button" class="btn btn-secondary" id="resetBtn"
                                style="background: var(--light) !important; background-image: none !important; color: var(--text) !important; border: 1px solid var(--border) !important;">
                                <i class="fas fa-undo"></i> Reset All
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="copyQueryBtn"
                                style="background: transparent !important; background-image: none !important; color: var(--primary) !important; border: 1px solid var(--primary) !important;">
                                <i class="fas fa-copy"></i> Copy Query
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden inputs for selected data -->
            <input type="hidden" name="tables" id="selectedTablesInput">
            <input type="hidden" name="columns" id="selectedColumnsInput">
        </form>
        <!-- Results Display -->
        <div id="resultsSection" class="results-section" style="display: none;">
            <div class="section-header mb-4">
                <h2><i class="fas fa-table"></i> Query Results</h2>
                <div class="results-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="resultsSearch" placeholder="Search results...">
                    </div>
                    <div class="results-info">
                        <span id="resultsCount">0</span> rows found
                    </div>
                </div>
            </div>

            <div class="results-card">
                <div class="results-header">
                    <div class="results-pagination">
                        <button id="prevPage" class="pagination-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span class="pagination-info">
                            Page <span id="currentPage">1</span> of <span id="totalPages">1</span>
                        </span>
                        <button id="nextPage" class="pagination-btn" disabled>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="results-actions">
                        <button class="btn btn-outline-primary btn-sm" id="exportBtn">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="results-table" id="resultsTable">
                        <thead id="resultsHead"></thead>
                        <tbody id="resultsBody"></tbody>
                    </table>
                </div>

                <div class="results-footer">
                    <div class="results-stats">
                        Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalResults">0</span> results
                    </div>
                    <div class="rows-per-page">
                        <label>Rows per page:</label>
                        <select id="rowsPerPage">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Use site-wide variables from layout to keep the page light and consistent */

        /* Main container - light background (scoped to this page) */
        #quest-root {
            background: var(--light) !important;
            color: var(--text) !important;
        }

        /* Force common components inside this page to use light backgrounds and text
           This avoids inherited dark gradients from layout or global styles. We intentionally
           avoid overriding small decorative elements (like .table-icon) so accents still show.
        */
        #quest-root .card,
        #quest-root .table-card,
        #quest-root .query-preview-card,
        #quest-root .results-card,
        #quest-root .alert,
        #quest-root .where-columns-help,
        #quest-root .results-table th,
        #quest-root .results-table td,
        #quest-root .columns-section {
            background: var(--light) !important;
            color: var(--text) !important;
            border-color: var(--border) !important;
            background-image: none !important;
        }

        /* Hero Section - light subtle gradient like other pages */
        .hero-section {
            background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%);
            border-radius: 20px;
            color: var(--text);
            margin-bottom: 2rem;
            border: none;
        }

        .hero-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--primary);
        }

        .hero-subtitle {
            font-size: 1rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 1.25rem;
        }

        .stat-item {
            background: rgba(255,255,255,0.6);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            color: var(--text);
        }

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .section-header h2 {
            /* use main text color so headings stay light-themed */
            color: var(--text);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-light);
        }

        /* Table Cards */
        .table-card {
            background: var(--light);
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.22s ease, box-shadow 0.22s ease;
            cursor: pointer;
            border: none !important; /* no border by default */
            height: 100%;
            position: relative;
            overflow: visible;
        }

        .table-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.08);
        }

        /* Selected card: animated border color pulse */
        .table-card.selected {
            /* gradient border using border-image for a crisp colored edge */
            border: 2px solid transparent;
            border-image: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 60%, var(--success) 100%) 1;
            background: var(--light);
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 18px 40px rgba(0,0,0,0.08), 0 6px 14px rgba(0,0,0,0.04);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-image 0.3s linear;
        }

        .table-card.selected::after {
            /* soft animated glow matching the border colors */
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 20px;
            pointer-events: none;
            background: linear-gradient(90deg, rgba(102,126,234,0.12), rgba(16,185,129,0.08));
            filter: blur(12px);
            opacity: 0.9;
            transition: opacity 0.35s ease;
            z-index: 0;
        }

        .table-card .table-card-header,
        .table-card .table-card-body {
            position: relative;
            z-index: 2; /* render above the glow pseudo-element */
        }

        .table-card-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .table-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--text);
            font-size: 1.5rem;
        }

        .table-card h5 {
            color: var(--text);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .table-alias {
            background: var(--success);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .table-card-body {
            padding: 1rem 1.5rem 1.5rem;
        }

        .columns-section h6 {
            color: var(--text);
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .column-checkboxes {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            transition: opacity 0.18s ease, transform 0.18s ease;
            opacity: 0.45;
            pointer-events: none;
            transform: translateY(4px);
        }

        /* labels subdued until table is selected */
        .column-checkboxes label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s, opacity 0.15s;
            font-size: 0.9rem;
            color: var(--text-light);
            opacity: 0.75;
        }

        /* make the label full-width so clicking anywhere on the row toggles */
        .column-checkboxes label {
            width: 100%;
            user-select: none;
        }

        .column-checkboxes label:hover {
            background: rgba(0,0,0,0.03);
        }

        .column-checkboxes input[type="checkbox"] {
            margin: 0;
            accent-color: var(--primary);
        }

        .column-checkboxes input[type="checkbox"]:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* When a table is selected: enable pointer events and make labels fully visible */
        .table-card.selected .column-checkboxes {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .table-card.selected .column-checkboxes label {
            color: var(--text);
            opacity: 1;
        }

        /* Query Option Cards */
        .query-option-card {
            background: var(--light);
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            height: 100%;
        }

        .query-option-card .card-header {
            background: var(--light);
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.5rem;
            border-radius: 15px 15px 0 0;
        }

        .query-option-card .card-header h5 {
            margin: 0;
            color: var(--text);
            font-weight: 600;
        }

        .query-option-card .card-body {
            padding: 1.5rem;
        }

        .where-columns-help {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: var(--text);
            max-height: 120px;
            overflow-y: auto;
        }

        .where-columns-help .columns-info {
            line-height: 1.4;
        }

        .where-columns-help strong {
            color: var(--primary);
        }

        /* Query Preview */
        .query-preview-section {
            text-align: center;
        }

        .query-preview-card {
            background: var(--light);
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
        }

        .query-preview-card .card-header {
            /* Keep header light and consistent with site theme */
            background: var(--light);
            color: var(--text);
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .query-preview-card .card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .query-stats {
            display: flex;
            gap: 1rem;
        }

        .query-stats .stat {
            background: rgba(255,255,255,0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
        }

        .query-preview {
            /* make the SQL preview light so it matches the rest of the page */
            background: var(--light);
            color: var(--text);
            padding: 1.25rem;
            border-radius: 8px;
            font-family: 'Monaco', 'Menlo', 'Consolas', monospace;
            font-size: 0.9rem;
            line-height: 1.5;
            overflow-x: auto;
            margin-bottom: 1rem;
            border: 1px solid var(--border);
        }

        .query-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        /* Unified action buttons styling inside the query actions area */
        .query-actions .btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important;
            color: white !important;
            border: none !important;
            padding: 0.72rem 1.6rem;
            border-radius: 22px;
            font-weight: 700;
            letter-spacing: 0.2px;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            transition: transform 0.14s ease, box-shadow 0.14s ease, opacity 0.14s ease;
            box-shadow: 0 6px 18px rgba(102,126,234,0.10);
        }

        .query-actions .btn:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(102,126,234,0.16);
            opacity: 0.98;
        }

        /* Keep disabled look consistent */
        .query-actions .btn:disabled {
            background: var(--border) !important;
            color: var(--text-light) !important;
            cursor: not-allowed;
            box-shadow: none;
            opacity: 0.7;
        }

        /* Specific button variants inside the actions area */
        #executeBtn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--success) 100%) !important;
            color: white !important;
            box-shadow: 0 8px 24px rgba(102,126,234,0.14) !important;
        }

        #resetBtn {
            background: var(--light) !important;
            color: var(--text) !important;
            border: 1px solid var(--border) !important;
            box-shadow: none !important;
        }

        #copyQueryBtn {
            background: transparent !important;
            color: var(--primary) !important;
            border: 1px solid var(--primary) !important;
            box-shadow: none !important;
        }

        .btn-execute:disabled {
            background: var(--border);
            cursor: not-allowed;
            opacity: 0.65;
        }

        /* Results Section */
        .results-section {
            animation: fadeInUp 0.5s ease-in-out;
        }

        .results-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 0.9rem;
            transition: border-color 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }

        .results-info {
            color: #6c757d;
            font-weight: 500;
        }

        .results-card {
            background: var(--light);
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .results-header {
            background: var(--light);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .results-pagination {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pagination-btn {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover:not(:disabled) {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-info {
            font-weight: 500;
            color: var(--text);
        }

        .table-container {
            overflow-x: auto;
            max-height: 500px;
            overflow-y: auto;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .results-table th {
            background: var(--light);
            color: var(--text);
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            border-bottom: 2px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .results-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            transition: background 0.2s ease;
        }

        .results-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .results-footer {
            background: var(--light);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .results-stats {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .rows-per-page {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--text);
        }

        .rows-per-page select {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 0.25rem 0.5rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .table-row-animate {
            animation: slideInFromLeft 0.3s ease-out forwards;
        }

        /* Loading states */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        /* Enhanced hover effects */
        .results-table th:hover {
            background: #e9ecef !important;
            color: #495057;
        }

        .results-table th::after {
            content: ' ⇅';
            opacity: 0.5;
            font-size: 0.8em;
        }

        /* Success/Error states */
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* Mobile optimizations */
        @media (max-width: 576px) {
            .table-card {
                margin-bottom: 1rem;
            }

            .column-checkboxes {
                /* allow columns to be viewable on mobile as well; avoid clipping */
                max-height: none;
                overflow: visible;
            }

            .query-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .results-table {
                font-size: 0.85rem;
            }

            .results-table th,
            .results-table td {
                padding: 0.5rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .table-card {
                background: #2c3e50;
                color: #ecf0f1;
            }

            .query-option-card {
                background: #2c3e50;
                color: #ecf0f1;
            }

            .query-preview-card {
                background: #2c3e50;
            }

            .results-card {
                background: #2c3e50;
                color: #ecf0f1;
            }
        }

        /* Pulse animation for loading states */
        .pulse {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .query-actions {
                flex-direction: column;
            }

            .results-controls {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .search-box {
                width: 100%;
            }

            .results-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .results-footer {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // State management
            let selectedTables = [];
            let selectedColumns = [];
            let allResults = [];
            let currentPage = 1;
            let rowsPerPage = 25;
            let filteredResults = [];

            // DOM elements
            const tableCards = document.querySelectorAll('.table-card');
            const executeBtn = document.getElementById('executeBtn');
            const resetBtn = document.getElementById('resetBtn');
            const copyQueryBtn = document.getElementById('copyQueryBtn');
            const queryPreview = document.getElementById('queryPreview');
            const whereColumnsHelp = document.getElementById('whereColumnsHelp');
            const orderBySelect = document.getElementById('orderBy');
            const resultsSection = document.getElementById('resultsSection');
            const resultsSearch = document.getElementById('resultsSearch');

            // Initialize
            updateUI();

            // Column checkbox handlers
            document.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox' && e.target.value && e.target.value.includes('.')) {
                    if (e.target.checked) {
                        if (selectedColumns.length < 5) {
                            selectedColumns.push(e.target.value);
                        } else {
                            e.target.checked = false;
                            alert('Maximum 5 columns can be selected');
                            return;
                        }
                    } else {
                        selectedColumns = selectedColumns.filter(col => col !== e.target.value);
                    }
                    updateUI();
                }
            });

            // Table card click handlers
            tableCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Don't trigger card click when clicking on checkboxes
                    if (e.target.type === 'checkbox') {
                        return;
                    }
                    
                    const table = this.dataset.table;
                    const alias = this.dataset.alias;
                    
                    if (this.classList.contains('selected')) {
                        // Deselect table
                        this.classList.remove('selected');
                        selectedTables = selectedTables.filter(t => t.table !== table);
                        
                        // Remove columns from this table and uncheck checkboxes
                        const checkboxes = this.querySelectorAll('input[type="checkbox"]');
                        checkboxes.forEach(cb => {
                            if (cb.checked) {
                                selectedColumns = selectedColumns.filter(col => col !== cb.value);
                                cb.checked = false;
                            }
                            cb.disabled = true;
                        });
                    } else {
                        // Select table
                        this.classList.add('selected');
                        selectedTables.push({ table, alias });
                        
                        // Enable checkboxes
                        const checkboxes = this.querySelectorAll('input[type="checkbox"]');
                        checkboxes.forEach(cb => {
                            cb.disabled = false;
                        });
                    }
                    
                    updateUI();
                });

                // Handle checkbox clicks within cards
                const checkboxes = card.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('click', function(e) {
                        e.stopPropagation(); // Prevent card click when clicking checkbox
                    });
                });

                // Make label text clickable without toggling the whole card
                const labels = card.querySelectorAll('.column-checkboxes label');
                labels.forEach(label => {
                    label.addEventListener('click', function(e) {
                        // Prevent the card-level click handler from firing
                        e.stopPropagation();
                        // Prevent default label behavior to control toggling explicitly
                        e.preventDefault();

                        const cb = this.querySelector('input[type="checkbox"]');
                        if (!cb) return;
                        if (cb.disabled) return; // don't toggle if disabled

                        // Toggle checkbox and trigger the change event so UI updates
                        cb.checked = !cb.checked;
                        cb.dispatchEvent(new Event('change', { bubbles: true }));
                    });
                });
            });

            // Reset button handler
            resetBtn.addEventListener('click', function() {
                selectedTables = [];
                selectedColumns = [];
                
                tableCards.forEach(card => {
                    card.classList.remove('selected');
                    const checkboxes = card.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(cb => {
                        cb.disabled = true;
                        cb.checked = false;
                    });
                });
                
                document.getElementById('whereClause').value = '';
                orderBySelect.value = '';
                resultsSection.style.display = 'none';
                
                updateUI();
            });

            // Copy query button handler
            copyQueryBtn.addEventListener('click', function() {
                const queryText = queryPreview.textContent;
                navigator.clipboard.writeText(queryText).then(() => {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 2000);
                });
            });

            // Search functionality
            resultsSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                if (searchTerm === '') {
                    filteredResults = [...allResults];
                } else {
                    filteredResults = allResults.filter(row => {
                        return Object.values(row).some(value => 
                            String(value).toLowerCase().includes(searchTerm)
                        );
                    });
                }
                currentPage = 1;
                displayResults();
            });

            // Pagination handlers
            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    displayResults();
                }
            });

            document.getElementById('nextPage').addEventListener('click', () => {
                const totalPages = Math.ceil(filteredResults.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    displayResults();
                }
            });

            document.getElementById('rowsPerPage').addEventListener('change', function() {
                rowsPerPage = parseInt(this.value);
                currentPage = 1;
                displayResults();
            });

            function updateUI() {
                // Update counters
                document.getElementById('selectedTablesCount').textContent = selectedTables.length;
                document.getElementById('selectedColumnsCount').textContent = selectedColumns.length;
                document.getElementById('queryTableCount').textContent = selectedTables.length;
                document.getElementById('queryColumnCount').textContent = selectedColumns.length;

                // Update execute button
                executeBtn.disabled = selectedTables.length === 0 || selectedColumns.length === 0;

                // Update WHERE columns help with ALL available columns from selected tables
                if (selectedTables.length > 0) {
                    const allColumnsInfo = [];
                    
                    selectedTables.forEach(t => {
                        const card = document.querySelector(`[data-table="${t.table}"]`);
                        const checkboxes = card.querySelectorAll('input[type="checkbox"]');
                        const columns = Array.from(checkboxes).map(cb => cb.value);
                        
                        // Get column names without alias prefix for display
                        const columnNames = columns.map(col => col.split('.')[1]);
                        allColumnsInfo.push(`<strong>${t.alias}:</strong> ${columnNames.join(', ')}`);
                    });
                    
                    whereColumnsHelp.innerHTML = `<div class="columns-info">${allColumnsInfo.join('<br>')}</div>`;
                } else {
                    whereColumnsHelp.innerHTML = '<em>Select tables to see all available columns for WHERE conditions</em>';
                }

                // Update ORDER BY dropdown with all columns from selected tables (not just the checked ones)
                orderBySelect.innerHTML = '<option value="">Select column to sort by</option>';
                const seen = new Set();
                if (selectedTables.length > 0) {
                    selectedTables.forEach(t => {
                        const card = document.querySelector(`[data-table="${t.table}"]`);
                        if (!card) return;
                        const checkboxes = card.querySelectorAll('input[type="checkbox"]');
                        Array.from(checkboxes).forEach(cb => {
                            const val = cb.value; // e.g. U.column_name
                            if (!val || seen.has(val)) return;
                            seen.add(val);
                            const colName = val.split('.')[1] || val;
                            const option = document.createElement('option');
                            option.value = val;
                            option.textContent = `${val}`;
                            orderBySelect.appendChild(option);
                        });
                    });
                }

                // Update query preview
                updateQueryPreview();

                // Update hidden inputs
                document.getElementById('selectedTablesInput').value = JSON.stringify(selectedTables.map(t => t.table));
                document.getElementById('selectedColumnsInput').value = JSON.stringify(selectedColumns);
            }

            function updateQueryPreview() {
                if (selectedTables.length === 0 || selectedColumns.length === 0) {
                    queryPreview.textContent = 'SELECT columns FROM tables WHERE conditions ORDER BY column;';
                    return;
                }

                let query = `SELECT ${selectedColumns.join(', ')}\nFROM ${selectedTables[0].table} ${selectedTables[0].alias}`;
                
                for (let i = 1; i < selectedTables.length; i++) {
                    query += `\nLEFT JOIN ${selectedTables[i].table} ${selectedTables[i].alias} ON /* relationship */`;
                }

                const whereClause = document.getElementById('whereClause').value.trim();
                if (whereClause) {
                    query += `\nWHERE ${whereClause}`;
                }

                if (orderBySelect.value) {
                    const direction = document.querySelector('[name="order_direction"]').value;
                    query += `\nORDER BY ${orderBySelect.value} ${direction}`;
                }

                queryPreview.textContent = query;
            }

            // Export functionality
            document.getElementById('exportBtn').addEventListener('click', function() {
                if (filteredResults.length === 0) {
                    alert('No data to export');
                    return;
                }

                // Convert to CSV
                const headers = Object.keys(filteredResults[0]);
                const csvContent = [
                    headers.join(','),
                    ...filteredResults.map(row => 
                        headers.map(header => 
                            '"' + String(row[header] || '').replace(/"/g, '""') + '"'
                        ).join(',')
                    )
                ].join('\n');

                // Download CSV
                const blob = new Blob([csvContent], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'query_results.csv';
                a.click();
                window.URL.revokeObjectURL(url);
            });

            function displayResults() {
                if (filteredResults.length === 0) {
                    // Show empty state
                    const tbody = document.getElementById('resultsBody');
                    tbody.innerHTML = '<tr><td colspan="100%" class="text-center py-4 text-muted"><i class="fas fa-inbox"></i><br>No results found</td></tr>';
                    
                    // Update counters
                    document.getElementById('resultsCount').textContent = '0';
                    document.getElementById('totalResults').textContent = '0';
                    document.getElementById('showingStart').textContent = '0';
                    document.getElementById('showingEnd').textContent = '0';
                    document.getElementById('currentPage').textContent = '1';
                    document.getElementById('totalPages').textContent = '1';
                    
                    // Disable pagination
                    document.getElementById('prevPage').disabled = true;
                    document.getElementById('nextPage').disabled = true;
                    
                    return;
                }

                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex = Math.min(startIndex + rowsPerPage, filteredResults.length);
                const pageResults = filteredResults.slice(startIndex, endIndex);

                // Update table
                const thead = document.getElementById('resultsHead');
                const tbody = document.getElementById('resultsBody');

                // Clear existing content
                thead.innerHTML = '';
                tbody.innerHTML = '';

                // Create header
                const headerRow = document.createElement('tr');
                Object.keys(filteredResults[0]).forEach(key => {
                    const th = document.createElement('th');
                    th.textContent = key;
                    th.style.cursor = 'pointer';
                    th.title = 'Click to sort';
                    
                    // Add sort functionality
                    th.addEventListener('click', () => {
                        sortResults(key);
                    });
                    
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);

                // Create rows
                pageResults.forEach((row, index) => {
                    const tr = document.createElement('tr');
                    tr.style.animationDelay = `${index * 50}ms`;
                    tr.classList.add('table-row-animate');
                    
                    Object.values(row).forEach(value => {
                        const td = document.createElement('td');
                        const displayValue = value === null || value === undefined ? '' : String(value);
                        
                        // Truncate long values
                        if (displayValue.length > 100) {
                            td.textContent = displayValue.substring(0, 100) + '...';
                            td.title = displayValue;
                        } else {
                            td.textContent = displayValue;
                        }
                        
                        tr.appendChild(td);
                    });
                    tbody.appendChild(tr);
                });

                // Update pagination info
                const totalPages = Math.ceil(filteredResults.length / rowsPerPage);
                document.getElementById('currentPage').textContent = currentPage;
                document.getElementById('totalPages').textContent = totalPages;
                document.getElementById('showingStart').textContent = startIndex + 1;
                document.getElementById('showingEnd').textContent = endIndex;
                document.getElementById('totalResults').textContent = filteredResults.length;
                document.getElementById('resultsCount').textContent = filteredResults.length;

                // Update pagination buttons
                document.getElementById('prevPage').disabled = currentPage === 1;
                document.getElementById('nextPage').disabled = currentPage === totalPages;
            }

            function sortResults(column) {
                const isNumeric = filteredResults.every(row => 
                    row[column] === null || row[column] === undefined || !isNaN(row[column])
                );

                filteredResults.sort((a, b) => {
                    let aVal = a[column];
                    let bVal = b[column];

                    if (aVal === null || aVal === undefined) aVal = '';
                    if (bVal === null || bVal === undefined) bVal = '';

                    if (isNumeric) {
                        return parseFloat(aVal) - parseFloat(bVal);
                    } else {
                        return String(aVal).localeCompare(String(bVal));
                    }
                });

                currentPage = 1;
                displayResults();
            }

            // Handle form submission
            document.getElementById('queryForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (selectedTables.length === 0 || selectedColumns.length === 0) {
                    alert('Please select at least one table and one column');
                    return;
                }
                
                // Show loading state
                executeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Executing...';
                executeBtn.disabled = true;

                // Prepare form data
                const formData = new FormData();
                formData.append('_token', document.querySelector('[name="_token"]').value);
                formData.append('tables', JSON.stringify(selectedTables.map(t => t.table)));
                formData.append('columns', JSON.stringify(selectedColumns));
                formData.append('where_clause', document.getElementById('whereClause').value);
                formData.append('order_by', orderBySelect.value);
                formData.append('order_direction', document.querySelector('[name="order_direction"]').value);

                // Make AJAX request
                fetch('<?php echo e(route("quest.execute")); ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        allResults = data.results;
                        filteredResults = [...allResults];
                        currentPage = 1;
                        
                        resultsSection.style.display = 'block';
                        displayResults();
                        
                        // Update query preview with actual executed query
                        queryPreview.textContent = data.query;
                        
                        // Scroll to results
                        resultsSection.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        alert('Query Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while executing the query');
                })
                .finally(() => {
                    executeBtn.innerHTML = '<i class="fas fa-play"></i> Execute Query';
                    executeBtn.disabled = selectedTables.length === 0 || selectedColumns.length === 0;
                });
            });

            // Update WHERE clause preview on input
            document.getElementById('whereClause').addEventListener('input', updateQueryPreview);
            orderBySelect.addEventListener('change', updateQueryPreview);
            document.querySelector('[name="order_direction"]').addEventListener('change', updateQueryPreview);
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/navigation/quest.blade.php ENDPATH**/ ?>
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
     <?php $__env->slot('title', null, []); ?> Tags - CodeQuest <?php $__env->endSlot(); ?>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-tags" style="color: var(--primary);"></i> Tags
            </h1>
            <p class="lead">Browse problems by tags and categories</p>
        </div>
    </div>

    <!-- Tag Sorting Controls -->
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" class="d-flex align-items-center justify-content-between flex-wrap gap-2" id="tagSortForm">
                <input type="hidden" name="tags_per_page" value="<?php echo e(request('tags_per_page', 50)); ?>">
                <input type="hidden" name="per_page" value="<?php echo e(request('per_page', 25)); ?>">
                <?php $__currentLoopData = request('tags', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="tags[]" value="<?php echo e($tag); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="mode" value="<?php echo e(request('mode', 'single')); ?>">
                <input type="hidden" name="logic" value="<?php echo e(request('logic', 'OR')); ?>">
                <input type="hidden" name="show_tags" value="<?php echo e(request('show_tags', 'yes')); ?>">
                
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 text-muted fw-bold">Sort tags by:</label>
                    <select name="sort" class="form-select form-select-sm" style="width: 160px;" onchange="document.getElementById('tagSortForm').submit();">
                        <option value="name" <?php echo e(($sort ?? 'name') === 'name' ? 'selected' : ''); ?>>Name</option>
                        <option value="problems" <?php echo e(($sort ?? '') === 'problems' ? 'selected' : ''); ?>>Problem Count</option>
                    </select>

                    <select name="direction" class="form-select form-select-sm" style="width: 130px;" onchange="document.getElementById('tagSortForm').submit();">
                        <option value="asc" <?php echo e(($direction ?? 'asc') === 'asc' ? 'selected' : ''); ?>>Ascending</option>
                        <option value="desc" <?php echo e(($direction ?? 'asc') === 'desc' ? 'selected' : ''); ?>>Descending</option>
                    </select>
                </div>
                
                <div>
                    <small class="text-muted"><?php echo e($tagsPaginator->total()); ?> tags</small>
                </div>
            </form>
        </div>
    </div>

    <!-- Tag Statistics Pie Chart -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Tag Usage Statistics</h5>
        </div>
        <div class="card-body">
            <canvas id="tagPieChart" style="max-height: 400px;"></canvas>
        </div>
    </div>

    <!-- Tag Filter Controls -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Problems by Tags</h5>
        </div>
        <div class="card-body">
            <form id="tagFilterForm" method="GET" action="<?php echo e(route('tag.index')); ?>">
                <!-- Preserve pagination parameters -->
                <input type="hidden" name="tags_per_page" value="<?php echo e(request('tags_per_page', 50)); ?>">
                <input type="hidden" name="per_page" value="<?php echo e(request('per_page', 25)); ?>">
                
                <!-- Filter Options -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Selection Mode:</strong></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="mode" id="mode_single" value="single" <?php echo e($filterMode === 'single' ? 'checked' : ''); ?>>
                            <label class="btn btn-outline-primary" for="mode_single">Single Select</label>
                            
                            <input type="radio" class="btn-check" name="mode" id="mode_multiple" value="multiple" <?php echo e($filterMode === 'multiple' ? 'checked' : ''); ?>>
                            <label class="btn btn-outline-primary" for="mode_multiple">Multiple Select</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Filter Logic:</strong></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="logic" id="logic_or" value="OR" <?php echo e($filterLogic === 'OR' ? 'checked' : ''); ?>>
                            <label class="btn btn-outline-success" for="logic_or">OR (Any Tag)</label>
                            
                            <input type="radio" class="btn-check" name="logic" id="logic_and" value="AND" <?php echo e($filterLogic === 'AND' ? 'checked' : ''); ?>>
                            <label class="btn btn-outline-success" for="logic_and">AND (All Tags)</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Show Tags:</strong></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="show_tags" id="show_yes" value="yes" <?php echo e($showTags === 'yes' ? 'checked' : ''); ?>>
                            <label class="btn btn-outline-info" for="show_yes">Yes</label>
                            
                            <input type="radio" class="btn-check" name="show_tags" id="show_no" value="no" <?php echo e($showTags === 'no' ? 'checked' : ''); ?>>
                            <label class="btn btn-outline-info" for="show_no">No</label>
                        </div>
                    </div>
                </div>

                <!-- Tags Selection -->
                <div class="mb-3">
                    <label class="form-label"><strong>Select Tags:</strong></label>
                    <div class="tag-selection-container" style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check" style="margin: 0;">
                                <input 
                                    class="form-check-input tag-checkbox" 
                                    type="checkbox" 
                                    name="tags[]" 
                                    value="<?php echo e($tag->tag_id); ?>" 
                                    id="tag_<?php echo e($tag->tag_id); ?>"
                                    <?php echo e(in_array($tag->tag_id, $selectedTags) ? 'checked' : ''); ?>

                                >
                                <label class="form-check-label tag-label" for="tag_<?php echo e($tag->tag_id); ?>" style="cursor: pointer;">
                                    <span class="badge rounded-pill" style="background-color: #e9ecef; color: #495057; padding: 6px 12px; font-size: 0.875rem;">
                                        <?php echo e($tag->tag_name); ?>

                                        <span class="badge bg-primary ms-1"><?php echo e($tag->problems_count); ?></span>
                                    </span>
                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <!-- Tags Pagination -->
                    <?php if($tagsPaginator->hasPages()): ?>
                        <div class="mt-3">
                            <?php echo e($tagsPaginator->appends(request()->query())->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                    <a href="<?php echo e(route('tag.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Filtered Problems List -->
    <!-- Per-page selector for problems (pagination only, no search) -->
    <div class="d-flex justify-content-end mb-2">
        <form method="GET" action="<?php echo e(route('tag.index')); ?>" class="d-flex align-items-center">
            
            <?php $__currentLoopData = request()->except(['per_page', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_array($v)): ?>
                    <?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="<?php echo e($k); ?>[]" value="<?php echo e($item); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <input type="hidden" name="<?php echo e($k); ?>" value="<?php echo e($v); ?>">
                <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    <div class="container-fluid px-4">
    <div class="card shadow-sm" style="width: 100%;">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-code"></i> Problems 
                <?php if(!empty($selectedTags)): ?>
                    <span class="badge bg-primary"><?php echo e($problems->total()); ?> filtered</span>
                <?php else: ?>
                    <span class="badge bg-secondary">All Problems</span>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body p-0" style="overflow-x: auto;">
            <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => ['headers' => $showTags === 'yes' ? ['⭐', 'Title', 'Rating', 'Tags', 'Solved', 'Stars', 'Status & Link'] : ['⭐', 'Title', 'Rating', 'Solved', 'Stars', 'Status & Link'],'paginator' => $problems,'style' => 'width: 100%;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showTags === 'yes' ? ['⭐', 'Title', 'Rating', 'Tags', 'Solved', 'Stars', 'Status & Link'] : ['⭐', 'Title', 'Rating', 'Solved', 'Stars', 'Status & Link']),'paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($problems),'style' => 'width: 100%;']); ?>
                <?php $__empty_1 = true; $__currentLoopData = $problems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $problem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $rating = (int) ($problem->rating ?? 0);
                        $ratingColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                        $userProblem = null;
                        if (auth()->check()) {
                            $userProblemData = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [auth()->id(), $problem->problem_id]);
                            if (!empty($userProblemData)) $userProblem = $userProblemData[0];
                        }
                        $isStarred = $userProblem && ($userProblem->is_starred ?? false);
                        $currentStatus = $userProblem ? ($userProblem->status ?? 'unsolved') : 'unsolved';
                    ?>
                    <tr>
                        <td onclick="event.stopPropagation();" class="text-center" style="width: 60px;">
                            <?php if(auth()->guard()->check()): ?>
                                <form action="<?php echo e(route('problem.toggleStar', $problem)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="user_id" value="<?php echo e(auth()->id()); ?>">
                                    <button type="submit" class="btn btn-sm p-0 border-0" style="background: transparent; font-size: 1.3rem;">
                                        <?php if($isStarred): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-muted"></i>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <i class="far fa-star text-muted" style="font-size: 1.3rem;"></i>
                            <?php endif; ?>
                        </td>

                        <td onclick="window.location='<?php echo e(route('problem.show', $problem)); ?>'">
                            <a href="<?php echo e(route('problem.show', $problem)); ?>" style="text-decoration: none; color: var(--primary); font-weight: 600;">
                                <?php echo e($problem->title); ?>

                            </a>
                        </td>

                        <td onclick="window.location='<?php echo e(route('problem.show', $problem)); ?>'">
                            <span class="badge" style="background: <?php echo e($ratingColor); ?>; color: white;"><?php echo e($rating); ?></span>
                        </td>

                        <?php if($showTags === 'yes'): ?>
                            <td onclick="window.location='<?php echo e(route('problem.show', $problem)); ?>'">
                                <?php if($problem->tags->count() > 0): ?>
                                    <?php $__currentLoopData = $problem->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (isset($component)) { $__componentOriginaleae488dfb878dfbf5a420f5181e18d4b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleae488dfb878dfbf5a420f5181e18d4b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tag-badge','data' => ['tagName' => $tag->tag_name,'tagId' => $tag->tag_id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tag-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tagName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tag->tag_name),'tagId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tag->tag_id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleae488dfb878dfbf5a420f5181e18d4b)): ?>
<?php $attributes = $__attributesOriginaleae488dfb878dfbf5a420f5181e18d4b; ?>
<?php unset($__attributesOriginaleae488dfb878dfbf5a420f5181e18d4b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleae488dfb878dfbf5a420f5181e18d4b)): ?>
<?php $component = $__componentOriginaleae488dfb878dfbf5a420f5181e18d4b; ?>
<?php unset($__componentOriginaleae488dfb878dfbf5a420f5181e18d4b); ?>
<?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <span class="text-muted">No tags</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>

                        <td onclick="window.location='<?php echo e(route('problem.show', $problem)); ?>'"><?php echo e(number_format($problem->solved_count ?? 0)); ?></td>
                        <td onclick="window.location='<?php echo e(route('problem.show', $problem)); ?>'"><?php echo e(number_format($problem->stars ?? 0)); ?></td>

                        <td onclick="event.stopPropagation();" style="white-space: nowrap;">
                            <?php
                                $statusClass = 'secondary';
                                if ($currentStatus === 'solved') $statusClass = 'success';
                                elseif ($currentStatus === 'attempting' || $currentStatus === 'trying') $statusClass = 'warning';
                                $selectClass = 'bg-' . $statusClass . ' text-white';
                            ?>
                            <?php if(auth()->guard()->check()): ?>
                                <div class="d-flex align-items-center gap-1 flex-nowrap">
                                    <form action="<?php echo e(route('problem.updateStatus', $problem)); ?>" method="POST" style="display:inline; margin:0;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="user_id" value="<?php echo e(auth()->id()); ?>">
                                        <select name="status" class="form-select form-select-sm <?php echo e($selectClass); ?>" onchange="this.form.submit();" style="font-size: 0.75rem; padding: 0.18rem 0.4rem; width: 90px; display:inline-block;">
                                            <option value="unsolved" <?php echo e($currentStatus === 'unsolved' ? 'selected' : ''); ?>>Unsolved</option>
                                            <option value="attempting" <?php echo e($currentStatus === 'attempting' || $currentStatus === 'trying' ? 'selected' : ''); ?>>Trying</option>
                                            <option value="solved" <?php echo e($currentStatus === 'solved' ? 'selected' : ''); ?>>Solved</option>
                                        </select>
                                    </form>
                                    <a href="<?php echo e($problem->problem_link); ?>" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo e($problem->problem_link); ?>" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-external-link-alt"></i> Solve
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="<?php echo e($showTags === 'yes' ? '7' : '6'); ?>" class="text-center p-4">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-light); margin-right: 10px;"></i>
                            <p class="text-muted mb-0">No problems found with selected filters</p>
                        </td>
                    </tr>
                <?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
        </div>
    </div>
    </div>
    <div class="container mt-4">

    <!-- Chart.js for Pie Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Tag statistics data
        const tagStats = <?php echo json_encode($tagStats, 15, 512) ?>;
        
        // Prepare data for pie chart
        const labels = tagStats.map(tag => tag.tag_name);
        const data = tagStats.map(tag => tag.problem_count);
        
        // Chart colors are generated server-side to match tag badge palette and rank pattern
        const backgroundColors = <?php echo json_encode($chartColors, 15, 512) ?>;

        // Create pie chart
        const ctx = document.getElementById('tagPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' problems';
                            }
                        }
                    }
                }
            }
        });

        // Handle single/multiple selection mode
        const modeInputs = document.querySelectorAll('input[name="mode"]');
        const tagCheckboxes = document.querySelectorAll('.tag-checkbox');

        modeInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value === 'single') {
                    // In single mode, uncheck all but keep the last checked
                    let lastChecked = null;
                    tagCheckboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            if (lastChecked) lastChecked.checked = false;
                            lastChecked = checkbox;
                        }
                    });
                }
            });
        });

        // Enforce single selection when in single mode
        tagCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const mode = document.querySelector('input[name="mode"]:checked').value;
                if (mode === 'single' && this.checked) {
                    tagCheckboxes.forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                }
            });
        });
    </script>

    <style>
        .tag-label:hover {
            opacity: 0.8;
        }
        
        .form-check-input:checked + .tag-label .tag-badge {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
            transform: scale(1.05);
            transition: all 0.2s;
        }

        .tag-selection-container .form-check {
            display: inline-block;
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/tag/index.blade.php ENDPATH**/ ?>
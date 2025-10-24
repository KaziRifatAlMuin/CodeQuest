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
     <?php $__env->slot('title', null, []); ?> Statistics - CodeQuest <?php $__env->endSlot(); ?>

    <div class="container py-5">
        <h1 class="mb-4">📊 Platform Statistics</h1>
        <p class="text-muted mb-4">Numbers surfaced from the database views consumed by the statistics controller.</p>

        <?php
            $ratingBadge = function ($rating) {
                if (is_null($rating)) {
                    return 'bg-secondary';
                }
                if ($rating < 1200) {
                    return 'bg-secondary';
                }
                if ($rating < 1400) {
                    return 'bg-success';
                }
                if ($rating < 1700) {
                    return 'bg-info text-dark';
                }
                if ($rating < 2000) {
                    return 'bg-primary';
                }
                if ($rating < 2300) {
                    return 'bg-warning text-dark';
                }
                return 'bg-danger';
            };
        ?>

        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Users</span>
                        <h3 class="mt-2 text-primary"><?php echo e(number_format($platformStats->total_users ?? 0)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Problems</span>
                        <h3 class="mt-2 text-success"><?php echo e(number_format($platformStats->total_problems ?? 0)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Solutions</span>
                        <h3 class="mt-2 text-info"><?php echo e(number_format($platformStats->total_solutions ?? 0)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Editorials</span>
                        <h3 class="mt-2 text-warning"><?php echo e(number_format($platformStats->total_editorials ?? 0)); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white">Difficulty Distribution</div>
                    <div class="card-body">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Difficulty</th>
                                    <th class="text-end">Problems</th>
                                    <th class="text-end">Avg Solved</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $difficultyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><span class="badge bg-primary"><?php echo e($stat->difficulty); ?></span></td>
                                        <td class="text-end"><?php echo e(number_format($stat->count ?? 0)); ?></td>
                                        <td class="text-end"><?php echo e(number_format($stat->avg_solved ?? 0, 1)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No difficulty data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-success text-white">Most Popular Tags</div>
                    <div class="card-body">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tag</th>
                                    <th class="text-end">Problems</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $popularTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($tag->tag_name); ?></td>
                                        <td class="text-end"><span class="badge bg-success"><?php echo e(number_format($tag->problem_count ?? 0)); ?></span></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No tag data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-info text-white">Top Users</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Handle</th>
                                <th class="text-end">Rating</th>
                                <th class="text-end">Solved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $topUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($user->rating_rank ?? '-'); ?></td>
                                    <td><?php echo e($user->name ?? $user->user_name ?? 'Unknown'); ?></td>
                                    <td><?php echo e($user->cf_handle ?? '—'); ?></td>
                                    <?php $userRating = $user->cf_max_rating ?? $user->max_rating ?? null; ?>
                                    <td class="text-end"><span class="badge <?php echo e($ratingBadge($userRating)); ?>"><?php echo e($userRating ?? '—'); ?></span></td>
                                    <td class="text-end"><?php echo e(number_format($user->solved_count ?? $user->solved_problems_count ?? 0)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No user statistics available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white">Top Problems</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Problem</th>
                                <th class="text-end">Rating</th>
                                <th class="text-end">Solved</th>
                                <th class="text-end">Popularity %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $topProblems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $problem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($problem->problem_name ?? $problem->title ?? 'Unknown Problem'); ?></td>
                                    <?php $problemRating = $problem->rating ?? $problem->cf_rating ?? null; ?>
                                    <td class="text-end"><span class="badge <?php echo e($ratingBadge($problemRating)); ?>"><?php echo e($problemRating ?? '—'); ?></span></td>
                                    <td class="text-end"><?php echo e(number_format($problem->solved_count ?? 0)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($problem->popularity ?? 0, 1)); ?>%</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No problem statistics available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/advanced/statistics.blade.php ENDPATH**/ ?>
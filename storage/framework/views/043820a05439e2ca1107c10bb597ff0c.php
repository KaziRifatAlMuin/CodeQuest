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
     <?php $__env->slot('title', null, []); ?> Leaderboard - CodeQuest <?php $__env->endSlot(); ?>

    <div class="container-fluid py-5" style="max-width: 1200px;">
        <!-- Page Header -->
        <div class="mb-5">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-trophy text-warning me-3"></i>Leaderboard
            </h1>
            <p class="text-muted mb-0">Rankings based on Codeforces maximum rating</p>
        </div>

        <!-- Search and Pagination Controls -->
        <?php echo $__env->make('components.search-pagination', ['paginator' => $users], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Sorting Controls for Leaderboard -->
        <div class="card mb-3">
            <div class="card-body p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <form method="GET" id="leaderboardSortForm" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                    <input type="hidden" name="per_page" value="<?php echo e(request('per_page', 50)); ?>">
                    <label class="mb-0 text-muted fw-bold">Sort by:</label>
                    <select name="sort" class="form-select form-select-sm" style="width: 180px;" onchange="document.getElementById('leaderboardSortForm').submit();">
                        <option value="rating" <?php echo e(($sort ?? 'rating') === 'rating' ? 'selected' : ''); ?>>Max CF Rating</option>
                        <option value="solved" <?php echo e(($sort ?? '') === 'solved' ? 'selected' : ''); ?>>Total Solved</option>
                        <option value="avg" <?php echo e(($sort ?? '') === 'avg' ? 'selected' : ''); ?>>Average Problem Rating</option>
                        <option value="name" <?php echo e(($sort ?? '') === 'name' ? 'selected' : ''); ?>>Name</option>
                        <option value="created" <?php echo e(($sort ?? '') === 'created' ? 'selected' : ''); ?>>Registration Date</option>
                    </select>

                    <select name="direction" class="form-select form-select-sm" style="width: 140px;" onchange="document.getElementById('leaderboardSortForm').submit();">
                        <option value="desc" <?php echo e(($direction ?? 'desc') === 'desc' ? 'selected' : ''); ?>>Descending</option>
                        <option value="asc" <?php echo e(($direction ?? 'desc') === 'asc' ? 'selected' : ''); ?>>Ascending</option>
                    </select>
                </form>
                <div>
                    <small class="text-muted">Showing <?php echo e($users->total()); ?> users</small>
                </div>
            </div>
        </div>

        <!-- Leaderboard Table using component -->
        <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => ['headers' => ['Rank', 'Name', 'CF Handle', 'MAX CF Rating', 'Total Solved', 'Avg Rating', 'Follow'],'paginator' => $users]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Rank', 'Name', 'CF Handle', 'MAX CF Rating', 'Total Solved', 'Avg Rating', 'Follow']),'paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($users)]); ?>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $rating = (int) ($user->cf_max_rating ?? 0);
                    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
                    $search = request('search', '');
                    // Use actual_rank if available, otherwise calculate from firstItem
                    $displayRank = $user->actual_rank ?? ($users->firstItem() + $index);
                    
                    // Check if current user follows this user
                    $isFollowing = false;
                    if (auth()->check() && auth()->id() !== $user->user_id) {
                        $friendshipData = \DB::select('SELECT * FROM friends WHERE user_id = ? AND friend_id = ? AND is_friend = 1 LIMIT 1', [auth()->id(), $user->user_id]);
                        $isFollowing = !empty($friendshipData);
                    }
                ?>
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td class="fw-bold text-center" style="color: <?php echo e($themeColor); ?>; font-size: 1rem; width: 8%;">
                        #<?php echo \App\Helpers\SearchHelper::highlight($displayRank, $search); ?>

                    </td>
                    <td style="width: 22%;">
                        <div class="d-flex align-items-center">
                            <?php if($user->profile_picture): ?>
                                <img src="<?php echo e(asset('images/profile/' . $user->profile_picture)); ?>" 
                                     alt="<?php echo e($user->name); ?>" 
                                     class="rounded-circle me-3" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid <?php echo e($themeColor); ?>;">
                            <?php else: ?>
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background: #f0f0f0; border: 2px solid <?php echo e($themeColor); ?>;">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                            <?php endif; ?>
                            <span class="fw-500"><?php echo \App\Helpers\SearchHelper::highlight($user->name, $search); ?></span>
                        </div>
                    </td>
                    <td style="width: 18%;">
                        <span style="color: <?php echo e($themeColor); ?>; font-weight: 600;">
                            <?php if($user->cf_handle): ?>
                                <?php echo \App\Helpers\SearchHelper::highlight($user->cf_handle, $search); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                        <?php if($user->cf_handle && $user->handle_verified_at): ?>
                            <i class="fas fa-check-circle text-success ms-2" style="font-size: 0.85rem;" title="Verified"></i>
                        <?php endif; ?>
                    </td>
                    <td class="text-center" style="width: 14%;">
                        <span class="badge" style="background: <?php echo e($themeColor); ?>; font-size: 0.8rem; padding: 0.5rem 0.8rem;">
                            <?php echo e(number_format($rating)); ?>

                        </span>
                        <br>
                        <small class="text-muted d-block mt-1" style="font-size: 0.8rem;"><?php echo e($themeName); ?></small>
                    </td>
                    <td class="text-center" style="width: 13%;">
                        <span style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">
                            <?php echo e($user->solved_problems_count ?? 0); ?>

                        </span>
                    </td>
                    <td class="text-center" style="width: 13%;">
                        <span style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">
                            <?php echo e(number_format($user->average_problem_rating ?? 0, 0)); ?>

                        </span>
                    </td>
                    
                    <!-- Follow/Unfollow Button -->
                    <td onclick="event.stopPropagation();" class="text-center" style="width: 12%;">
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->id() === $user->user_id): ?>
                                <span class="badge bg-secondary">You</span>
                            <?php else: ?>
                                <form action="<?php echo e(route('friend.' . ($isFollowing ? 'unfollow' : 'follow'), $user)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php if($isFollowing): ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 2.5rem; display: block; margin-bottom: 1rem;"></i>
                        <p class="text-muted mb-0">No users found<?php echo e(request('search') ? ' for "' . request('search') . '"' : ''); ?></p>
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

    <style>
        /* Modern minimalistic styling override */
        .table {
            font-size: 0.95rem;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }

        .table thead th {
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
            border: none;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .fw-500 {
            font-weight: 500;
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
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/user/leaderboard.blade.php ENDPATH**/ ?>
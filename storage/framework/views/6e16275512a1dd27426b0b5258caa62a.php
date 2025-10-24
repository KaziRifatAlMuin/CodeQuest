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
     <?php $__env->slot('title', null, []); ?> Home - CodeQuest <?php $__env->endSlot(); ?>

    <div class="card mb-3" style="background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%); border: none;">
        <div class="card-body text-center py-3 py-md-4">
            <h1 class="mb-2" style="font-weight: 700; font-size: 1.8rem;">
                <i class="fas fa-code" style="color: var(--primary);"></i> CodeQuest
            </h1>
            <p class="mb-2" style="font-size: 0.95rem;">Master coding through intelligent practice and community-driven learning</p>
            <hr class="my-3" style="border-color: var(--border); max-width: 600px; margin: 1rem auto;">
            
            <!-- Search Box -->
            <form method="GET" action="<?php echo e(route('home')); ?>" class="mb-3">
                <div class="input-group mx-auto" style="max-width: 500px;">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search popular problems...">
                    <?php if(request('search')): ?>
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            
            <p class="mb-3" style="font-size: 0.9rem;">Start your journey today and level up your programming skills.</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                <a class="btn btn-primary mr-sm-2 cta-btn" href="<?php echo e(route('account.register')); ?>" role="button">
                    <i class="fas fa-play"></i> Get Started
                </a>
                <a class="btn btn-success cta-btn" href="<?php echo e(route('leaderboard')); ?>" role="button">
                    <i class="fas fa-trophy"></i> View Leaderboard
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.1rem;">🎯 Smart Recommendations</h3>
                    <p class="card-text" style="font-size: 0.85rem;">Get personalized problem recommendations based on your skill level and interests.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.1rem;">📊 Track Progress</h3>
                    <p class="card-text" style="font-size: 0.85rem;">Monitor your improvement with detailed statistics and achievement tracking.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.1rem;">🏆 Compete & Learn</h3>
                    <p class="card-text" style="font-size: 0.85rem;">Join our community, share solutions, and climb the leaderboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top sections: Problems, Rated Users, Solvers -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3" style="font-size: 1.4rem;">Top Community Picks</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body py-3">
                    <h5 class="card-title" style="font-size: 1rem;"><i class="fas fa-fire text-danger"></i> Most Popular Problems</h5>
                    <p class="text-muted small mb-2">Top 10 problems by community popularity<?php echo e(request('search') ? ' matching "' . request('search') . '"' : ''); ?>.</p>
                    <ul class="list-group list-group-flush mt-2">
                        <?php $__empty_1 = true; $__currentLoopData = $topProblems ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $problem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $search = request('search', '');
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start py-2 px-2">
                            <div class="ms-1 me-auto" style="min-width: 0;">
                                <div class="fw-bold text-truncate" style="font-size: 0.85rem;">
                                    <?php echo \App\Helpers\SearchHelper::highlight($problem->title, $search); ?>

                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;">Solved: <?php echo e($problem->solved_count ?? 0); ?> • Pop: <?php echo e($problem->popularity_percentage); ?>%</small>
                            </div>
                            <?php if($problem->problem_link): ?>
                            <a href="<?php echo e($problem->problem_link); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;">Open</a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item py-2">No problems found<?php echo e(request('search') ? ' for "' . request('search') . '"' : ''); ?>.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body py-3">
                    <h5 class="card-title" style="font-size: 1rem;"><i class="fas fa-star text-warning"></i> Top Rated Users</h5>
                    <p class="text-muted small mb-2">Most highly rated problem solvers.</p>
                    <ul class="list-group list-group-flush mt-2">
                        <?php $__empty_1 = true; $__currentLoopData = $topRatedUsers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start py-2 px-2">
                            <div style="min-width: 0;">
                                <div class="fw-bold text-truncate" style="font-size: 0.85rem;"><?php echo e($user->name); ?></div>
                                <small class="text-muted" style="font-size: 0.75rem;">Rating: <?php echo e($user->cf_max_rating ?? 'N/A'); ?></small>
                            </div>
                            <?php if(!empty($user->cf_handle)): ?>
                            <a href="https://codeforces.com/profile/<?php echo e($user->cf_handle); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;">Profile</a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item py-2">No users to show.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body py-3">
                    <h5 class="card-title" style="font-size: 1rem;"><i class="fas fa-user-check text-success"></i> Top Solvers</h5>
                    <p class="text-muted small mb-2">Users with the most solved problems.</p>
                    <ul class="list-group list-group-flush mt-2">
                        <?php $__empty_1 = true; $__currentLoopData = $topSolvers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start py-2 px-2">
                            <div style="min-width: 0;">
                                <div class="fw-bold text-truncate" style="font-size: 0.85rem;"><?php echo e($user->name); ?></div>
                                <small class="text-muted" style="font-size: 0.75rem;">Solved: <?php echo e($user->solved_problems_count ?? 0); ?></small>
                            </div>
                            <?php if(!empty($user->cf_handle)): ?>
                            <a href="https://codeforces.com/profile/<?php echo e($user->cf_handle); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;">Profile</a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item py-2">No solvers to show.</li>
                        <?php endif; ?>
                    </ul>
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
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/navigation/home.blade.php ENDPATH**/ ?>
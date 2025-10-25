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
     <?php $__env->slot('title', null, []); ?> Activity - CodeQuest <?php $__env->endSlot(); ?>

    <div class="container py-5">
        <h1 class="mb-4">🔔 Recent Activity</h1>
        <p class="text-muted mb-4">Live feed powered by the activity controller. Only valid problems and users are linked.</p>

        <div class="list-group shadow-sm">
            <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="list-group-item d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <?php
                            $userClass = \App\Helpers\RatingHelper::getRatingTextClass((int) ($activity->user_rating ?? 0));
                            $problemClass = \App\Helpers\RatingHelper::getRatingTextClass((int) ($activity->problem_rating ?? 0));
                        ?>

                        <?php if(!empty($activity->user_id)): ?>
                            <a href="<?php echo e(route('user.show', $activity->user_id)); ?>" class="text-decoration-none <?php echo e($userClass); ?>">
                                <?php echo e($activity->user_name ?? 'Anonymous'); ?>

                            </a>
                        <?php else: ?>
                            <span class="<?php echo e($userClass); ?>"><?php echo e($activity->user_name ?? 'Anonymous'); ?></span>
                        <?php endif; ?>

                        <?php
                            // Map activity type to modern rounded-pill badge classes
                            $atype = strtolower($activity->activity_type ?? 'activity');
                            if ($atype === 'solved') {
                                $atypeClass = 'bg-success text-white';
                                $atypeLabel = 'Solved';
                            } elseif ($atype === 'editorial') {
                                $atypeClass = 'bg-primary text-white';
                                $atypeLabel = 'Editorial';
                            } else {
                                $atypeClass = 'bg-secondary text-white';
                                $atypeLabel = ucfirst($atype);
                            }
                        ?>

                        <span class="badge rounded-pill px-3 py-1 <?php echo e($atypeClass); ?>" style="font-size:0.85rem;letter-spacing:0.3px;">
                            <?php echo e($atypeLabel); ?>

                        </span>
                        <?php if(!empty($activity->problem_id)): ?>
                            <a href="<?php echo e(route('problem.show', $activity->problem_id)); ?>" class="text-decoration-none <?php echo e($problemClass); ?>">
                                <?php echo e($activity->problem_title ?? 'Problem'); ?>

                            </a>
                        <?php else: ?>
                            <span class="<?php echo e($problemClass); ?>"><?php echo e($activity->problem_title ?? ''); ?></span>
                        <?php endif; ?>
                    </div>
                    <span class="badge bg-light text-muted"><?php echo e(\Carbon\Carbon::parse($activity->activity_date ?? 'now')->diffForHumans()); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="list-group-item text-center text-muted py-4">No recent activity to display.</div>
            <?php endif; ?>
        </div>

        <div class="mt-4 text-center text-muted small">Data updates every time the controller is invoked.</div>
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
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/advanced/activity.blade.php ENDPATH**/ ?>
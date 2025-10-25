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
     <?php $__env->slot('title', null, []); ?> Tag Masters - CodeQuest <?php $__env->endSlot(); ?>

    <div class="container py-5">
        <h1 class="mb-4">🏷️ Tag Masters</h1>
        <p class="text-muted mb-4">Progress data powered by the tag master controller. Values refresh whenever the underlying SQL view is recalculated.</p>

        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $tagMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $problemTotal = max((int) ($tag->problem_count ?? 0), 1);
                    $solvedCount = (int) ($tag->solved_count ?? 0);
                    $progress = min(100, round(($solvedCount / $problemTotal) * 100));
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-1"><?php echo e($tag->tag_name); ?></h5>
                                <span class="badge bg-primary"><?php echo e($progress); ?>%</span>
                            </div>
                            <p class="text-muted small mb-3"><?php echo e(number_format($solvedCount)); ?> solved of <?php echo e(number_format($tag->problem_count ?? 0)); ?> problems.</p>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo e($progress); ?>%;" aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="mt-auto text-muted small d-flex justify-content-between">
                                <span>Remaining: <?php echo e(number_format(max(($tag->problem_count ?? 0) - $solvedCount, 0))); ?></span>
                                <span>Completed: <?php echo e(number_format($solvedCount)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="alert alert-light border">No tag mastery data available.</div>
                </div>
            <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/advanced/tag-masters.blade.php ENDPATH**/ ?>
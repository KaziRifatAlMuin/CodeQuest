
<div class="row mb-3">
    <div class="col-md-8">
        <form method="GET" action="<?php echo e($action ?? request()->url()); ?>" class="d-flex gap-2">
            
            <?php $__currentLoopData = request()->except(['search', 'per_page', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_array($value)): ?>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($val); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <div class="input-group flex-grow-1">
                <span class="input-group-text bg-white">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    class="form-control border-start-0" 
                    placeholder="<?php echo e($placeholder ?? 'Search...'); ?>"
                    value="<?php echo e(request('search')); ?>"
                    style="border-left: none !important;"
                >
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i> Search
                </button>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(request()->url()); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="col-md-4">
        <form method="GET" action="<?php echo e($action ?? request()->url()); ?>" id="perPageForm">
            
            <?php $__currentLoopData = request()->except(['per_page', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_array($value)): ?>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($val); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="fas fa-list text-muted"></i>
                </span>
                <select 
                    name="per_page" 
                    class="form-select border-start-0" 
                    onchange="this.form.submit()"
                    style="border-left: none !important;"
                >
                    <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($option); ?>" <?php echo e(request('per_page', 25) == $option ? 'selected' : ''); ?>>
                            <?php echo e($option); ?> per page
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </form>
    </div>
</div>

<style>
/* Search Highlight Styling */
mark.search-highlight {
    background: linear-gradient(120deg, #ffd700 0%, #ffed4e 100%);
    color: #000;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(255, 215, 0, 0.3);
    animation: highlight-pulse 1.5s ease-in-out;
}

@keyframes highlight-pulse {
    0% {
        background: linear-gradient(120deg, #fff 0%, #fff 100%);
    }
    50% {
        background: linear-gradient(120deg, #ffd700 0%, #ffed4e 100%);
    }
    100% {
        background: linear-gradient(120deg, #ffd700 0%, #ffed4e 100%);
    }
}

/* Modern search input styling */
.input-group .form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    border-color: #86b7fe;
}

.input-group-text {
    border-right: none;
}

.form-control.border-start-0:focus {
    border-left: 1px solid #86b7fe !important;
}

.input-group:focus-within .input-group-text {
    border-color: #86b7fe;
}
</style>
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/components/search-pagination.blade.php ENDPATH**/ ?>
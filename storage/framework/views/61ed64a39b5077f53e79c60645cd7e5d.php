<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['headers' => [], 'paginator' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['headers' => [], 'paginator' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($header); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        </thead>
        <tbody>
            <?php echo e($slot); ?>

        </tbody>
    </table>
</div>

<style>
    .table-hover tbody tr {
        cursor: pointer;
        transition: all 0.3s ease;
        transform-origin: center;
    }
    
    .table-hover tbody tr:hover {
        background-color: #e3f2fd !important;
        transform: scale(1.005);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }
    
    .table-hover tbody tr:active {
        transform: scale(0.995);
    }
</style>

<?php if(!empty($paginator) && method_exists($paginator, 'links')): ?>
    <div class="d-flex justify-content-end align-items-center mt-3">
        <?php echo $paginator->links(); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/components/table.blade.php ENDPATH**/ ?>
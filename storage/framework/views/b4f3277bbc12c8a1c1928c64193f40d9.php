<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tagName', 'tagId' => null]));

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

foreach (array_filter((['tagName', 'tagId' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Palette: 50 light, standard colors grouped so every 10th is visibly different.
    $colors = [
        // 1-10: soft blues/teals
        '#E8F6FF', '#DAF2FF', '#D1F0FF', '#C7EEFF', '#BDEBFF', '#DFF7F0', '#E6FBF5', '#F0FEF9', '#EAF7FF', '#E8F0FF',
        // 11-20: soft purples/pinks
        '#F5E8FF', '#F0E1FF', '#EBD9FF', '#E6D1FF', '#F6EAF9', '#FFF0F6', '#FFEFF8', '#FCEFF5', '#F8E6FF', '#F3DFFF',
        // 21-30: soft yellows/amber
        '#FFF9E6', '#FFF5D1', '#FFF0B8', '#FFF6DF', '#FFF7E6', '#FFFBE6', '#FFF6CC', '#FFF8D9', '#FFF3CC', '#FFF0E0',
        // 31-40: soft greens
        '#E8FFF0', '#DFFFE6', '#D1FFEA', '#CCFFF0', '#E6FFF5', '#E8FFF7', '#F0FFF7', '#EAFEF5', '#E0FFF0', '#D8FFF0',
        // 41-50: soft lavenders/other pastels
        '#F0E8FF', '#EDE8FF', '#F5EAF7', '#EDEFFB', '#F3E8FF', '#F6F0FF', '#EEF0FF', '#F0F2FF', '#F7F0FF', '#F2EAF7',
    ];

    $count = count($colors);

    if ($tagId !== null) {
        $index = abs((int) $tagId) % $count;
    } else {
        // fallback deterministic by tagName
        $index = abs(crc32($tagName)) % $count;
    }

    $backgroundColor = $colors[$index];
    $textColor = '#3a3a3a';
?>

<span class="tag-badge" style="
    display: inline-block;
    padding: 4px 12px;
    margin: 2px 4px;
    border-radius: 12px;
    background-color: <?php echo e($backgroundColor); ?>;
    color: <?php echo e($textColor); ?>;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
">
    <?php echo e($tagName); ?>

</span>
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/components/tag-badge.blade.php ENDPATH**/ ?>
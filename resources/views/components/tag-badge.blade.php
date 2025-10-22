@props(['tagName', 'tagId' => null])

@php
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
@endphp

<span class="tag-badge" style="
    display: inline-block;
    padding: 4px 12px;
    margin: 2px 4px;
    border-radius: 12px;
    background-color: {{ $backgroundColor }};
    color: {{ $textColor }};
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
">
    {{ $tagName }}
</span>

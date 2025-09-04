@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'fullWidthOnMobile' => false,
    'loading' => false,
    'disabled' => false,
    'outline' => false,
    'ghost' => false,
    'link' => false,
    'glass' => false,
    'noAnimation' => false,
    'circle' => false,
    'square' => false,
    'wide' => false,
    'block' => false
])

@php
// Variant mapping for daisyUI
$variantClasses = match($variant) {
    'primary' => 'btn-primary',
    'secondary' => 'btn-secondary',
    'accent' => 'btn-accent',
    'success' => 'btn-success',
    'danger', 'error' => 'btn-error',
    'warning' => 'btn-warning',
    'info' => 'btn-info',
    'neutral' => 'btn-neutral',
    'text' => 'btn-link',
    default => 'btn-primary',
};

// Size mapping for daisyUI
$sizeClasses = match($size) {
    'xs' => 'btn-xs',
    'sm' => 'btn-sm',
    'md' => '', // Default size
    'lg' => 'btn-lg',
    default => '',
};

// Build final classes
$classes = 'btn';

// Add variant
if (!$ghost && !$link && !$outline) {
    $classes .= ' ' . $variantClasses;
}

// Style modifiers
if ($outline) $classes .= ' btn-outline ' . $variantClasses;
if ($ghost) $classes .= ' btn-ghost';
if ($link) $classes .= ' btn-link';
if ($glass) $classes .= ' glass';

// Size modifiers
if ($sizeClasses) $classes .= ' ' . $sizeClasses;
if ($wide) $classes .= ' btn-wide';
if ($block) $classes .= ' btn-block';
if ($circle) $classes .= ' btn-circle';
if ($square) $classes .= ' btn-square';

// Responsive classes
if ($fullWidthOnMobile && !$block) {
    $classes .= ' w-full sm:w-auto';
}

// State modifiers
if ($loading) $classes .= ' loading';
if ($noAnimation) $classes .= ' no-animation';
@endphp

<button 
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if($loading && !$circle && !$square)
        <span class="loading loading-spinner loading-sm"></span>
    @endif
    {{ $slot }}
</button>
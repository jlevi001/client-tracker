@props([
    'type' => 'button',
    'variant' => 'ghost',
    'size' => 'md',
    'shape' => 'circle', // circle or square
    'disabled' => false,
    'tooltip' => null,
    'tooltipPosition' => 'top' // top, bottom, left, right
])

@php
// Size mapping for daisyUI
$sizeClasses = match($size) {
    'xs' => 'btn-xs',
    'sm' => 'btn-sm',
    'md' => '', // Default size
    'lg' => 'btn-lg',
    default => '',
};

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
    'ghost' => 'btn-ghost',
    'outline' => 'btn-outline',
    default => 'btn-ghost',
};

// Shape classes
$shapeClasses = match($shape) {
    'circle' => 'btn-circle',
    'square' => 'btn-square',
    default => 'btn-circle',
};

// Build final classes
$classes = 'btn ' . $variantClasses . ' ' . $shapeClasses;
if ($sizeClasses) $classes .= ' ' . $sizeClasses;

// Tooltip classes
$tooltipClasses = $tooltip ? 'tooltip' : '';
$tooltipPositionClasses = match($tooltipPosition) {
    'top' => 'tooltip-top',
    'bottom' => 'tooltip-bottom',
    'left' => 'tooltip-left',
    'right' => 'tooltip-right',
    default => 'tooltip-top',
};
@endphp

@if($tooltip)
    <div class="{{ $tooltipClasses }} {{ $tooltipPositionClasses }}" data-tip="{{ $tooltip }}">
        <button 
            type="{{ $type }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => $classes]) }}
        >
            {{ $slot }}
        </button>
    </div>
@else
    <button 
        type="{{ $type }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>
@endif
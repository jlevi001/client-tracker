@props([
    'type' => 'submit',
    'size' => 'md',
    'fullWidthOnMobile' => false,
    'loading' => false,
    'disabled' => false
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

// Mobile responsive classes
$responsiveClasses = $fullWidthOnMobile ? 'w-full sm:w-auto' : '';

// Build final classes
$classes = 'btn btn-primary';
if ($sizeClasses) $classes .= ' ' . $sizeClasses;
if ($responsiveClasses) $classes .= ' ' . $responsiveClasses;
if ($loading) $classes .= ' loading';
@endphp

<button 
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if($loading)
        <span class="loading loading-spinner loading-sm"></span>
    @endif
    {{ $slot }}
</button>
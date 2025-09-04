{{-- 
    Unified Button Component using daisyUI
    
    Usage Examples:
    <x-ui-button>Default Primary</x-ui-button>
    <x-ui-button variant="success" size="lg">Large Success</x-ui-button>
    <x-ui-button variant="error" outline>Outline Error</x-ui-button>
    <x-ui-button variant="info" loading>Processing...</x-ui-button>
    <x-ui-button ghost>Ghost Button</x-ui-button>
    <x-ui-button link>Link Button</x-ui-button>
    <x-ui-button variant="warning" fullWidthOnMobile>Mobile Full Width</x-ui-button>
    <x-ui-button circle><svg>...</svg></x-ui-button>
    <x-ui-button variant="primary" wire:click="save" wire:loading.attr="disabled">
        <span wire:loading.remove>Save</span>
        <span wire:loading>Saving...</span>
    </x-ui-button>
--}}

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
    'block' => false,
    'active' => false,
    'join' => false,
    'joinItem' => false,
    'loadingType' => 'spinner', // spinner, dots, ring, ball, bars, infinity
    'icon' => null,
    'iconPosition' => 'left' // left or right
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
    default => '',
};

// Size mapping for daisyUI
$sizeClasses = match($size) {
    'xs' => 'btn-xs',
    'sm' => 'btn-sm',
    'md' => '', // Default size
    'lg' => 'btn-lg',
    default => '',
};

// Loading type mapping
$loadingClasses = match($loadingType) {
    'spinner' => 'loading-spinner',
    'dots' => 'loading-dots',
    'ring' => 'loading-ring',
    'ball' => 'loading-ball',
    'bars' => 'loading-bars',
    'infinity' => 'loading-infinity',
    default => 'loading-spinner',
};

// Build final classes
$classes = 'btn';

// Add variant (only if not ghost, link, or outline without variant)
if (!$ghost && !$link) {
    if ($outline && $variantClasses) {
        $classes .= ' btn-outline ' . $variantClasses;
    } elseif ($variantClasses) {
        $classes .= ' ' . $variantClasses;
    }
}

// Style modifiers
if ($ghost) $classes .= ' btn-ghost';
if ($link) $classes .= ' btn-link';
if ($glass) $classes .= ' glass';

// Size modifiers
if ($sizeClasses) $classes .= ' ' . $sizeClasses;
if ($wide && !$block && !$fullWidthOnMobile) $classes .= ' btn-wide';
if ($block) $classes .= ' btn-block';
if ($circle) $classes .= ' btn-circle';
if ($square) $classes .= ' btn-square';

// Responsive classes
if ($fullWidthOnMobile && !$block) {
    $classes .= ' w-full sm:w-auto';
}

// State modifiers
if ($active) $classes .= ' btn-active';
if ($noAnimation) $classes .= ' no-animation';

// Group modifiers
if ($join) $classes .= ' join';
if ($joinItem) $classes .= ' join-item';

// Determine loading size based on button size
$loadingSize = match($size) {
    'xs' => 'loading-xs',
    'sm' => 'loading-sm',
    'lg' => 'loading-md',
    default => 'loading-sm',
};
@endphp

<button 
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{-- Loading state --}}
    @if($loading && !$circle && !$square)
        <span class="loading {{ $loadingClasses }} {{ $loadingSize }}"></span>
    @endif
    
    {{-- Icon on the left --}}
    @if($icon && $iconPosition === 'left')
        <span class="mr-2">{{ $icon }}</span>
    @endif
    
    {{-- Main content --}}
    {{ $slot }}
    
    {{-- Icon on the right --}}
    @if($icon && $iconPosition === 'right')
        <span class="ml-2">{{ $icon }}</span>
    @endif
</button>
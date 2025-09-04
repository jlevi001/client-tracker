@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'fullWidthOnMobile' => false,
    'disabled' => false,
    'loadingText' => 'Processing...',
    'loadingType' => 'spinner', // spinner, dots, ring, ball, bars, infinity
    'wireClick' => null,
    'wireTarget' => null, // Specific wire:target
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
    'ghost' => 'btn-ghost',
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
$classes = 'btn ' . $variantClasses;
if ($sizeClasses) $classes .= ' ' . $sizeClasses;
if ($fullWidthOnMobile) $classes .= ' w-full sm:w-auto';

// Determine loading size based on button size
$loadingSize = match($size) {
    'xs' => 'loading-xs',
    'sm' => 'loading-sm',
    'lg' => 'loading-md',
    default => 'loading-sm',
};

// Determine wire:target
$target = $wireTarget ?? $wireClick;
@endphp

<button 
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    @if($wireClick)
        wire:click="{{ $wireClick }}"
    @endif
    @if($target)
        wire:loading.attr="disabled"
        wire:target="{{ $target }}"
    @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{-- Default state content --}}
    <span @if($target) wire:loading.remove wire:target="{{ $target }}" @endif>
        {{ $slot }}
    </span>
    
    {{-- Loading state content --}}
    @if($target)
        <span wire:loading wire:target="{{ $target }}" class="inline-flex items-center">
            <span class="loading {{ $loadingClasses }} {{ $loadingSize }} mr-2"></span>
            {{ $loadingText }}
        </span>
    @endif
</button>

{{-- 
Usage Examples:

Basic Livewire button:
<x-loading-button wire:click="save">
    Save Changes
</x-loading-button>

Custom loading text:
<x-loading-button 
    wire:click="process" 
    loadingText="Saving..."
    variant="success"
>
    Save Document
</x-loading-button>

With specific target:
<x-loading-button 
    wire:click="deleteUser({{ $user->id }})" 
    wire:target="deleteUser({{ $user->id }})"
    variant="error"
    loadingText="Deleting..."
>
    Delete User
</x-loading-button>

Different loading types:
<x-loading-button 
    wire:click="generate" 
    loadingType="dots"
    loadingText="Generating..."
>
    Generate Report
</x-loading-button>
--}}
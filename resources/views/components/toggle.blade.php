@props(['disabled' => false, 'size' => 'md'])

@php
    $sizeClasses = [
        'xs' => 'toggle-xs',
        'sm' => 'toggle-sm',
        'md' => '',
        'lg' => 'toggle-lg',
    ];
@endphp

<input 
    type="checkbox" 
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->class([
        'toggle toggle-primary',
        $sizeClasses[$size] ?? '',
    ]) !!}
/>
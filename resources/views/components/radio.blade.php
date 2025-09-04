@props(['disabled' => false, 'error' => false])

<input 
    type="radio" 
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->class([
        'radio radio-primary',
        'radio-error' => $error,
    ]) !!}
/>
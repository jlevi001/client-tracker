@props(['disabled' => false, 'error' => false])

<input 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->class([
        'input input-bordered w-full',
        'input-error' => $error,
    ]) !!}
/>
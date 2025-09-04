@props(['disabled' => false, 'error' => false])

<select 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->class([
        'select select-bordered w-full',
        'select-error' => $error,
    ]) !!}
>
    {{ $slot }}
</select>
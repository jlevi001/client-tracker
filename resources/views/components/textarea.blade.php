@props(['disabled' => false, 'error' => false, 'rows' => 4])

<textarea 
    {{ $disabled ? 'disabled' : '' }}
    rows="{{ $rows }}"
    {!! $attributes->class([
        'textarea textarea-bordered w-full',
        'textarea-error' => $error,
    ]) !!}
>{{ $slot }}</textarea>
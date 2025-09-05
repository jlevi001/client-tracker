@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full btn btn-ghost justify-start text-primary bg-primary/10 border-l-4 border-primary rounded-none'
            : 'block w-full btn btn-ghost justify-start hover:bg-base-200 border-l-4 border-transparent rounded-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
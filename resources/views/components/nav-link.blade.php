@props(['active'])

@php
$classes = ($active ?? false)
            ? 'tab tab-bordered tab-active text-primary'
            : 'tab tab-bordered hover:text-primary';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
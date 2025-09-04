@props([
    'vertical' => false,
    'fullWidthOnMobile' => false,
    'gap' => false, // Add gap between buttons
])

@php
$classes = $vertical ? 'join join-vertical' : 'join';
if ($fullWidthOnMobile) {
    $classes .= ' w-full sm:w-auto';
}
if ($gap) {
    $classes = 'flex';
    if ($vertical) {
        $classes .= ' flex-col';
    }
    $classes .= ' gap-2';
    if ($fullWidthOnMobile) {
        $classes .= ' w-full sm:w-auto';
    }
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>

{{-- 
Usage Examples:

Basic horizontal group:
<x-button-group>
    <button class="btn join-item">One</button>
    <button class="btn join-item btn-active">Two</button>
    <button class="btn join-item">Three</button>
</x-button-group>

Vertical group:
<x-button-group vertical>
    <button class="btn join-item">One</button>
    <button class="btn join-item">Two</button>
    <button class="btn join-item">Three</button>
</x-button-group>

With gap:
<x-button-group gap>
    <x-ui-button>Save</x-ui-button>
    <x-ui-button variant="secondary">Cancel</x-ui-button>
</x-button-group>

Mobile responsive:
<x-button-group fullWidthOnMobile>
    <button class="btn join-item btn-primary flex-1">Accept</button>
    <button class="btn join-item btn-ghost flex-1">Decline</button>
</x-button-group>
--}}
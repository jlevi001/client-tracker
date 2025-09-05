@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'bg-base-200', 'dropdownClasses' => ''])

@php
$alignmentClasses = match ($align) {
    'left' => 'dropdown-start',
    'top' => 'dropdown-top',
    'none', 'false' => '',
    default => 'dropdown-end',
};

$width = match ($width) {
    '48' => 'w-48',
    '60' => 'w-60',
    default => 'w-48',
};
@endphp

<div class="dropdown {{ $alignmentClasses }} {{ $dropdownClasses }}" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <ul x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        tabindex="0" 
        class="dropdown-content z-[1] menu p-2 shadow {{ $contentClasses }} rounded-box {{ $width }}"
        style="display: none;"
        @click="open = false">
        {{ $content }}
    </ul>
</div>
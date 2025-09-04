@props(['id', 'maxWidth'])

@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
    '3xl' => 'max-w-3xl',
    '4xl' => 'max-w-4xl',
    '5xl' => 'max-w-5xl',
    '6xl' => 'max-w-6xl',
    '7xl' => 'max-w-7xl',
    'full' => 'max-w-full',
][$maxWidth ?? '2xl'];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    id="{{ $id }}"
    class="relative z-50"
>
    {{-- Modal with daisyUI classes --}}
    <div 
        class="modal"
        :class="{ 'modal-open': show }"
        x-show="show"
        style="display: none;"
    >
        {{-- Backdrop --}}
        <div 
            class="modal-backdrop bg-base-300 bg-opacity-75"
            x-show="show"
            x-on:click="show = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>
        
        {{-- Modal Box --}}
        <div 
            class="modal-box {{ $maxWidth }} w-11/12 sm:w-full bg-base-200 shadow-xl"
            x-show="show"
            x-trap.inert.noscroll="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            {{ $slot }}
        </div>
    </div>
</div>
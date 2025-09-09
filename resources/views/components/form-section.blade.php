@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <div class="grid grid-cols-6 gap-6">
                        {{ $form }}
                    </div>
                </div>
                
                @if (isset($actions))
                    <div class="card-actions justify-end bg-base-300 px-6 py-3">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
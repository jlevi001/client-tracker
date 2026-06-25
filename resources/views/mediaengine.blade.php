<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            {{ __('Media Engine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:media-engine />
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @can('manage users')
                <livewire:user-management />
            @else
                <div class="card bg-base-200 shadow-xl">
                    <div class="card-body">
                        <p class="text-base-content/70">You do not have permission to manage users.</p>
                    </div>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
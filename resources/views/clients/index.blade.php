<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Client Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div>
                            <h2 class="card-title text-2xl">Clients</h2>
                            <p class="text-base-content/70">Manage your client accounts and information</p>
                        </div>
                        <button class="btn btn-primary w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Client
                        </button>
                    </div>
                    
                    <!-- Placeholder for Livewire component -->
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">Client Management Coming Soon</h3>
                            <div class="text-sm">The ClientManagement Livewire component will be added here. Run the migration first: <code class="bg-base-300 px-2 py-1 rounded">php artisan migrate</code></div>
                        </div>
                    </div>
                    
                    <!-- Preview of what's coming -->
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg mb-4">Features to be implemented:</h3>
                        <ul class="list-disc list-inside space-y-2 text-base-content/80">
                            <li>Client listing with search and pagination</li>
                            <li>Add/Edit client modal forms</li>
                            <li>Account number auto-generation</li>
                            <li>Phone number formatting (+1 AAA BBB CCCC)</li>
                            <li>State abbreviation (US & Canada)</li>
                            <li>Client status management (Active/Inactive/Suspended)</li>
                            <li>Contact information management</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

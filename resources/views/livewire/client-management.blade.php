<div>
    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success mb-4" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-error mb-4" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header with Search and Action Buttons -->
    <div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div class="w-full lg:w-1/3">
            <input wire:model.live.debounce.300ms="search" 
                   type="search" 
                   placeholder="Search by company, account #, or email..." 
                   autocomplete="off"
                   data-lpignore="true"
                   data-1p-ignore
                   data-form-type="other"
                   class="input input-bordered w-full">
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
            <button wire:click="openImportModal" 
                    class="btn btn-ghost btn-outline w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import CSV
            </button>
            <button wire:click="openCreateModal" 
                    class="btn btn-primary w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Client
            </button>
        </div>
    </div>

    <!-- Per Page Selector -->
    <div class="mb-4 flex justify-end">
        <select wire:model.live="perPage" class="select select-bordered select-sm">
            <option value="10">10 per page</option>
            <option value="25">25 per page</option>
            <option value="50">50 per page</option>
        </select>
    </div>

    <!-- Clients Table -->
    <div class="card bg-base-200 shadow-xl">
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th wire:click="sortBy('account_number')" class="cursor-pointer hover:bg-base-300">
                            <div class="flex items-center gap-1">
                                Account #
                                @if($sortField === 'account_number')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('company_name')" class="cursor-pointer hover:bg-base-300">
                            <div class="flex items-center gap-1">
                                Company Name
                                @if($sortField === 'company_name')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th>Contact</th>
                        <th>Rate</th>
                        <th>Status</th>
                        <th wire:click="sortBy('created_at')" class="cursor-pointer hover:bg-base-300">
                            <div class="flex items-center gap-1">
                                Created
                                @if($sortField === 'created_at')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr class="hover">
                            <td>
                                <span class="font-mono text-sm badge badge-ghost">{{ $client->account_number }}</span>
                            </td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $client->company_name }}</span>
                                    @if($client->trading_name && $client->trading_name !== $client->company_name)
                                        <span class="text-sm text-base-content/60">DBA: {{ $client->trading_name }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col text-sm">
                                    @if($client->email)
                                        <span>{{ $client->email }}</span>
                                    @endif
                                    @if($client->phone)
                                        <span class="text-base-content/60">{{ $client->phone }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="font-mono text-sm">${{ number_format($client->default_hourly_rate, 2) }}</span>
                            </td>
                            <td>
                                @if($client->status === 'active')
                                    <span class="badge badge-success badge-sm">Active</span>
                                @elseif($client->status === 'inactive')
                                    <span class="badge badge-ghost badge-sm">Inactive</span>
                                @else
                                    <span class="badge badge-warning badge-sm">Suspended</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-sm text-base-content/60">{{ $client->created_at->format('M d, Y') }}</span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <button wire:click="openEditModal({{ $client->id }})" 
                                            class="btn btn-ghost btn-xs" 
                                            title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $client->id }})" 
                                            class="btn btn-error btn-xs" 
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-base-content/50 py-8">
                                No clients found. Click "Add Client" to create your first client.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $clients->links() }}
    </div>

    <!-- Create Client Modal -->
    <x-dialog-modal wire:model="showCreateModal" maxWidth="4xl">
        <x-slot name="title">
            Add New Client
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <!-- Company Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-base-content border-b border-base-300 pb-2">Company Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Company Name <span class="text-error">*</span></span>
                            </label>
                            <input type="text" 
                                   wire:model.live.debounce.300ms="companyName"
                                   class="input input-bordered w-full @error('companyName') input-error @enderror" />
                            @error('companyName')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            @if($accountNumberPreview)
                                <label class="label">
                                    <span class="label-text-alt text-info">Account #: {{ $accountNumberPreview }}</span>
                                </label>
                            @endif
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Trading Name (DBA)</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="tradingName"
                                   class="input input-bordered w-full @error('tradingName') input-error @enderror" />
                            @error('tradingName')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email" 
                                   wire:model.defer="email"
                                   class="input input-bordered w-full @error('email') input-error @enderror" />
                            @error('email')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Website</span>
                            </label>
                            <input type="url" 
                                   wire:model.defer="website"
                                   placeholder="https://example.com"
                                   class="input input-bordered w-full @error('website') input-error @enderror" />
                            @error('website')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Phone</span>
                            </label>
                            <input type="tel" 
                                   wire:model.defer="phone"
                                   placeholder="+1 555-123-4567"
                                   class="input input-bordered w-full @error('phone') input-error @enderror" />
                            @error('phone')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Mobile</span>
                            </label>
                            <input type="tel" 
                                   wire:model.defer="mobile"
                                   placeholder="+1 555-987-6543"
                                   class="input input-bordered w-full @error('mobile') input-error @enderror" />
                            @error('mobile')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Business Address -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-base-content border-b border-base-300 pb-2">Business Address</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Address Line 1</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="addressLine1"
                                   class="input input-bordered w-full @error('addressLine1') input-error @enderror" />
                            @error('addressLine1')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Address Line 2</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="addressLine2"
                                   class="input input-bordered w-full @error('addressLine2') input-error @enderror" />
                            @error('addressLine2')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">City</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="city"
                                   class="input input-bordered w-full @error('city') input-error @enderror" />
                            @error('city')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">State/Province</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="state"
                                   placeholder="TX"
                                   class="input input-bordered w-full @error('state') input-error @enderror" />
                            @error('state')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">ZIP/Postal Code</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="zipCode"
                                   class="input input-bordered w-full @error('zipCode') input-error @enderror" />
                            @error('zipCode')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Country</span>
                        </label>
                        <input type="text" 
                               wire:model.defer="country"
                               class="input input-bordered w-full @error('country') input-error @enderror" />
                        @error('country')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-base-300 pb-2">
                        <h3 class="text-lg font-semibold text-base-content">Billing Address</h3>
                        <div class="form-control">
                            <label class="label cursor-pointer gap-2">
                                <span class="label-text">Same as business address</span>
                                <input type="checkbox" 
                                       wire:model.live="billingAddressSame"
                                       class="toggle toggle-primary" />
                            </label>
                        </div>
                    </div>

                    @if(!$billingAddressSame)
                        <div class="grid grid-cols-1 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Address Line 1</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingAddressLine1"
                                       class="input input-bordered w-full @error('billingAddressLine1') input-error @enderror" />
                                @error('billingAddressLine1')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Address Line 2</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingAddressLine2"
                                       class="input input-bordered w-full @error('billingAddressLine2') input-error @enderror" />
                                @error('billingAddressLine2')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">City</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingCity"
                                       class="input input-bordered w-full @error('billingCity') input-error @enderror" />
                                @error('billingCity')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">State/Province</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingState"
                                       placeholder="TX"
                                       class="input input-bordered w-full @error('billingState') input-error @enderror" />
                                @error('billingState')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">ZIP/Postal Code</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingZipCode"
                                       class="input input-bordered w-full @error('billingZipCode') input-error @enderror" />
                                @error('billingZipCode')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Country</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="billingCountry"
                                   class="input input-bordered w-full @error('billingCountry') input-error @enderror" />
                            @error('billingCountry')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Business Details -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-base-content border-b border-base-300 pb-2">Business Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Payment Terms <span class="text-error">*</span></span>
                            </label>
                            <select wire:model.defer="paymentTerms"
                                    class="select select-bordered w-full @error('paymentTerms') select-error @enderror">
                                <option value="net15">Net 15</option>
                                <option value="net30">Net 30</option>
                                <option value="net45">Net 45</option>
                                <option value="net60">Net 60</option>
                                <option value="due_on_receipt">Due on Receipt</option>
                            </select>
                            @error('paymentTerms')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Tax ID</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="taxId"
                                   placeholder="12-3456789"
                                   class="input input-bordered w-full @error('taxId') input-error @enderror" />
                            @error('taxId')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Default Hourly Rate <span class="text-error">*</span></span>
                            </label>
                            <label class="input-group">
                                <span>$</span>
                                <input type="number" 
                                       wire:model.defer="defaultHourlyRate"
                                       step="0.01"
                                       min="0"
                                       class="input input-bordered w-full @error('defaultHourlyRate') input-error @enderror" />
                            </label>
                            @error('defaultHourlyRate')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Status <span class="text-error">*</span></span>
                            </label>
                            <select wire:model.defer="status"
                                    class="select select-bordered w-full @error('status') select-error @enderror">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                            @error('status')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Notes</span>
                        </label>
                        <textarea wire:model.defer="notes"
                                  rows="3"
                                  class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror"></textarea>
                        @error('notes')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showCreateModal', false)" wire:loading.attr="disabled">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="createClient" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="createClient">Create Client</span>
                <span wire:loading wire:target="createClient" class="loading loading-spinner loading-sm"></span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Edit Client Modal -->
    <x-dialog-modal wire:model="showEditModal" maxWidth="4xl">
        <x-slot name="title">
            Edit Client
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <!-- Company Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-base-content border-b border-base-300 pb-2">Company Information</h3>
                    
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Account Number: <strong class="font-mono">{{ $accountNumber }}</strong> (cannot be changed)</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Company Name <span class="text-error">*</span></span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="companyName"
                                   class="input input-bordered w-full @error('companyName') input-error @enderror" />
                            @error('companyName')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Trading Name (DBA)</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="tradingName"
                                   class="input input-bordered w-full @error('tradingName') input-error @enderror" />
                            @error('tradingName')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="email" 
                                   wire:model.defer="email"
                                   class="input input-bordered w-full @error('email') input-error @enderror" />
                            @error('email')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Website</span>
                            </label>
                            <input type="url" 
                                   wire:model.defer="website"
                                   placeholder="https://example.com"
                                   class="input input-bordered w-full @error('website') input-error @enderror" />
                            @error('website')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Phone</span>
                            </label>
                            <input type="tel" 
                                   wire:model.defer="phone"
                                   placeholder="+1 555-123-4567"
                                   class="input input-bordered w-full @error('phone') input-error @enderror" />
                            @error('phone')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Mobile</span>
                            </label>
                            <input type="tel" 
                                   wire:model.defer="mobile"
                                   placeholder="+1 555-987-6543"
                                   class="input input-bordered w-full @error('mobile') input-error @enderror" />
                            @error('mobile')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Business Address -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-base-content border-b border-base-300 pb-2">Business Address</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Address Line 1</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="addressLine1"
                                   class="input input-bordered w-full @error('addressLine1') input-error @enderror" />
                            @error('addressLine1')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Address Line 2</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="addressLine2"
                                   class="input input-bordered w-full @error('addressLine2') input-error @enderror" />
                            @error('addressLine2')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">City</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="city"
                                   class="input input-bordered w-full @error('city') input-error @enderror" />
                            @error('city')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">State/Province</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="state"
                                   placeholder="TX"
                                   class="input input-bordered w-full @error('state') input-error @enderror" />
                            @error('state')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">ZIP/Postal Code</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="zipCode"
                                   class="input input-bordered w-full @error('zipCode') input-error @enderror" />
                            @error('zipCode')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Country</span>
                        </label>
                        <input type="text" 
                               wire:model.defer="country"
                               class="input input-bordered w-full @error('country') input-error @enderror" />
                        @error('country')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-base-300 pb-2">
                        <h3 class="text-lg font-semibold text-base-content">Billing Address</h3>
                        <div class="form-control">
                            <label class="label cursor-pointer gap-2">
                                <span class="label-text">Same as business address</span>
                                <input type="checkbox" 
                                       wire:model.live="billingAddressSame"
                                       class="toggle toggle-primary" />
                            </label>
                        </div>
                    </div>

                    @if(!$billingAddressSame)
                        <div class="grid grid-cols-1 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Address Line 1</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingAddressLine1"
                                       class="input input-bordered w-full @error('billingAddressLine1') input-error @enderror" />
                                @error('billingAddressLine1')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Address Line 2</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingAddressLine2"
                                       class="input input-bordered w-full @error('billingAddressLine2') input-error @enderror" />
                                @error('billingAddressLine2')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">City</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingCity"
                                       class="input input-bordered w-full @error('billingCity') input-error @enderror" />
                                @error('billingCity')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">State/Province</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingState"
                                       placeholder="TX"
                                       class="input input-bordered w-full @error('billingState') input-error @enderror" />
                                @error('billingState')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">ZIP/Postal Code</span>
                                </label>
                                <input type="text" 
                                       wire:model.defer="billingZipCode"
                                       class="input input-bordered w-full @error('billingZipCode') input-error @enderror" />
                                @error('billingZipCode')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Country</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="billingCountry"
                                   class="input input-bordered w-full @error('billingCountry') input-error @enderror" />
                            @error('billingCountry')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Business Details -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-base-content border-b border-base-300 pb-2">Business Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Payment Terms <span class="text-error">*</span></span>
                            </label>
                            <select wire:model.defer="paymentTerms"
                                    class="select select-bordered w-full @error('paymentTerms') select-error @enderror">
                                <option value="net15">Net 15</option>
                                <option value="net30">Net 30</option>
                                <option value="net45">Net 45</option>
                                <option value="net60">Net 60</option>
                                <option value="due_on_receipt">Due on Receipt</option>
                            </select>
                            @error('paymentTerms')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Tax ID</span>
                            </label>
                            <input type="text" 
                                   wire:model.defer="taxId"
                                   placeholder="12-3456789"
                                   class="input input-bordered w-full @error('taxId') input-error @enderror" />
                            @error('taxId')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Default Hourly Rate <span class="text-error">*</span></span>
                            </label>
                            <label class="input-group">
                                <span>$</span>
                                <input type="number" 
                                       wire:model.defer="defaultHourlyRate"
                                       step="0.01"
                                       min="0"
                                       class="input input-bordered w-full @error('defaultHourlyRate') input-error @enderror" />
                            </label>
                            @error('defaultHourlyRate')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Status <span class="text-error">*</span></span>
                            </label>
                            <select wire:model.defer="status"
                                    class="select select-bordered w-full @error('status') select-error @enderror">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                            @error('status')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Notes</span>
                        </label>
                        <textarea wire:model.defer="notes"
                                  rows="3"
                                  class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror"></textarea>
                        @error('notes')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="updateClient" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="updateClient">Update Client</span>
                <span wire:loading wire:target="updateClient" class="loading loading-spinner loading-sm"></span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">
            Delete Client
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this client? This action cannot be undone.
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                Cancel
            </button>
            <button class="btn btn-error" wire:click="deleteClient" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="deleteClient">Delete Client</span>
                <span wire:loading wire:target="deleteClient" class="loading loading-spinner loading-sm"></span>
            </button>
        </x-slot>
    </x-confirmation-modal>

    <!-- CSV Import Modal -->
    <x-dialog-modal wire:model="showImportModal" maxWidth="4xl">
        <x-slot name="title">
            Import Clients from CSV
        </x-slot>

        <x-slot name="content">
            @if($isImporting)
                <!-- Import Progress Display -->
                <div class="space-y-6">
                    <div class="text-center">
                        <h3 class="font-bold text-lg mb-4">Importing Clients...</h3>
                        <p class="text-sm text-base-content/70 mb-2">
                            Processing {{ $importProcessed }} of {{ $importTotal }} clients
                        </p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium">Progress</span>
                            <span class="text-sm font-medium">{{ $importProgress }}%</span>
                        </div>
                        <progress class="progress progress-primary w-full" value="{{ $importProgress }}" max="100"></progress>
                    </div>

                    <!-- Import Stats -->
                    <div class="stats stats-horizontal shadow w-full bg-base-300">
                        <div class="stat place-items-center">
                            <div class="stat-title">Created</div>
                            <div class="stat-value text-success text-2xl">{{ $importCreated }}</div>
                        </div>
                        <div class="stat place-items-center">
                            <div class="stat-title">Updated</div>
                            <div class="stat-value text-info text-2xl">{{ $importUpdated }}</div>
                        </div>
                        <div class="stat place-items-center">
                            <div class="stat-title">Remaining</div>
                            <div class="stat-value text-2xl">{{ $importTotal - $importProcessed }}</div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Please do not close this window while importing...</span>
                    </div>
                </div>
            @elseif(!$showImportPreview)
                <!-- File Upload Step -->
                <div class="space-y-4">
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">CSV Import Instructions</h3>
                            <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                                <li>Use the template to ensure correct column names</li>
                                <li><strong>company_name</strong> is required for all rows</li>
                                <li>Leave <strong>account_number</strong> blank for new clients (auto-generated)</li>
                                <li>Include <strong>account_number</strong> to update existing clients</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button wire:click="downloadTemplate" class="btn btn-outline btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Template
                        </button>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Select CSV File</span>
                        </label>
                        <input type="file" 
                               wire:model="csvFile"
                               accept=".csv,.txt"
                               class="file-input file-input-bordered w-full @error('csvFile') file-input-error @enderror" />
                        @error('csvFile')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                        <div wire:loading wire:target="csvFile" class="mt-2">
                            <span class="loading loading-spinner loading-sm"></span>
                            <span class="text-sm">Processing file...</span>
                        </div>
                    </div>
                </div>
            @else
                <!-- Preview Step -->
                <div class="space-y-4">
                    <div class="stats shadow w-full bg-base-300">
                        <div class="stat">
                            <div class="stat-title">New Clients</div>
                            <div class="stat-value text-success">{{ $importNewCount }}</div>
                            <div class="stat-desc">To be created</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Updates</div>
                            <div class="stat-value text-info">{{ $importUpdateCount }}</div>
                            <div class="stat-desc">Existing clients</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Errors</div>
                            <div class="stat-value text-error">{{ $importErrorCount }}</div>
                            <div class="stat-desc">Rows skipped</div>
                        </div>
                    </div>

                    @if(count($importErrors) > 0)
                        <div class="alert alert-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h3 class="font-bold">Errors Found</h3>
                                <ul class="list-disc list-inside text-sm mt-2">
                                    @foreach($importErrors as $error)
                                        <li>Row {{ $error['row'] }}: {{ $error['message'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(count($importData) > 0)
                        <div class="overflow-x-auto max-h-64">
                            <table class="table table-xs table-zebra">
                                <thead>
                                    <tr>
                                        <th>Row</th>
                                        <th>Type</th>
                                        <th>Company Name</th>
                                        <th>Account #</th>
                                        <th>Email</th>
                                        <th>Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($importData as $data)
                                        <tr>
                                            <td>{{ $data['row_number'] }}</td>
                                            <td>
                                                @if($data['is_update'])
                                                    <span class="badge badge-info badge-xs">Update</span>
                                                @else
                                                    <span class="badge badge-success badge-xs">New</span>
                                                @endif
                                            </td>
                                            <td>{{ $data['company_name'] ?? '-' }}</td>
                                            <td class="font-mono">{{ $data['account_number'] ?? 'Auto' }}</td>
                                            <td>{{ $data['email'] ?? '-' }}</td>
                                            <td>${{ number_format($data['default_hourly_rate'] ?? 130, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            @if($isImporting)
                <button class="btn btn-error" wire:click="cancelImport">
                    Cancel Import
                </button>
            @elseif(!$showImportPreview)
                <button class="btn btn-ghost" wire:click="$set('showImportModal', false)" wire:loading.attr="disabled">
                    Cancel
                </button>
            @else
                <button class="btn btn-ghost" wire:click="cancelImport" wire:loading.attr="disabled">
                    Back
                </button>
                @if(count($importData) > 0)
                    <button class="btn btn-primary" wire:click="confirmImport" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="confirmImport">Import {{ count($importData) }} Clients</span>
                        <span wire:loading wire:target="confirmImport" class="loading loading-spinner loading-sm"></span>
                    </button>
                @endif
            @endif
        </x-slot>
    </x-dialog-modal>

    <!-- Livewire Script for Batch Processing -->
    @script
    <script>
        $wire.on('process-next-batch', () => {
            // Small delay to allow UI to update before next batch
            setTimeout(() => {
                $wire.processNextBatch();
            }, 100);
        });
    </script>
    @endscript
</div>
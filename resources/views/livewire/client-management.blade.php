<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-bold text-base-content">Client Management</h2>
            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <button wire:click="downloadTemplate" class="btn btn-ghost btn-sm w-full sm:w-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Template
                </button>
                <button wire:click="openImportModal" class="btn btn-secondary btn-sm w-full sm:w-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Import CSV
                </button>
                <button wire:click="openAddModal" class="btn btn-primary btn-sm w-full sm:w-auto">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Client
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="alert alert-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Search and Filters -->
        <div class="card bg-base-200 shadow-xl mb-6">
            <div class="card-body">
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="form-control flex-1">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by company name, account #, email..." 
                            class="input input-bordered w-full"
                        />
                    </div>
                    <div class="form-control w-full lg:w-48">
                        <select wire:model.live="perPage" class="select select-bordered w-full">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>
                                    <button wire:click="sortBy('account_number')" class="flex items-center gap-1 hover:text-primary">
                                        Account #
                                        @if($sortField === 'account_number')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                            </svg>
                                        @endif
                                    </button>
                                </th>
                                <th>
                                    <button wire:click="sortBy('company_name')" class="flex items-center gap-1 hover:text-primary">
                                        Company Name
                                        @if($sortField === 'company_name')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                            </svg>
                                        @endif
                                    </button>
                                </th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Active Contract</th>
                                <th>
                                    <button wire:click="sortBy('created_at')" class="flex items-center gap-1 hover:text-primary">
                                        Created
                                        @if($sortField === 'created_at')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                            </svg>
                                        @endif
                                    </button>
                                </th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr class="hover">
                                    <td>
                                        <button 
                                            wire:click="openEditModal({{ $client->id }})"
                                            class="link link-primary font-mono text-sm"
                                        >
                                            {{ $client->account_number }}
                                        </button>
                                    </td>
                                    <td class="font-semibold">{{ $client->company_name }}</td>
                                    <td class="text-sm">{{ $client->formatted_contact }}</td>
                                    <td class="text-sm">{{ $client->email ?: '—' }}</td>
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
                                        <span class="badge badge-ghost badge-sm">No</span>
                                    </td>
                                    <td class="text-sm">{{ $client->created_at->format('M d, Y') }}</td>
                                    <td class="text-right">
                                        <div class="flex justify-end gap-2">
                                            <button wire:click="openEditModal({{ $client->id }})" class="btn btn-ghost btn-xs">
                                                Edit
                                            </button>
                                            <button wire:click="openDeleteModal({{ $client->id }})" class="btn btn-error btn-xs">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-base-content/50 py-8">
                                        No clients found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-base-300">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Client Modal -->
    <div class="modal {{ $showAddModal || $showEditModal ? 'modal-open' : '' }}">
        <div class="modal-box max-w-4xl">
            <h3 class="font-bold text-lg mb-4">
                {{ $clientId ? 'Edit Client' : 'Add New Client' }}
            </h3>

            <form wire:submit.prevent="save" class="space-y-4">
                <!-- Account Number Preview (Add only) -->
                @if(!$clientId && $company_name)
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Account # will be: <strong class="font-mono">{{ \App\Models\Client::generateAccountNumber($company_name) }}</strong></span>
                    </div>
                @endif

                <!-- Account Number (Read-only for edit) -->
                @if($clientId)
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Account Number</span>
                        </label>
                        <input type="text" value="{{ $account_number }}" class="input input-bordered" disabled />
                        <label class="label">
                            <span class="label-text-alt">Account numbers cannot be changed</span>
                        </label>
                    </div>
                @endif

                <!-- Company Information -->
                <div class="divider">Company Information</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Company Name <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="company_name" class="input input-bordered @error('company_name') input-error @enderror" />
                        @error('company_name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Trading Name (DBA)</span>
                        </label>
                        <input type="text" wire:model="trading_name" class="input input-bordered" />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Website</span>
                        </label>
                        <input type="url" wire:model="website" class="input input-bordered @error('website') input-error @enderror" placeholder="https://" />
                        @error('website')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" wire:model="email" class="input input-bordered @error('email') input-error @enderror" />
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Office Phone</span>
                        </label>
                        <input type="tel" wire:model="phone" class="input input-bordered" placeholder="+1 214 555 1234" />
                        <label class="label">
                            <span class="label-text-alt">Format: +1 XXX XXX XXXX</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Mobile Phone</span>
                        </label>
                        <input type="tel" wire:model="mobile" class="input input-bordered" placeholder="+1 214 555 1234" />
                        <label class="label">
                            <span class="label-text-alt">Format: +1 XXX XXX XXXX</span>
                        </label>
                    </div>
                </div>

                <!-- Billing Settings -->
                <div class="divider">Billing Settings</div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Default Hourly Rate <span class="text-error">*</span></span>
                        </label>
                        <label class="input-group">
                            <span>$</span>
                            <input type="number" step="0.01" wire:model="default_hourly_rate" class="input input-bordered flex-1 @error('default_hourly_rate') input-error @enderror" />
                        </label>
                        @error('default_hourly_rate')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Payment Terms <span class="text-error">*</span></span>
                        </label>
                        <select wire:model="payment_terms" class="select select-bordered">
                            <option value="net15">Net 15</option>
                            <option value="net30">Net 30</option>
                            <option value="net45">Net 45</option>
                            <option value="net60">Net 60</option>
                            <option value="due_on_receipt">Due on Receipt</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tax ID</span>
                        </label>
                        <input type="text" wire:model="tax_id" class="input input-bordered" placeholder="XX-XXXXXXX" />
                    </div>
                </div>

                <!-- Hosting & Domain Information -->
                <div class="divider">Hosting & Domain Information</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Hosting Provider</span>
                        </label>
                        <select wire:model="hosting_provider" class="select select-bordered">
                            @foreach($hostingProviders as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Hosting Managed By</span>
                        </label>
                        <div class="flex gap-4 mt-2">
                            <label class="label cursor-pointer gap-2">
                                <input type="radio" wire:model="hosting_managed_by" value="lingo" class="radio radio-primary" />
                                <span class="label-text">Lingo</span>
                            </label>
                            <label class="label cursor-pointer gap-2">
                                <input type="radio" wire:model="hosting_managed_by" value="client" class="radio radio-primary" />
                                <span class="label-text">Client</span>
                            </label>
                            <label class="label cursor-pointer gap-2">
                                <input type="radio" wire:model="hosting_managed_by" value="" class="radio radio-primary" />
                                <span class="label-text">Not Set</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Domain Registrar</span>
                        </label>
                        <select wire:model="domain_registrar" class="select select-bordered">
                            @foreach($domainRegistrars as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($domain_registrar === 'other')
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Other Registrar Name</span>
                            </label>
                            <input type="text" wire:model="domain_registrar_other" class="input input-bordered" placeholder="Enter registrar name" />
                        </div>
                    @endif

                    <div class="form-control md:col-span-2">
                        <label class="label cursor-pointer justify-start gap-2">
                            <input type="checkbox" wire:model.live="dns_managed_elsewhere" class="checkbox checkbox-primary" />
                            <span class="label-text">DNS Managed Elsewhere</span>
                        </label>
                    </div>

                    @if($dns_managed_elsewhere)
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">DNS Provider</span>
                            </label>
                            <input type="text" wire:model="dns_provider" class="input input-bordered" placeholder="e.g., Cloudflare, Route53" />
                        </div>
                    @endif
                </div>

                <!-- Address -->
                <div class="divider">Address Information</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Address Line 1</span>
                        </label>
                        <input type="text" wire:model="address_line_1" class="input input-bordered" />
                    </div>

                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Address Line 2</span>
                        </label>
                        <input type="text" wire:model="address_line_2" class="input input-bordered" />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">City</span>
                        </label>
                        <input type="text" wire:model="city" class="input input-bordered" />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">State/Province</span>
                        </label>
                        <input type="text" wire:model="state" class="input input-bordered" placeholder="Texas or TX" />
                        <label class="label">
                            <span class="label-text-alt">Full name or abbreviation accepted</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">ZIP/Postal Code</span>
                        </label>
                        <input type="text" wire:model="zip_code" class="input input-bordered" />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Country</span>
                        </label>
                        <input type="text" wire:model="country" class="input input-bordered" />
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="divider">Billing Address</div>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" wire:model.live="billing_address_same" class="checkbox checkbox-primary" />
                        <span class="label-text">Same as main address</span>
                    </label>
                </div>

                @if(!$billing_address_same)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Billing Address Line 1</span>
                            </label>
                            <input type="text" wire:model="billing_address_line_1" class="input input-bordered" />
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Billing Address Line 2</span>
                            </label>
                            <input type="text" wire:model="billing_address_line_2" class="input input-bordered" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Billing City</span>
                            </label>
                            <input type="text" wire:model="billing_city" class="input input-bordered" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Billing State/Province</span>
                            </label>
                            <input type="text" wire:model="billing_state" class="input input-bordered" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Billing ZIP/Postal Code</span>
                            </label>
                            <input type="text" wire:model="billing_zip_code" class="input input-bordered" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Billing Country</span>
                            </label>
                            <input type="text" wire:model="billing_country" class="input input-bordered" />
                        </div>
                    </div>
                @endif

                <!-- Status & Notes -->
                <div class="divider">Additional Information</div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status <span class="text-error">*</span></span>
                    </label>
                    <select wire:model="status" class="select select-bordered">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Notes</span>
                    </label>
                    <textarea wire:model="notes" class="textarea textarea-bordered" rows="3"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="modal-action">
                    @if($showAddModal)
                        <button type="button" wire:click="closeAddModal" class="btn btn-ghost">Cancel</button>
                    @else
                        <button type="button" wire:click="closeEditModal" class="btn btn-ghost">Cancel</button>
                    @endif
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save">
                            {{ $clientId ? 'Update Client' : 'Create Client' }}
                        </span>
                        <span wire:loading wire:target="save" class="loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            @if($showAddModal)
                <button wire:click="closeAddModal" type="button">close</button>
            @else
                <button wire:click="closeEditModal" type="button">close</button>
            @endif
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal {{ $showDeleteModal ? 'modal-open' : '' }}">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error">Confirm Delete</h3>
            <p class="py-4">Are you sure you want to delete this client? This action cannot be undone.</p>
            
            <div class="modal-action">
                <button wire:click="closeDeleteModal" class="btn btn-ghost">Cancel</button>
                <button wire:click="delete" class="btn btn-error" wire:loading.attr="disabled" wire:target="delete">
                    <span wire:loading.remove wire:target="delete">Delete Client</span>
                    <span wire:loading wire:target="delete" class="loading loading-spinner loading-sm"></span>
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button wire:click="closeDeleteModal" type="button">close</button>
        </form>
    </div>

    <!-- CSV Import Modal -->
    <div class="modal {{ $showImportModal ? 'modal-open' : '' }}">
        <div class="modal-box max-w-4xl">
            <h3 class="font-bold text-lg mb-4">Import Clients from CSV</h3>

            @if(!$showCsvPreview)
                <!-- File Upload Step -->
                <div class="space-y-4">
                    <div class="alert alert-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Import Instructions:</p>
                            <ul class="list-disc list-inside text-sm mt-1">
                                <li>Download the template to see required format</li>
                                <li>Match by <strong>account_number</strong> (if provided) or <strong>company_name</strong> (case-sensitive)</li>
                                <li>Only <strong>company_name</strong> is required</li>
                                <li>Existing clients will be updated, new ones created</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Select CSV File</span>
                        </label>
                        <input type="file" wire:model="csvFile" accept=".csv,.txt" class="file-input file-input-bordered w-full" />
                        @error('csvFile')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                        @if($csvFile)
                            <label class="label">
                                <span class="label-text-alt text-success">✓ File selected: {{ $csvFile->getClientOriginalName() }}</span>
                            </label>
                        @endif
                        <div wire:loading wire:target="csvFile" class="label">
                            <span class="label-text-alt">
                                <span class="loading loading-spinner loading-sm"></span>
                                Uploading file...
                            </span>
                        </div>
                    </div>

                    @if($isProcessing)
                        <div class="space-y-2" wire:poll.500ms>
                            <div class="flex justify-between text-sm">
                                <span>{{ $progressMessage }}</span>
                                <span>{{ $progressCurrent }} / {{ $progressTotal }}</span>
                            </div>
                            <progress class="progress progress-primary w-full" value="{{ $progressTotal > 0 ? ($progressCurrent / $progressTotal) * 100 : 0 }}" max="100"></progress>
                        </div>
                    @endif

                    <div class="modal-action">
                        <button wire:click="closeImportModal" class="btn btn-ghost" wire:loading.attr="disabled" wire:target="previewCsv">
                            Cancel
                        </button>
                        <button 
                            wire:click="previewCsv" 
                            class="btn btn-primary" 
                            wire:loading.attr="disabled" 
                            wire:target="previewCsv"
                            @if(!$csvFile) disabled @endif
                        >
                            <span wire:loading.remove wire:target="previewCsv">
                                @if($csvFile)
                                    Preview Import
                                @else
                                    Select a file first
                                @endif
                            </span>
                            <span wire:loading wire:target="previewCsv">
                                <span class="loading loading-spinner loading-sm"></span>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            @else
                <!-- Preview Step -->
                <div class="space-y-4">
                    <div class="stats shadow w-full">
                        <div class="stat">
                            <div class="stat-title">New Clients</div>
                            <div class="stat-value text-success">{{ $csvCreateCount }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Updates</div>
                            <div class="stat-value text-info">{{ $csvUpdateCount }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Errors</div>
                            <div class="stat-value text-error">{{ count($csvErrors) }}</div>
                        </div>
                    </div>

                    @if(count($csvErrors) > 0)
                        <div class="alert alert-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold">Errors Found:</p>
                                <ul class="list-disc list-inside text-sm mt-1">
                                    @foreach($csvErrors as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-auto max-h-96">
                        <table class="table table-zebra table-compact">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Account #</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($csvPreviewData as $row)
                                    <tr>
                                        <td>
                                            @if($row['_action'] === 'create')
                                                <span class="badge badge-success badge-sm">Create</span>
                                            @else
                                                <span class="badge badge-info badge-sm">Update</span>
                                            @endif
                                        </td>
                                        <td class="font-mono text-xs">
                                            @if($row['_action'] === 'create')
                                                <span class="text-success">{{ $row['_preview_account'] }}</span>
                                            @else
                                                {{ $row['_existing_account'] }}
                                            @endif
                                        </td>
                                        <td class="font-semibold">{{ $row['company_name'] }}</td>
                                        <td class="text-sm">{{ $row['email'] ?? '—' }}</td>
                                        <td class="text-sm">{{ $row['mobile'] ?? $row['phone'] ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($isProcessing)
                        <div class="space-y-2" wire:poll.500ms>
                            <div class="flex justify-between text-sm">
                                <span>{{ $progressMessage }}</span>
                                <span>{{ $progressCurrent }} / {{ $progressTotal }}</span>
                            </div>
                            <progress class="progress progress-primary w-full" value="{{ $progressTotal > 0 ? ($progressCurrent / $progressTotal) * 100 : 0 }}" max="100"></progress>
                        </div>
                    @endif

                    <div class="modal-action">
                        <button wire:click="closeImportModal" class="btn btn-ghost" wire:loading.attr="disabled" wire:target="confirmImport">
                            Cancel
                        </button>
                        <button wire:click="confirmImport" class="btn btn-primary" wire:loading.attr="disabled" wire:target="confirmImport">
                            <span wire:loading.remove wire:target="confirmImport">Confirm Import</span>
                            <span wire:loading wire:target="confirmImport" class="loading loading-spinner loading-sm"></span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
        <form method="dialog" class="modal-backdrop">
            <button wire:click="closeImportModal" type="button">close</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Listen for the process-next-batch event
        Livewire.on('process-next-batch', () => {
            // Small delay to allow UI to update
            setTimeout(() => {
                @this.call('processNextBatch');
            }, 100);
        });
    });
</script>
@endpush

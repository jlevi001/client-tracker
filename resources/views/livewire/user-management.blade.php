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

    <!-- Header with Search and Add Button -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="w-full sm:w-1/3">
            <input wire:model.live="search" 
                   type="text" 
                   placeholder="Search users..." 
                   autocomplete="off"
                   class="input input-bordered w-full">
        </div>
        <button wire:click="openCreateModal" 
                class="btn btn-primary w-full sm:w-auto">
            Add New User
        </button>
    </div>

    <!-- Users Tables -->
    <div class="card bg-base-200 shadow-xl">
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th wire:click="sortBy('name')" class="cursor-pointer hover:bg-base-300">
                            <div class="flex items-center gap-1">
                                Name
                                @if($sortField === 'name')
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
                        <th wire:click="sortBy('email')" class="cursor-pointer hover:bg-base-300">
                            <div class="flex items-center gap-1">
                                Email
                                @if($sortField === 'email')
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
                        <th>Role</th>
                        <th wire:click="sortBy('employment_start_date')" class="cursor-pointer hover:bg-base-300">
                            <div class="flex items-center gap-1">
                                Start Date
                                @if($sortField === 'employment_start_date')
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
                    @forelse($users as $user)
                        <tr class="hover">
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div class="avatar cursor-pointer" wire:click="openEditModal({{ $user->id }})">
                                        <div class="mask mask-circle w-10 h-10">
                                            <img src="{{ $user->profile_photo_url }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="hover:ring-2 hover:ring-primary transition-all duration-150">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->roles->isNotEmpty())
                                    <span class="badge 
                                        @if($user->roles->first()->name === 'Admin') badge-error
                                        @elseif($user->roles->first()->name === 'Manager') badge-warning
                                        @else badge-success
                                        @endif">
                                        {{ $user->roles->first()->name }}
                                    </span>
                                @else
                                    <span class="badge badge-ghost">No Role</span>
                                @endif
                            </td>
                            <td>
                                @if($user->employment_start_date)
                                    {{ $user->employment_start_date->format('M d, Y') }}
                                @else
                                    <span class="text-base-content/50">Not set</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <button wire:click="openEditModal({{ $user->id }})" 
                                            class="btn btn-ghost btn-xs text-primary">
                                        Edit
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button wire:click="openDeleteModal({{ $user->id }})" 
                                                class="btn btn-ghost btn-xs text-error">
                                            Delete
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="py-8 text-base-content/50">
                                    No users found.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="card-body">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create Modal -->
    <x-dialog-modal wire:model="showCreateModal">
        <x-slot name="title">
            Create New User
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" wire:model="name" class="input input-bordered w-full @error('name') input-error @enderror" />
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" wire:model="email" class="input input-bordered w-full @error('email') input-error @enderror" />
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" wire:model="password" class="input input-bordered w-full @error('password') input-error @enderror" />
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Confirm Password</span>
                    </label>
                    <input type="password" wire:model="password_confirmation" class="input input-bordered w-full" />
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Role</span>
                    </label>
                    <select wire:model="selectedRole" class="select select-bordered w-full @error('selectedRole') select-error @enderror">
                        <option value="">Select a role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedRole')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
<div class="form-control w-full">
    <label class="label">
        <span class="label-text">Employment Start Date</span>
    </label>
    <input type="date" wire:model="employmentStartDate" class="input input-bordered w-full @error('employmentStartDate') input-error @enderror" />
    @error('employmentStartDate')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
                <!-- Wage Information Section -->
                <div class="divider">Wage Information (Optional)</div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Wage Type</span>
                        </label>
                        <select wire:model="wageType" class="select select-bordered w-full">
                            <option value="">Not Set</option>
                            <option value="hourly">Hourly</option>
                            <option value="salary">Salary</option>
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Rate ($)</span>
                        </label>
                        <input type="number" step="0.01" min="0" wire:model="wageRate" class="input input-bordered w-full" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Start Date</span>
                        </label>
                        <input type="date" wire:model="wageStartDate" class="input input-bordered w-full" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Notes</span>
                        </label>
                        <input type="text" wire:model="wageNotes" placeholder="e.g., Initial hire" class="input input-bordered w-full" />
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showCreateModal', false)" wire:loading.attr="disabled">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="createUser" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="createUser">Create User</span>
                <span wire:loading wire:target="createUser" class="loading loading-spinner loading-sm"></span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Edit Modal -->
    <x-dialog-modal wire:model="showEditModal">
        <x-slot name="title">
            Edit User
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6 max-h-[70vh] overflow-y-auto px-1">
                <!-- Basic Information Section -->
                <div class="space-y-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Name</span>
                        </label>
                        <input type="text" wire:model="name" class="input input-bordered w-full @error('name') input-error @enderror" />
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" wire:model="email" class="input input-bordered w-full @error('email') input-error @enderror" />
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Password (leave blank to keep current)</span>
                        </label>
                        <input type="password" wire:model="password" class="input input-bordered w-full @error('password') input-error @enderror" />
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Confirm Password</span>
                        </label>
                        <input type="password" wire:model="password_confirmation" class="input input-bordered w-full" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Role</span>
                        </label>
                        <select wire:model="selectedRole" class="select select-bordered w-full @error('selectedRole') select-error @enderror">
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedRole')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>
<div class="form-control w-full">
    <label class="label">
        <span class="label-text">Employment Start Date</span>
    </label>
    @if(auth()->user()->hasRole('Admin'))
        <input type="date" wire:model="employmentStartDate" class="input input-bordered w-full @error('employmentStartDate') input-error @enderror" />
        @error('employmentStartDate')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
        @enderror
    @else
        {{-- Non-admins see read-only display --}}
        <div class="px-3 py-2 bg-base-300 rounded-md">
            @if($employmentStartDate)
                {{ \Carbon\Carbon::parse($employmentStartDate)->format('M d, Y') }}
            @else
                <span class="text-base-content/50">Not set</span>
            @endif
        </div>
        <label class="label">
            <span class="label-text-alt text-base-content/50">Only administrators can edit this field</span>
        </label>
    @endif
</div>
                <!-- Wage Information Section with Visibility Toggle -->
                <div class="divider">Wage Information</div>
                
                <div x-data="{ showWageInfo: false }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium">Wage Details</h3>
                        
                        <!-- Eye Toggle Button -->
                        <button type="button" 
                                @click="showWageInfo = !showWageInfo"
                                class="btn btn-ghost btn-sm btn-circle"
                                :class="{ 'btn-active': showWageInfo }"
                                :aria-label="showWageInfo ? 'Hide wage information' : 'Show wage information'">
                            <!-- Eye Icon (Visible) -->
                            <svg x-show="!showWageInfo" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <!-- Eye Off Icon (Hidden) -->
                            <svg x-show="showWageInfo" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Wage Content (Hidden by default) -->
                    <div x-show="showWageInfo" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95">
                        
                        <!-- Current Wage Display -->
                        @if($wageType && $wageRate)
                            <div class="alert alert-info mb-4">
                                <div>
                                    <div class="flex flex-wrap items-center gap-4">
                                        <span class="badge badge-primary">{{ ucfirst($wageType) }}</span>
                                        <span class="badge badge-primary">${{ number_format($wageRate, 2) }}</span>
                                        <span class="badge badge-primary">Start: {{ \Carbon\Carbon::parse($wageStartDate)->format('m/d/Y') }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" wire:click="editCurrentWage" class="btn btn-ghost btn-xs text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            @if($userId)
                                <button type="button" wire:click="openWageHistoryModal({{ $userId }})" 
                                        class="btn btn-primary btn-sm mb-4 w-full sm:w-auto">
                                    View Wage History
                                </button>
                            @endif
                        @else
                            <div class="alert mb-4">
                                <span>No wage information set</span>
                            </div>
                        @endif

                        <!-- Edit Current Wage Form (Hidden by default, shown when editing) -->
                        @if($showEditCurrentWageForm)
                            <div class="card bg-base-300 mb-4">
                                <div class="card-body">
                                    <h4 class="card-title text-sm">Edit Current Wage (Corrections Only)</h4>
                                    <p class="text-sm opacity-70">Use this to correct errors in the current wage record. For actual wage changes, use "Add New Wage" below.</p>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Wage Type</span>
                                            </label>
                                            <select wire:model="wageType" class="select select-bordered select-sm w-full">
                                                <option value="">Not Set</option>
                                                <option value="hourly">Hourly</option>
                                                <option value="salary">Salary</option>
                                            </select>
                                        </div>

                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Rate ($)</span>
                                            </label>
                                            <input type="number" step="0.01" min="0" wire:model="wageRate" class="input input-bordered input-sm w-full" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Start Date</span>
                                            </label>
                                            <input type="date" wire:model="wageStartDate" class="input input-bordered input-sm w-full" />
                                        </div>

                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Notes</span>
                                            </label>
                                            <input type="text" wire:model="wageNotes" class="input input-bordered input-sm w-full" />
                                        </div>
                                    </div>

                                    <div class="card-actions justify-end mt-4">
                                        <button type="button" wire:click="cancelCurrentWageEdit" class="btn btn-ghost btn-sm">
                                            Cancel
                                        </button>
                                        <button type="button" wire:click="saveCurrentWageEdit" class="btn btn-primary btn-sm">
                                            Save Corrections
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="divider"></div>

                        <!-- Add New Wage Section -->
                        <button type="button" wire:click="$toggle('showAddWageForm')" 
                                class="btn btn-success btn-sm mb-4 w-full sm:w-auto">
                            Add New Wage
                        </button>
                        
                        @if($showAddWageForm ?? false)
                            <div class="card bg-base-300">
                                <div class="card-body">
                                    <h4 class="card-title text-sm">Add New Wage</h4>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Wage Type</span>
                                            </label>
                                            <select wire:model="newWageType" class="select select-bordered select-sm w-full">
                                                <option value="">Select type</option>
                                                <option value="hourly">Hourly</option>
                                                <option value="salary">Salary</option>
                                            </select>
                                        </div>

                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Rate ($)</span>
                                            </label>
                                            <input type="number" step="0.01" min="0" wire:model="newWageRate" class="input input-bordered input-sm w-full" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Start Date</span>
                                            </label>
                                            <input type="date" wire:model="newWageStartDate" class="input input-bordered input-sm w-full" />
                                        </div>

                                        <div class="form-control w-full">
                                            <label class="label">
                                                <span class="label-text">Notes</span>
                                            </label>
                                            <input type="text" wire:model="newWageNotes" placeholder="e.g., Annual raise" class="input input-bordered input-sm w-full" />
                                        </div>
                                    </div>

                                    <div class="card-actions justify-end mt-4">
                                        <button type="button" wire:click="$set('showAddWageForm', false)" class="btn btn-ghost btn-sm">
                                            Cancel
                                        </button>
                                        <button type="button" wire:click="addNewWage" class="btn btn-primary btn-sm">
                                            Add Wage
                                        </button>
                                    </div>
                                    
                                    <div class="alert alert-info mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm">Adding a new wage will close the current wage record and create a new one for tracking wage changes.</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Hidden Placeholder when wage info is hidden -->
                    <div x-show="!showWageInfo" class="text-center py-4">
                        <p class="text-sm opacity-50">Click the eye icon to view wage information</p>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="updateUser" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="updateUser">Update User</span>
                <span wire:loading wire:target="updateUser" class="loading loading-spinner loading-sm"></span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Wage History Modal -->
    <x-dialog-modal wire:model="showWageHistoryModal" maxWidth="4xl">
        <x-slot name="title">
            Wage History
        </x-slot>


        <x-slot name="content">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Rate</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Notes</th>
                            <th>Set By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currentWageHistory as $wage)
                            <tr class="{{ !$wage['end_date'] ? 'bg-success/10' : '' }}">
                                <td>{{ ucfirst($wage['wage_type']) }}</td>
                                <td>
                                    ${{ number_format($wage['wage_rate'], 2) }}
                                    @if($wage['wage_type'] === 'hourly')
                                        /hour
                                    @else
                                        /year
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($wage['start_date'])->format('M d, Y') }}</td>
                                <td>
                                    @if($wage['end_date'])
                                        {{ \Carbon\Carbon::parse($wage['end_date'])->format('M d, Y') }}
                                    @else
                                        <span class="badge badge-success">Current</span>
                                    @endif
                                </td>
                                <td>{{ $wage['notes'] ?? '-' }}</td>
                                <td>{{ $wage['created_by']['name'] ?? 'System' }}</td>
                                <td>
                                    <button wire:click="openEditWageModal({{ $wage['id'] }})" 
                                            class="btn btn-ghost btn-xs text-primary">
                                        Edit Notes
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="py-8 text-base-content/50">
                                        No wage history found.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showWageHistoryModal', false)" wire:loading.attr="disabled">
                Close
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Edit Wage Notes Modal -->
    <x-dialog-modal wire:model="showEditWageModal">
        <x-slot name="title">
            Edit Wage Notes
        </x-slot>

        <x-slot name="content">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Notes</span>
                </label>
                <textarea wire:model="editingWageNotes" 
                          rows="3"
                          class="textarea textarea-bordered w-full @error('editingWageNotes') textarea-error @enderror">
                </textarea>
                @error('editingWageNotes')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showEditWageModal', false)" wire:loading.attr="disabled">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="updateWageNotes" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="updateWageNotes">Update Notes</span>
                <span wire:loading wire:target="updateWageNotes" class="loading loading-spinner loading-sm"></span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">
            Delete User
        </x-slot>

        <x-slot name="content">
            <div class="text-base-content/80">
                Are you sure you want to delete this user? This action cannot be undone.
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                Cancel
            </button>
            <button class="btn btn-error" wire:click="deleteUser" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="deleteUser">Delete User</span>
                <span wire:loading wire:target="deleteUser" class="loading loading-spinner loading-sm"></span>
            </button>
        </x-slot>
    </x-confirmation-modal>
</div>
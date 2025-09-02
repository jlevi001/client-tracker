<div>
    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="mb-4 bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header with Search and Add Button -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="w-full sm:w-1/3">
            <input wire:model.live="search" type="text" placeholder="Search users..." 
                   autocomplete="off"
                   class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 hover:bg-gray-600 transition-colors duration-200">
        </div>
        <button wire:click="openCreateModal" 
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
            Add New User
        </button>
    </div>

    <!-- Users Table -->
    <div class="bg-gray-800 overflow-hidden shadow-xl rounded-lg">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-800">
                        <div class="flex items-center">
                            Name
                            @if($sortField === 'name')
                                @if($sortDirection === 'asc')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th wire:click="sortBy('email')" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-800">
                        <div class="flex items-center">
                            Email
                            @if($sortField === 'email')
                                @if($sortDirection === 'asc')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Role
                    </th>
                    <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-800">
                        <div class="flex items-center">
                            Joined
                            @if($sortField === 'created_at')
                                @if($sortDirection === 'asc')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 cursor-pointer" wire:click="openEditModal({{ $user->id }})">
                                    <img class="h-10 w-10 rounded-full hover:ring-2 hover:ring-indigo-500 transition-all duration-150" 
                                         src="{{ $user->profile_photo_url }}" 
                                         alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-100">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->roles->isNotEmpty())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($user->roles->first()->name === 'Admin') bg-red-900 text-red-200
                                    @elseif($user->roles->first()->name === 'Manager') bg-yellow-900 text-yellow-200
                                    @else bg-green-900 text-green-200
                                    @endif">
                                    {{ $user->roles->first()->name }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-700 text-gray-300">
                                    No Role
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openEditModal({{ $user->id }})" 
                                    class="text-indigo-400 hover:text-indigo-300 mr-3 transition-colors duration-200">
                                Edit
                            </button>
                            @if($user->id !== auth()->id())
                                <button wire:click="openDeleteModal({{ $user->id }})" 
                                        class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-900 border-t border-gray-700">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create Modal -->
    <x-dialog-modal wire:model="showCreateModal">
        <x-slot name="title">
            <span class="text-white">Create New User</span>
        </x-slot>

        <x-slot name="content">
            <div class="mt-4 space-y-4">
                <div>
                    <x-dark-label for="name" value="Name" />
                    <x-dark-input id="name" type="text" wire:model="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <div>
                    <x-dark-label for="email" value="Email" />
                    <x-dark-input id="email" type="email" wire:model="email" />
                    <x-input-error for="email" class="mt-2" />
                </div>

                <div>
                    <x-dark-label for="password" value="Password" />
                    <x-dark-input id="password" type="password" wire:model="password" />
                    <x-input-error for="password" class="mt-2" />
                </div>

                <div>
                    <x-dark-label for="password_confirmation" value="Confirm Password" />
                    <x-dark-input id="password_confirmation" type="password" wire:model="password_confirmation" />
                </div>

                <div>
                    <x-dark-label for="role" value="Role" />
                    <x-dark-select id="role" wire:model="selectedRole">
                        <option value="">Select a role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </x-dark-select>
                    <x-input-error for="selectedRole" class="mt-2" />
                </div>

                <!-- Wage Information Section -->
                <div class="mt-6 pt-6 border-t border-gray-700">
                    <h3 class="text-lg font-medium text-gray-300 mb-4">Wage Information (Optional)</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-dark-label for="wageType" value="Wage Type" />
                            <x-dark-select id="wageType" wire:model="wageType">
                                <option value="">Not Set</option>
                                <option value="hourly">Hourly</option>
                                <option value="salary">Salary</option>
                            </x-dark-select>
                            <x-input-error for="wageType" class="mt-2" />
                        </div>

                        <div>
                            <x-dark-label for="wageRate" value="Rate ($)" />
                            <x-dark-input id="wageRate" type="number" step="0.01" min="0" wire:model="wageRate" />
                            <x-input-error for="wageRate" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-dark-label for="wageStartDate" value="Start Date" />
                            <x-dark-input id="wageStartDate" type="date" wire:model="wageStartDate" />
                            <x-input-error for="wageStartDate" class="mt-2" />
                        </div>

                        <div>
                            <x-dark-label for="wageNotes" value="Notes" />
                            <x-dark-input id="wageNotes" type="text" wire:model="wageNotes" placeholder="e.g., Initial hire" />
                            <x-input-error for="wageNotes" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showCreateModal', false)" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="createUser" wire:loading.attr="disabled">
                Create User
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Edit Modal -->
    <x-dialog-modal wire:model="showEditModal">
        <x-slot name="title">
            <span class="text-white">Edit User</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6 max-h-[70vh] overflow-y-auto px-1">
                <!-- Basic Information Section -->
                <div class="space-y-4">
                    <div>
                        <x-dark-label for="edit-name" value="Name" />
                        <x-dark-input id="edit-name" type="text" wire:model="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div>
                        <x-dark-label for="edit-email" value="Email" />
                        <x-dark-input id="edit-email" type="email" wire:model="email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    <div>
                        <x-dark-label for="edit-password" value="Password (leave blank to keep current)" />
                        <x-dark-input id="edit-password" type="password" wire:model="password" />
                        <x-input-error for="password" class="mt-2" />
                    </div>

                    <div>
                        <x-dark-label for="edit-password_confirmation" value="Confirm Password" />
                        <x-dark-input id="edit-password_confirmation" type="password" wire:model="password_confirmation" />
                    </div>

                    <div>
                        <x-dark-label for="edit-role" value="Role" />
                        <x-dark-select id="edit-role" wire:model="selectedRole">
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </x-dark-select>
                        <x-input-error for="selectedRole" class="mt-2" />
                    </div>
                </div>

                <!-- Wage Information Section with Visibility Toggle -->
                <div class="pt-6 border-t border-gray-700" x-data="{ showWageInfo: false }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-300">Wage Information</h3>
                        
                        <!-- Eye Toggle Button -->
                        <button type="button" 
                                @click="showWageInfo = !showWageInfo"
                                class="p-2 text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                :class="{ 'bg-gray-700 text-gray-300': showWageInfo }"
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
                            <div class="mb-4 p-4 bg-gray-700 border border-gray-600 rounded-lg">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div class="flex flex-wrap items-center gap-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-400 text-sm">Wage Type:</span>
                                            <span class="text-white bg-gray-800 px-3 py-1 rounded">{{ ucfirst($wageType) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-400 text-sm">Rate:</span>
                                            <span class="text-white bg-gray-800 px-3 py-1 rounded">${{ number_format($wageRate, 2) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-400 text-sm">Start Date:</span>
                                            <span class="text-white bg-gray-800 px-3 py-1 rounded">{{ \Carbon\Carbon::parse($wageStartDate)->format('m/d/Y') }}</span>
                                        </div>
                                    </div>
                                    <button type="button" wire:click="editCurrentWage" class="text-indigo-400 hover:text-indigo-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            @if($userId)
                                <button type="button" wire:click="openWageHistoryModal({{ $userId }})" 
                                        class="mb-4 px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                    View Wage History
                                </button>
                            @endif
                        @else
                            <p class="text-gray-400 mb-4">No wage information set</p>
                        @endif

                        <!-- Edit Current Wage Form (Hidden by default, shown when editing) -->
                        @if($showEditCurrentWageForm)
                            <div class="mt-4 p-4 bg-gray-700 border border-gray-600 rounded-lg">
                                <h4 class="text-md font-medium text-gray-300 mb-3">Edit Current Wage (Corrections Only)</h4>
                                <p class="text-sm text-gray-400 mb-4">Use this to correct errors in the current wage record. For actual wage changes, use "Add New Wage" below.</p>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <x-dark-label for="edit-wageType" value="Wage Type" />
                                        <x-dark-select id="edit-wageType" wire:model="wageType">
                                            <option value="">Not Set</option>
                                            <option value="hourly">Hourly</option>
                                            <option value="salary">Salary</option>
                                        </x-dark-select>
                                        <x-input-error for="wageType" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-dark-label for="edit-wageRate" value="Rate ($)" />
                                        <x-dark-input id="edit-wageRate" type="number" step="0.01" min="0" wire:model="wageRate" />
                                        <x-input-error for="wageRate" class="mt-2" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <x-dark-label for="edit-wageStartDate" value="Start Date" />
                                        <x-dark-input id="edit-wageStartDate" type="date" wire:model="wageStartDate" />
                                        <x-input-error for="wageStartDate" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-dark-label for="edit-wageNotes" value="Notes" />
                                        <x-dark-input id="edit-wageNotes" type="text" wire:model="wageNotes" />
                                        <x-input-error for="wageNotes" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mt-4 flex space-x-2">
                                    <button type="button" wire:click="saveCurrentWageEdit" 
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                        Save Corrections
                                    </button>
                                    <button type="button" wire:click="cancelCurrentWageEdit" 
                                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="my-4 border-t border-gray-700"></div>

                        <!-- Add New Wage Section -->
                        <button type="button" wire:click="$toggle('showAddWageForm')" 
                                class="mb-4 px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                            Add New Wage
                        </button>
                        
                        @if($showAddWageForm ?? false)
                        <div class="p-4 bg-gray-700 border border-gray-600 rounded-lg">
                            <h4 class="text-md font-medium text-gray-300 mb-3">Add New Wage</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-dark-label for="newWageType" value="Wage Type" />
                                    <x-dark-select id="newWageType" wire:model="newWageType">
                                        <option value="">Select type</option>
                                        <option value="hourly">Hourly</option>
                                        <option value="salary">Salary</option>
                                    </x-dark-select>
                                    <x-input-error for="newWageType" class="mt-2" />
                                </div>

                                <div>
                                    <x-dark-label for="newWageRate" value="Rate ($)" />
                                    <x-dark-input id="newWageRate" type="number" step="0.01" min="0" wire:model="newWageRate" />
                                    <x-input-error for="newWageRate" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-dark-label for="newWageStartDate" value="Start Date" />
                                    <x-dark-input id="newWageStartDate" type="date" wire:model="newWageStartDate" />
                                    <x-input-error for="newWageStartDate" class="mt-2" />
                                </div>

                                <div>
                                    <x-dark-label for="newWageNotes" value="Notes" />
                                    <x-dark-input id="newWageNotes" type="text" wire:model="newWageNotes" placeholder="e.g., Annual raise" />
                                    <x-input-error for="newWageNotes" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="button" wire:click="addNewWage" 
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                    Add Wage
                                </button>
                                <button type="button" wire:click="$set('showAddWageForm', false)" 
                                        class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-colors duration-200">
                                    Cancel
                                </button>
                            </div>
                            
                            <div class="mt-3 text-sm text-gray-400">
                                <p>Adding a new wage will close the current wage record and create a new one for tracking wage changes.</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Hidden Placeholder when wage info is hidden -->
                    <div x-show="!showWageInfo" class="py-4 text-center text-gray-400">
                        <p class="text-sm">Click the eye icon to view wage information</p>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="updateUser" wire:loading.attr="disabled">
                Update User
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Wage History Modal -->
    <x-dialog-modal wire:model="showWageHistoryModal" maxWidth="4xl">
        <x-slot name="title">
            <span class="text-white">Wage History</span>
        </x-slot>

        <x-slot name="content">
            <div class="px-2 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Rate</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Start Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">End Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Notes</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Set By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse($currentWageHistory as $wage)
                            <tr class="{{ !$wage['end_date'] ? 'bg-green-900 bg-opacity-20' : '' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ ucfirst($wage['wage_type']) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                    ${{ number_format($wage['wage_rate'], 2) }}
                                    @if($wage['wage_type'] === 'hourly')
                                        /hour
                                    @else
                                        /year
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ \Carbon\Carbon::parse($wage['start_date'])->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                    @if($wage['end_date'])
                                        {{ \Carbon\Carbon::parse($wage['end_date'])->format('M d, Y') }}
                                    @else
                                        <span class="text-green-400 font-semibold">Current</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-300">
                                    {{ $wage['notes'] ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $wage['created_by']['name'] ?? 'System' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <button wire:click="openEditWageModal({{ $wage['id'] }})" 
                                            class="text-indigo-400 hover:text-indigo-300 transition-colors duration-200">
                                        Edit Notes
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-400">
                                    No wage history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showWageHistoryModal', false)" wire:loading.attr="disabled">
                Close
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Edit Wage Notes Modal -->
    <x-dialog-modal wire:model="showEditWageModal">
        <x-slot name="title">
            <span class="text-white">Edit Wage Notes</span>
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-dark-label for="editingWageNotes" value="Notes" />
                <textarea id="editingWageNotes" 
                    wire:model="editingWageNotes" 
                    rows="3"
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 hover:bg-gray-600 transition-colors duration-200">
                </textarea>
                <x-input-error for="editingWageNotes" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditWageModal', false)" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ml-3" wire:click="updateWageNotes" wire:loading.attr="disabled">
                Update Notes
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">
            <span class="text-white">Delete User</span>
        </x-slot>

        <x-slot name="content">
            <span class="text-gray-300">Are you sure you want to delete this user? This action cannot be undone.</span>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                Delete User
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
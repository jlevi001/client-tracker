<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-2xl font-bold">Users Management</h2>
        <button class="btn btn-primary w-full sm:w-auto" wire:click="showCreateModal">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add User
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full">
        <div class="stat">
            <div class="stat-title">Total Users</div>
            <div class="stat-value text-primary">{{ $totalUsers }}</div>
            <div class="stat-desc">↗︎ 400 (22%)</div>
        </div>
        
        <div class="stat">
            <div class="stat-title">Active Users</div>
            <div class="stat-value text-success">{{ $activeUsers }}</div>
            <div class="stat-desc">↗︎ 90 (14%)</div>
        </div>
        
        <div class="stat">
            <div class="stat-title">New Users</div>
            <div class="stat-value">{{ $newUsers }}</div>
            <div class="stat-desc">↘︎ 12 (2%)</div>
        </div>
    </div>

    {{-- Search and Filters --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <div class="flex flex-col lg:flex-row gap-4">
                {{-- Search Input --}}
                <div class="form-control flex-1">
                    <div class="input-group">
                        <input 
                            type="text" 
                            placeholder="Search users..."
                            class="input input-bordered w-full"
                            wire:model.live.debounce.300ms="search"
                        />
                        <button class="btn btn-square">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Role Filter --}}
                <div class="form-control">
                    <select class="select select-bordered" wire:model.live="roleFilter">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="viewer">Viewer</option>
                    </select>
                </div>

                {{-- Status Filter --}}
                <div class="form-control">
                    <select class="select select-bordered" wire:model.live="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card bg-base-200">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" class="checkbox checkbox-sm" wire:model="selectAll" />
                                </label>
                            </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="hover">
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-sm" wire:model="selectedUsers" value="{{ $user->id }}" />
                                    </label>
                                </th>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-12 h-12">
                                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">{{ $user->name }}</div>
                                            <div class="text-sm opacity-50">{{ $user->department }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @switch($user->role)
                                        @case('admin')
                                            <span class="badge badge-primary">Admin</span>
                                            @break
                                        @case('editor')
                                            <span class="badge badge-secondary">Editor</span>
                                            @break
                                        @default
                                            <span class="badge badge-ghost">Viewer</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($user->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif($user->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-error">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $user->last_active->diffForHumans() }}</td>
                                <td>
                                    <div class="flex gap-1">
                                        <button class="btn btn-ghost btn-xs" wire:click="editUser({{ $user->id }})">
                                            Edit
                                        </button>
                                        <button class="btn btn-ghost btn-xs text-error" wire:click="confirmDelete({{ $user->id }})">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <div class="text-base-content/50">
                                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        No users found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div class="p-4">
                    <div class="join">
                        <button class="join-item btn btn-sm" wire:click="previousPage" @if(!$users->hasPreviousPage()) disabled @endif>«</button>
                        <button class="join-item btn btn-sm">Page {{ $users->currentPage() }}</button>
                        <button class="join-item btn btn-sm" wire:click="nextPage" @if(!$users->hasNextPage()) disabled @endif>»</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    <div class="modal @if($showModal) modal-open @endif">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">{{ $editingUser ? 'Edit User' : 'Create New User' }}</h3>
            
            <div class="space-y-4">
                {{-- Name Input --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" class="input input-bordered w-full @error('name') input-error @enderror" wire:model="name" />
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Email Input --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" class="input input-bordered w-full @error('email') input-error @enderror" wire:model="email" />
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Role Select --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Role</span>
                    </label>
                    <select class="select select-bordered w-full @error('role') select-error @enderror" wire:model="role">
                        <option disabled selected>Select a role</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="viewer">Viewer</option>
                    </select>
                    @error('role')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Status Toggle --}}
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Active Status</span>
                        <input type="checkbox" class="toggle toggle-primary" wire:model="isActive" />
                    </label>
                </div>
            </div>

            <div class="modal-action">
                <button class="btn btn-ghost" wire:click="closeModal">Cancel</button>
                <button class="btn btn-primary" wire:click="saveUser" wire:loading.attr="disabled">
                    <span wire:loading.remove>Save</span>
                    <span wire:loading class="loading loading-spinner loading-sm"></span>
                </button>
            </div>
        </div>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal @if($showDeleteModal) modal-open @endif">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error">Confirm Delete</h3>
            <p class="py-4">Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="modal-action">
                <button class="btn btn-ghost" wire:click="$set('showDeleteModal', false)">Cancel</button>
                <button class="btn btn-error" wire:click="deleteUser" wire:loading.attr="disabled">
                    <span wire:loading.remove>Delete</span>
                    <span wire:loading class="loading loading-spinner loading-sm"></span>
                </button>
            </div>
        </div>
        <div class="modal-backdrop" wire:click="$set('showDeleteModal', false)"></div>
    </div>

    {{-- Toast Notifications --}}
    @if(session()->has('success'))
        <div class="toast toast-end">
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="toast toast-end">
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
</div>
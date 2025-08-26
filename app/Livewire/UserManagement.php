<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRole;
    
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'selectedRole' => ['required', 'exists:roles,name'],
        ];

        if ($this->userId) {
            // Editing existing user
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->userId];
            $rules['password'] = ['nullable', 'confirmed', 'min:8'];
        } else {
            // Creating new user
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $rules['password'] = ['required', 'confirmed', 'min:8'];
        }

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openCreateModal()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation', 'selectedRole']);
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function openEditModal($userId)
    {
        $this->resetValidation();
        $user = User::findOrFail($userId);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()?->name;
        $this->password = '';
        $this->password_confirmation = '';
        
        $this->showEditModal = true;
    }

    public function openDeleteModal($userId)
    {
        $this->userId = $userId;
        $this->showDeleteModal = true;
    }

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole($this->selectedRole);

        $this->showCreateModal = false;
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'selectedRole']);
        
        session()->flash('success', 'User created successfully.');
    }

    public function updateUser()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if (!empty($this->password)) {
            $user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $user->syncRoles([$this->selectedRole]);

        $this->showEditModal = false;
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation', 'selectedRole']);
        
        session()->flash('success', 'User updated successfully.');
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->userId);
        
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->showDeleteModal = false;
            return;
        }

        $user->delete();
        
        $this->showDeleteModal = false;
        $this->reset(['userId']);
        
        session()->flash('success', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        return view('livewire.user-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;

    // Search and sort properties
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // User form fields - ALL PROPERTIES MUST BE DECLARED
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRole = '';
    public $wage_type = '';
    public $wage_rate = '';

    // Available roles
    public $roles = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->roles = Role::all();
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
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($userId)
    {
        $this->resetForm();
        $user = User::findOrFail($userId);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()?->name ?? '';
        $this->wage_type = $user->wage_type ?? '';
        $this->wage_rate = $user->wage_rate ? (string) $user->wage_rate : '';
        
        $this->showEditModal = true;
    }

    public function openDeleteModal($userId)
    {
        $this->userId = $userId;
        $this->showDeleteModal = true;
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'selectedRole' => 'required|exists:roles,name',
            'wage_type' => 'nullable|in:hourly,salary',
            'wage_rate' => 'nullable|required_with:wage_type|numeric|min:0|max:99999999.99',
        ]);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];

        // Only add wage fields if they have values
        if (!empty($this->wage_type)) {
            $userData['wage_type'] = $this->wage_type;
        }
        if (!empty($this->wage_rate)) {
            $userData['wage_rate'] = $this->wage_rate;
        }

        $user = User::create($userData);
        $user->assignRole($this->selectedRole);

        session()->flash('success', 'User created successfully.');
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
            'password' => 'nullable|min:8|confirmed',
            'selectedRole' => 'required|exists:roles,name',
            'wage_type' => 'nullable|in:hourly,salary',
            'wage_rate' => 'nullable|required_with:wage_type|numeric|min:0|max:99999999.99',
        ]);

        $user = User::findOrFail($this->userId);
        
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        // Add wage fields
        $updateData['wage_type'] = !empty($this->wage_type) ? $this->wage_type : null;
        $updateData['wage_rate'] = !empty($this->wage_rate) ? $this->wage_rate : null;

        if (!empty($this->password)) {
            $updateData['password'] = Hash::make($this->password);
        }

        $user->update($updateData);

        // Update role
        $user->syncRoles([$this->selectedRole]);

        session()->flash('success', 'User updated successfully.');
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->userId);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->showDeleteModal = false;
            return;
        }

        $user->delete();

        session()->flash('success', 'User deleted successfully.');
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRole = '';
        $this->wage_type = '';
        $this->wage_rate = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.user-management', [
            'users' => $users,
        ]);
    }
}
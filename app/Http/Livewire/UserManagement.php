<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\WageHistory;
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
    public $showWageHistory = false;

    // User form fields
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRole = '';
    
    // Wage history fields
    public $wage_type = '';
    public $wage_rate = '';
    public $wage_start_date = '';
    public $wage_notes = '';
    public $editingWageId = null;

    // Available roles
    public $roles = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->roles = Role::all();
        $this->wage_start_date = now()->format('Y-m-d');
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
        $user = User::with(['roles', 'currentWage'])->findOrFail($userId);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()?->name ?? '';
        
        // Load current wage data if exists
        if ($user->currentWage) {
            $this->wage_type = $user->currentWage->wage_type;
            $this->wage_rate = (string) $user->currentWage->wage_rate;
            $this->wage_start_date = $user->currentWage->start_date->format('Y-m-d');
            $this->wage_notes = $user->currentWage->notes ?? '';
        }
        
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
            'wage_start_date' => 'nullable|required_with:wage_type|date',
            'wage_notes' => 'nullable|string|max:500',
        ]);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];

        $user = User::create($userData);
        $user->assignRole($this->selectedRole);

        // Create wage history record if wage information provided
        if (!empty($this->wage_type) && !empty($this->wage_rate)) {
            $user->setWage(
                $this->wage_type,
                $this->wage_rate,
                $this->wage_start_date,
                auth()->id(),
                $this->wage_notes
            );
        }

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
            'wage_start_date' => 'nullable|required_with:wage_type|date',
            'wage_notes' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($this->userId);
        
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $updateData['password'] = Hash::make($this->password);
        }

        $user->update($updateData);
        $user->syncRoles([$this->selectedRole]);

        // Handle wage information
        if (!empty($this->wage_type) && !empty($this->wage_rate)) {
            $currentWage = $user->currentWage;
            
            // Only create new wage record if something changed
            $hasChanges = !$currentWage || 
                         $currentWage->wage_type !== $this->wage_type ||
                         $currentWage->wage_rate != $this->wage_rate ||
                         $currentWage->start_date->format('Y-m-d') !== $this->wage_start_date;

            if ($hasChanges) {
                $user->setWage(
                    $this->wage_type,
                    $this->wage_rate,
                    $this->wage_start_date,
                    auth()->id(),
                    $this->wage_notes
                );
            }
        }

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

    public function toggleWageHistory()
    {
        $this->showWageHistory = !$this->showWageHistory;
    }

    public function editWageHistoryRecord($wageId)
    {
        $wage = WageHistory::findOrFail($wageId);
        
        // Only allow editing notes for historical records
        $this->editingWageId = $wageId;
        $this->wage_notes = $wage->notes ?? '';
    }

    public function updateWageHistoryRecord()
    {
        $this->validate([
            'wage_notes' => 'nullable|string|max:500',
        ]);

        $wage = WageHistory::findOrFail($this->editingWageId);
        $wage->update([
            'notes' => $this->wage_notes,
        ]);

        $this->editingWageId = null;
        $this->wage_notes = '';
        
        session()->flash('success', 'Wage history record updated successfully.');
    }

    public function cancelWageEdit()
    {
        $this->editingWageId = null;
        $this->wage_notes = '';
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
        $this->wage_start_date = now()->format('Y-m-d');
        $this->wage_notes = '';
        $this->showWageHistory = false;
        $this->editingWageId = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $users = User::with(['roles', 'currentWage'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        // Initialize variables to prevent undefined variable errors
        $currentUser = null;
        $currentUserWageHistory = collect(); // Empty collection
        
        if ($this->userId && $this->showEditModal) {
            $currentUser = User::with(['wageHistory.createdBy'])->find($this->userId);
            $currentUserWageHistory = $currentUser ? $currentUser->wageHistory : collect();
        }

        return view('livewire.user-management', [
            'users' => $users,
            'currentUser' => $currentUser,
            'currentUserWageHistory' => $currentUserWageHistory,
        ]);
    }
}
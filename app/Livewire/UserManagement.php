<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserWageHistory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class UserManagement extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showWageHistoryModal = false;
    public $showEditWageModal = false;
    public $showEditCurrentWageForm = false;
    public $showAddWageForm = false; // Added for toggle functionality
    
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $selectedRole;
    public $employmentStartDate;
    
    // Current wage fields (for editing/corrections)
    public $wageType;
    public $wageRate;
    public $wageStartDate;
    public $wageNotes;
    
    // New wage fields (for adding new wages)
    public $newWageType;
    public $newWageRate;
    public $newWageStartDate;
    public $newWageNotes;
    
    public $currentWageHistory = [];
    public $editingWageId;
    public $editingWageNotes;
    
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'selectedRole' => ['required', 'exists:roles,name'],
            'employmentStartDate' => ['nullable', 'date'],
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

        // Current wage validation rules (when editing current wage)
        if ($this->showEditCurrentWageForm) {
            $rules['wageType'] = ['nullable', 'in:hourly,salary'];
            $rules['wageRate'] = ['nullable', 'numeric', 'min:0', 'max:9999999.99'];
            $rules['wageStartDate'] = ['nullable', 'date'];
            $rules['wageNotes'] = ['nullable', 'string', 'max:500'];
        }

        // New wage validation rules
        $rules['newWageType'] = ['nullable', 'in:hourly,salary'];
        $rules['newWageRate'] = ['nullable', 'numeric', 'min:0', 'max:9999999.99'];
        $rules['newWageStartDate'] = ['nullable', 'date'];
        $rules['newWageNotes'] = ['nullable', 'string', 'max:500'];

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
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation', 'selectedRole', 
                      'employmentStartDate', 'wageType', 'wageRate', 'wageStartDate', 'wageNotes']);
        $this->wageStartDate = now()->format('Y-m-d');
        $this->employmentStartDate = now()->format('Y-m-d');
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function openEditModal($userId)
    {
        $this->resetValidation();
        $user = User::with('currentWage')->findOrFail($userId);
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()?->name;
        $this->employmentStartDate = $user->employment_start_date?->format('Y-m-d');
        $this->password = '';
        $this->password_confirmation = '';
        
        // Load current wage information
        if ($user->currentWage) {
            $this->wageType = $user->currentWage->wage_type;
            $this->wageRate = $user->currentWage->wage_rate;
            $this->wageStartDate = $user->currentWage->start_date->format('Y-m-d');
            $this->wageNotes = $user->currentWage->notes;
        } else {
            $this->wageType = null;
            $this->wageRate = null;
            $this->wageStartDate = now()->format('Y-m-d');
            $this->wageNotes = null;
        }
        
        // Reset new wage fields and forms
        $this->resetNewWageFields();
        $this->showEditCurrentWageForm = false;
        $this->showAddWageForm = false;
        
        $this->showEditModal = true;
    }

    public function openDeleteModal($userId)
    {
        $this->userId = $userId;
        $this->showDeleteModal = true;
    }

    public function openWageHistoryModal($userId)
    {
        $this->userId = $userId;
        $user = User::with(['wageHistory.createdBy'])->findOrFail($userId);
        $this->currentWageHistory = $user->wageHistory->toArray();
        $this->showWageHistoryModal = true;
    }

    public function openEditWageModal($wageId)
    {
        $wage = UserWageHistory::findOrFail($wageId);
        $this->editingWageId = $wage->id;
        $this->editingWageNotes = $wage->notes;
        $this->showEditWageModal = true;
    }

    public function updateWageNotes()
    {
        $this->validate([
            'editingWageNotes' => ['nullable', 'string', 'max:500'],
        ]);

        $wage = UserWageHistory::findOrFail($this->editingWageId);
        $wage->update([
            'notes' => $this->editingWageNotes,
        ]);

        $this->showEditWageModal = false;
        $this->reset(['editingWageId', 'editingWageNotes']);
        
        // Refresh wage history
        $this->openWageHistoryModal($this->userId);
        
        session()->flash('success', 'Wage notes updated successfully.');
    }

    public function editCurrentWage()
    {
        $this->showEditCurrentWageForm = true;
    }

    public function cancelCurrentWageEdit()
    {
        $this->showEditCurrentWageForm = false;
        
        // Reload current wage data
        $user = User::with('currentWage')->findOrFail($this->userId);
        if ($user->currentWage) {
            $this->wageType = $user->currentWage->wage_type;
            $this->wageRate = $user->currentWage->wage_rate;
            $this->wageStartDate = $user->currentWage->start_date->format('Y-m-d');
            $this->wageNotes = $user->currentWage->notes;
        }
    }

    public function saveCurrentWageEdit()
    {
        $this->validate([
            'wageType' => ['nullable', 'in:hourly,salary'],
            'wageRate' => ['nullable', 'numeric', 'min:0', 'max:9999999.99'],
            'wageStartDate' => ['nullable', 'date'],
            'wageNotes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = User::with('currentWage')->findOrFail($this->userId);
        
        if ($user->currentWage) {
            // Update existing current wage (corrections only)
            $user->currentWage->update([
                'wage_type' => $this->wageType,
                'wage_rate' => $this->wageRate,
                'start_date' => $this->wageStartDate,
                'notes' => $this->wageNotes,
            ]);
        } else {
            // Create initial wage if none exists
            $user->wageHistory()->create([
                'wage_type' => $this->wageType,
                'wage_rate' => $this->wageRate,
                'start_date' => $this->wageStartDate,
                'end_date' => null,
                'created_by' => auth()->id(),
                'notes' => $this->wageNotes,
            ]);
        }

        $this->showEditCurrentWageForm = false;
        session()->flash('success', 'Current wage updated successfully.');
    }

    public function addNewWage()
    {
        $this->validate([
            'newWageType' => ['required', 'in:hourly,salary'],
            'newWageRate' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'newWageStartDate' => ['required', 'date'],
            'newWageNotes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = User::findOrFail($this->userId);
        
        // This will automatically close the current wage and create a new one
        $user->setWage(
            $this->newWageType,
            $this->newWageRate,
            $this->newWageStartDate,
            $this->newWageNotes,
            auth()->id()
        );

        // Update the current wage display
        $this->wageType = $this->newWageType;
        $this->wageRate = $this->newWageRate;
        $this->wageStartDate = $this->newWageStartDate;
        $this->wageNotes = $this->newWageNotes;

        // Clear the new wage form fields and hide the form
        $this->resetNewWageFields();
        $this->showAddWageForm = false;
        
        session()->flash('success', 'New wage added successfully.');
    }

    private function resetNewWageFields()
    {
        $this->newWageType = '';
        $this->newWageRate = '';
        $this->newWageStartDate = now()->format('Y-m-d');
        $this->newWageNotes = '';
    }

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'employment_start_date' => $this->employmentStartDate,
        ]);

        $user->assignRole($this->selectedRole);

        // Set initial wage if provided
        if ($this->wageType && $this->wageRate) {
            $user->setWage(
                $this->wageType,
                $this->wageRate,
                $this->wageStartDate,
                $this->wageNotes,
                auth()->id()
            );
        }

        $this->showCreateModal = false;
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'selectedRole',
                      'employmentStartDate', 'wageType', 'wageRate', 'wageStartDate', 'wageNotes']);
        
        session()->flash('success', 'User created successfully.');
    }

    public function updateUser()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->userId],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'selectedRole' => ['required', 'exists:roles,name'],
            'employmentStartDate' => ['nullable', 'date'],
        ]);

        $user = User::findOrFail($this->userId);
        
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'employment_start_date' => $this->employmentStartDate,
        ];

        if (!empty($this->password)) {
            $updateData['password'] = Hash::make($this->password);
        }

        $user->update($updateData);
        $user->syncRoles([$this->selectedRole]);

        $this->showEditModal = false;
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation', 'selectedRole',
                      'employmentStartDate', 'wageType', 'wageRate', 'wageStartDate', 'wageNotes',
                      'newWageType', 'newWageRate', 'newWageStartDate', 'newWageNotes']);
        
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
        $users = User::with(['roles', 'currentWage'])
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

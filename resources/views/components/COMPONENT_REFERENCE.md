# Component Reference Guide

## 📚 Complete Component Library Reference

This guide provides comprehensive documentation for all Blade components in the Lingo Client Tracker application. All components use daisyUI semantic classes and are fully responsive with dark theme support.

## Table of Contents
1. [Button Components](#button-components)
2. [Form Components](#form-components)
3. [Modal Components](#modal-components)
4. [Layout Components](#layout-components)
5. [Alert Components](#alert-components)
6. [Navigation Components](#navigation-components)
7. [Utility Components](#utility-components)

---

## Button Components

### `<x-button>` - Primary Button
Primary action button used for main actions like saving, submitting, or confirming.

**Props:**
- `type` (string): Button type - 'submit', 'button', 'reset' (default: 'submit')
- `size` (string): Button size - 'xs', 'sm', 'md', 'lg' (default: 'md')
- `disabled` (boolean): Disable the button
- `wire:click` (string): Livewire click handler
- `wire:loading.attr` (string): Livewire loading attribute

**Usage:**
```blade
<!-- Basic -->
<x-button>Save Changes</x-button>

<!-- With Livewire -->
<x-button wire:click="save">Save</x-button>

<!-- Different sizes -->
<x-button size="sm">Small Button</x-button>
<x-button size="lg">Large Button</x-button>

<!-- With loading state -->
<x-button wire:click="process" wire:loading.attr="disabled">
    <span wire:loading.remove>Process</span>
    <span wire:loading class="loading loading-spinner loading-sm"></span>
</x-button>

<!-- Disabled -->
<x-button disabled>Disabled Button</x-button>

<!-- Full width on mobile -->
<x-button class="w-full sm:w-auto">Responsive Button</x-button>
```

### `<x-secondary-button>` - Secondary/Ghost Button
Secondary action button for cancel, back, or less important actions.

**Props:**
- Same as `<x-button>`

**Usage:**
```blade
<!-- Basic -->
<x-secondary-button>Cancel</x-secondary-button>

<!-- With Livewire -->
<x-secondary-button wire:click="cancel">Go Back</x-secondary-button>

<!-- In modal footer -->
<div class="modal-action">
    <x-secondary-button wire:click="$set('showModal', false)">Cancel</x-secondary-button>
    <x-button wire:click="save">Save</x-button>
</div>
```

### `<x-danger-button>` - Danger/Delete Button
Destructive action button for delete, remove, or dangerous operations.

**Props:**
- Same as `<x-button>`

**Usage:**
```blade
<!-- Basic -->
<x-danger-button>Delete</x-danger-button>

<!-- With confirmation -->
<x-danger-button 
    wire:click="delete" 
    wire:confirm="Are you sure you want to delete this?"
>
    Delete User
</x-danger-button>

<!-- In confirmation modal -->
<x-confirmation-modal wire:model="confirmingDeletion">
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('confirmingDeletion', false)">
            Cancel
        </x-secondary-button>
        <x-danger-button wire:click="deleteUser">
            Delete User
        </x-danger-button>
    </x-slot>
</x-confirmation-modal>
```

### `<x-dark-button>` - Flexible Variant Button
Flexible button component with multiple variant options.

**Props:**
- `variant` (string): Button variant - 'primary', 'secondary', 'accent', 'ghost', 'link'
- `outline` (boolean): Use outline style
- `size` (string): Button size
- Other props same as `<x-button>`

**Usage:**
```blade
<!-- Different variants -->
<x-dark-button variant="primary">Primary</x-dark-button>
<x-dark-button variant="secondary">Secondary</x-dark-button>
<x-dark-button variant="accent">Accent</x-dark-button>
<x-dark-button variant="ghost">Ghost</x-dark-button>

<!-- Outlined -->
<x-dark-button variant="primary" outline>Outlined Primary</x-dark-button>
<x-dark-button variant="secondary" outline>Outlined Secondary</x-dark-button>

<!-- Combined with size -->
<x-dark-button variant="accent" size="lg">Large Accent</x-dark-button>
```

---

## Form Components

### `<x-form-control>` - Form Field Wrapper
Complete form field wrapper with label, input, and error handling.

**Props:**
- `label` (string): Field label text
- `for` (string): Input ID for label association
- `error` (string): Error message to display
- `required` (boolean): Show required indicator
- `help` (string): Help text below input

**Usage:**
```blade
<!-- Basic text input -->
<x-form-control label="Email Address" for="email" :error="$errors->first('email')">
    <x-input id="email" type="email" wire:model="email" />
</x-form-control>

<!-- With required indicator -->
<x-form-control label="Name" for="name" required :error="$errors->first('name')">
    <x-input id="name" type="text" wire:model="name" required />
</x-form-control>

<!-- With help text -->
<x-form-control 
    label="Password" 
    for="password" 
    help="Must be at least 8 characters"
    :error="$errors->first('password')"
>
    <x-input id="password" type="password" wire:model="password" />
</x-form-control>

<!-- With select -->
<x-form-control label="Role" for="role" :error="$errors->first('role')">
    <x-select id="role" wire:model="role">
        <option value="">Choose a role</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </x-select>
</x-form-control>

<!-- With textarea -->
<x-form-control label="Description" for="description">
    <x-textarea id="description" wire:model="description" rows="4" />
</x-form-control>
```

### `<x-input>` - Text Input
Standard text input field with daisyUI styling.

**Props:**
- `type` (string): Input type - 'text', 'email', 'password', 'number', etc.
- `error` (boolean): Show error state
- `disabled` (boolean): Disable input
- Standard HTML input attributes

**Usage:**
```blade
<!-- Basic -->
<x-input type="text" wire:model="name" />

<!-- With error state -->
<x-input type="email" wire:model="email" :error="$errors->has('email')" />

<!-- Different types -->
<x-input type="password" wire:model="password" />
<x-input type="number" wire:model="age" min="1" max="120" />
<x-input type="date" wire:model="birthdate" />

<!-- With placeholder -->
<x-input type="text" placeholder="Enter your name" wire:model="name" />

<!-- Disabled -->
<x-input type="text" wire:model="locked_field" disabled />

<!-- With Livewire modifiers -->
<x-input type="text" wire:model.defer="name" />
<x-input type="text" wire:model.lazy="search" />
<x-input type="text" wire:model.debounce.500ms="query" />
```

### `<x-select>` - Select Dropdown
Dropdown select input with daisyUI styling.

**Props:**
- `error` (boolean): Show error state
- `disabled` (boolean): Disable select
- Standard HTML select attributes

**Usage:**
```blade
<!-- Basic -->
<x-select wire:model="category">
    <option value="">Select a category</option>
    <option value="1">Category 1</option>
    <option value="2">Category 2</option>
</x-select>

<!-- With default selected -->
<x-select wire:model="status">
    <option disabled selected>Choose status</option>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
</x-select>

<!-- With optgroups -->
<x-select wire:model="location">
    <optgroup label="North America">
        <option value="us">United States</option>
        <option value="ca">Canada</option>
    </optgroup>
    <optgroup label="Europe">
        <option value="uk">United Kingdom</option>
        <option value="fr">France</option>
    </optgroup>
</x-select>

<!-- Dynamic options -->
<x-select wire:model="user_id">
    <option value="">Select a user</option>
    @foreach($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</x-select>
```

### `<x-textarea>` - Textarea
Multi-line text input with daisyUI styling.

**Props:**
- `rows` (integer): Number of visible rows (default: 3)
- `error` (boolean): Show error state
- `disabled` (boolean): Disable textarea
- Standard HTML textarea attributes

**Usage:**
```blade
<!-- Basic -->
<x-textarea wire:model="description" />

<!-- With specific rows -->
<x-textarea wire:model="bio" rows="6" />

<!-- With placeholder -->
<x-textarea 
    wire:model="comments" 
    placeholder="Enter your comments here..."
    rows="4"
/>

<!-- With character limit -->
<x-textarea 
    wire:model="message" 
    maxlength="500"
    rows="5"
/>

<!-- Read-only -->
<x-textarea :value="$log_content" readonly rows="10" />
```

### `<x-checkbox>` - Checkbox
Checkbox input with daisyUI styling.

**Props:**
- `checked` (boolean): Checked state
- `disabled` (boolean): Disable checkbox
- Standard HTML checkbox attributes

**Usage:**
```blade
<!-- Basic -->
<x-checkbox wire:model="agree_terms" />

<!-- With label -->
<label class="label cursor-pointer">
    <span class="label-text">I agree to the terms</span>
    <x-checkbox wire:model="agree_terms" />
</label>

<!-- Checked by default -->
<x-checkbox wire:model="subscribe_newsletter" checked />

<!-- In a list -->
@foreach($permissions as $permission)
    <label class="label cursor-pointer justify-start gap-2">
        <x-checkbox wire:model="selected_permissions.{{ $permission->id }}" />
        <span class="label-text">{{ $permission->name }}</span>
    </label>
@endforeach
```

### `<x-radio>` - Radio Button
Radio button input with daisyUI styling.

**Props:**
- `name` (string): Radio group name
- `value` (string): Radio value
- `checked` (boolean): Checked state
- Standard HTML radio attributes

**Usage:**
```blade
<!-- Radio group -->
<div class="form-control">
    <label class="label cursor-pointer">
        <span class="label-text">Option 1</span>
        <x-radio name="option" value="1" wire:model="selected_option" />
    </label>
    <label class="label cursor-pointer">
        <span class="label-text">Option 2</span>
        <x-radio name="option" value="2" wire:model="selected_option" />
    </label>
    <label class="label cursor-pointer">
        <span class="label-text">Option 3</span>
        <x-radio name="option" value="3" wire:model="selected_option" />
    </label>
</div>

<!-- Inline radio group -->
<div class="flex gap-4">
    <label class="label cursor-pointer gap-2">
        <x-radio name="size" value="small" wire:model="size" />
        <span class="label-text">Small</span>
    </label>
    <label class="label cursor-pointer gap-2">
        <x-radio name="size" value="medium" wire:model="size" />
        <span class="label-text">Medium</span>
    </label>
    <label class="label cursor-pointer gap-2">
        <x-radio name="size" value="large" wire:model="size" />
        <span class="label-text">Large</span>
    </label>
</div>
```

### `<x-toggle>` - Toggle Switch
Toggle switch for boolean values with daisyUI styling.

**Props:**
- `size` (string): Toggle size - 'xs', 'sm', 'md', 'lg'
- `checked` (boolean): Checked state
- `disabled` (boolean): Disable toggle
- Standard HTML checkbox attributes

**Usage:**
```blade
<!-- Basic -->
<x-toggle wire:model="notifications_enabled" />

<!-- With label -->
<label class="label cursor-pointer">
    <span class="label-text">Enable notifications</span>
    <x-toggle wire:model="notifications_enabled" />
</label>

<!-- Different sizes -->
<x-toggle wire:model="setting1" size="xs" />
<x-toggle wire:model="setting2" size="sm" />
<x-toggle wire:model="setting3" size="md" />
<x-toggle wire:model="setting4" size="lg" />

<!-- Settings list -->
<div class="space-y-4">
    <label class="label cursor-pointer">
        <span class="label-text">
            <div>Email Notifications</div>
            <div class="text-sm opacity-70">Receive email updates</div>
        </span>
        <x-toggle wire:model="email_notifications" />
    </label>
    <label class="label cursor-pointer">
        <span class="label-text">
            <div>SMS Notifications</div>
            <div class="text-sm opacity-70">Receive text messages</div>
        </span>
        <x-toggle wire:model="sms_notifications" />
    </label>
</div>
```

### `<x-label>` - Form Label
Label component for form fields.

**Props:**
- `for` (string): Associated input ID
- `value` (string): Label text
- `required` (boolean): Show required indicator

**Usage:**
```blade
<!-- Basic -->
<x-label for="email" value="Email Address" />

<!-- With required indicator -->
<x-label for="name" value="Name" required />

<!-- With slot content -->
<x-label for="password">
    Password <span class="text-xs opacity-70">(min 8 characters)</span>
</x-label>
```

### `<x-input-error>` - Input Error Message
Error message display for form validation.

**Props:**
- `for` (string): Field name
- `messages` (array|string): Error messages

**Usage:**
```blade
<!-- Basic -->
<x-input-error for="email" :messages="$errors->get('email')" />

<!-- After input -->
<x-input type="email" wire:model="email" />
<x-input-error for="email" :messages="$errors->get('email')" />

<!-- Custom message -->
<x-input-error for="custom_field">
    This field requires special formatting
</x-input-error>
```

---

## Modal Components

### `<x-modal>` - Base Modal
Base modal component with flexible content.

**Props:**
- `name` (string): Modal identifier for Alpine.js
- `show` (boolean): Show state for Livewire
- `maxWidth` (string): Maximum width - 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl', 'full'

**Usage:**
```blade
<!-- Basic with Livewire -->
<x-modal wire:model="showModal" maxWidth="2xl">
    <div class="p-6">
        <h2 class="text-lg font-bold">Modal Title</h2>
        <p class="mt-4">Modal content goes here...</p>
        <div class="mt-6 flex justify-end gap-2">
            <x-secondary-button wire:click="$set('showModal', false)">
                Cancel
            </x-secondary-button>
            <x-button wire:click="save">Save</x-button>
        </div>
    </div>
</x-modal>

<!-- With Alpine.js -->
<div x-data="{ open: false }">
    <x-button @click="open = true">Open Modal</x-button>
    
    <x-modal name="example-modal" :show="false" x-show="open">
        <div class="p-6">
            <h2 class="text-lg font-bold">Alpine Modal</h2>
            <p class="mt-4">Content here...</p>
            <div class="mt-6">
                <x-button @click="open = false">Close</x-button>
            </div>
        </div>
    </x-modal>
</div>
```

### `<x-dialog-modal>` - Structured Dialog Modal
Modal with predefined slots for title, content, and footer.

**Props:**
- Same as `<x-modal>`

**Slots:**
- `title`: Modal header/title
- `content`: Main content area
- `footer`: Action buttons area

**Usage:**
```blade
<!-- Create/Edit Modal -->
<x-dialog-modal wire:model="editingUser" maxWidth="2xl">
    <x-slot name="title">
        {{ $userId ? 'Edit User' : 'Create New User' }}
    </x-slot>
    
    <x-slot name="content">
        <div class="space-y-4">
            <x-form-control label="Name" for="name" :error="$errors->first('form.name')">
                <x-input id="name" wire:model="form.name" />
            </x-form-control>
            
            <x-form-control label="Email" for="email" :error="$errors->first('form.email')">
                <x-input id="email" type="email" wire:model="form.email" />
            </x-form-control>
            
            <x-form-control label="Role" for="role" :error="$errors->first('form.role')">
                <x-select id="role" wire:model="form.role">
                    <option value="">Select a role</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                </x-select>
            </x-form-control>
        </div>
    </x-slot>
    
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('editingUser', false)">
            Cancel
        </x-secondary-button>
        <x-button wire:click="saveUser" class="ml-2">
            {{ $userId ? 'Update' : 'Create' }}
        </x-button>
    </x-slot>
</x-dialog-modal>
```

### `<x-confirmation-modal>` - Confirmation Dialog
Modal specifically for confirmations with warning styling.

**Props:**
- Same as `<x-dialog-modal>`

**Usage:**
```blade
<!-- Delete Confirmation -->
<x-confirmation-modal wire:model="confirmingUserDeletion">
    <x-slot name="title">
        Delete User
    </x-slot>
    
    <x-slot name="content">
        <p>Are you sure you want to delete this user?</p>
        <p class="mt-2 text-sm opacity-70">
            This action cannot be undone. All of the user's data will be permanently removed.
        </p>
        
        <!-- Optional: Require typing confirmation -->
        <div class="mt-4">
            <x-form-control 
                label="Type 'DELETE' to confirm" 
                for="confirmation"
                :error="$errors->first('confirmation')"
            >
                <x-input 
                    id="confirmation" 
                    wire:model="confirmationText"
                    placeholder="DELETE"
                />
            </x-form-control>
        </div>
    </x-slot>
    
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('confirmingUserDeletion', false)">
            Cancel
        </x-secondary-button>
        <x-danger-button 
            wire:click="deleteUser" 
            class="ml-2"
            :disabled="$confirmationText !== 'DELETE'"
        >
            Delete User
        </x-danger-button>
    </x-slot>
</x-confirmation-modal>

<!-- Logout Confirmation -->
<x-confirmation-modal wire:model="confirmingLogout">
    <x-slot name="title">
        Logout Other Browser Sessions
    </x-slot>
    
    <x-slot name="content">
        <p>Please enter your password to confirm you would like to logout of your other browser sessions.</p>
        
        <div class="mt-4">
            <x-input 
                type="password" 
                wire:model="password"
                wire:keydown.enter="logoutOtherSessions"
                placeholder="Password"
                class="w-full"
            />
            <x-input-error for="password" :messages="$errors->get('password')" class="mt-2" />
        </div>
    </x-slot>
    
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('confirmingLogout', false)">
            Cancel
        </x-secondary-button>
        <x-button wire:click="logoutOtherSessions" class="ml-2">
            Logout Other Sessions
        </x-button>
    </x-slot>
</x-confirmation-modal>
```

### `<x-confirms-password>` - Password Confirmation Wrapper
Wrapper component that requires password confirmation before executing an action.

**Props:**
- `title` (string): Modal title
- `content` (string): Modal content
- `button` (string): Confirm button text

**Usage:**
```blade
<!-- Delete Account with Password Confirmation -->
<x-confirms-password wire:then="deleteAccount">
    <x-danger-button>
        Delete Account
    </x-danger-button>
</x-confirms-password>

<!-- Custom Title and Content -->
<div x-data @confirms-password="$wire.updateSecuritySettings()">
    <x-confirms-password 
        title="Confirm Password"
        content="For your security, please confirm your password to continue."
        button="Confirm"
    >
        <x-button>Update Security Settings</x-button>
    </x-confirms-password>
</div>
```

---

## Layout Components

### `<x-form-section>` - Form Section Card
Card-based form section with title and description.

**Props:**
- `submit` (string): Wire submit method

**Slots:**
- `title`: Section title
- `description`: Section description
- `form`: Form content
- `actions`: Form action buttons

**Usage:**
```blade
<x-form-section submit="updateProfile">
    <x-slot name="title">
        Profile Information
    </x-slot>
    
    <x-slot name="description">
        Update your account's profile information and email address.
    </x-slot>
    
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-form-control label="Name" for="name" :error="$errors->first('name')">
                <x-input id="name" type="text" wire:model="state.name" />
            </x-form-control>
        </div>
        
        <div class="col-span-6 sm:col-span-4">
            <x-form-control label="Email" for="email" :error="$errors->first('email')">
                <x-input id="email" type="email" wire:model="state.email" />
            </x-form-control>
        </div>
    </x-slot>
    
    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            Saved.
        </x-action-message>
        
        <x-button>Save</x-button>
    </x-slot>
</x-form-section>
```

### `<x-action-section>` - Action Section Card
Card section for displaying information with actions.

**Slots:**
- `title`: Section title
- `description`: Section description
- `content`: Main content area

**Usage:**
```blade
<x-action-section>
    <x-slot name="title">
        Delete Account
    </x-slot>
    
    <x-slot name="description">
        Permanently delete your account.
    </x-slot>
    
    <x-slot name="content">
        <div class="max-w-xl text-sm">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </div>
        
        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion">
                Delete Account
            </x-danger-button>
        </div>
    </x-slot>
</x-action-section>
```

### `<x-section-title>` - Section Header
Clean section header with title and aside content.

**Slots:**
- `title`: Main title
- `aside`: Optional aside content

**Usage:**
```blade
<!-- Basic -->
<x-section-title>
    <x-slot name="title">Team Members</x-slot>
    <x-slot name="aside">
        <x-button size="sm">Add Member</x-button>
    </x-slot>
</x-section-title>

<!-- With description -->
<x-section-title>
    <x-slot name="title">
        <h3 class="text-lg font-medium">API Tokens</h3>
        <p class="mt-1 text-sm opacity-70">
            Manage your API tokens for third-party integrations.
        </p>
    </x-slot>
</x-section-title>
```

### `<x-section-border>` - Section Divider
Horizontal divider between sections.

**Usage:**
```blade
<x-section-title>
    <x-slot name="title">Section 1</x-slot>
</x-section-title>

<x-section-border />

<x-section-title>
    <x-slot name="title">Section 2</x-slot>
</x-section-title>
```

---

## Alert Components

### `<x-validation-errors>` - Validation Error Summary
Displays all validation errors in an alert.

**Props:**
- `class` (string): Additional CSS classes

**Usage:**
```blade
<!-- At top of form -->
<x-validation-errors class="mb-4" />

<form wire:submit.prevent="save">
    <!-- Form fields -->
</form>

<!-- Custom implementation -->
@if ($errors->any())
    <x-validation-errors />
@endif
```

### `<x-action-message>` - Success Message
Temporary success message that auto-hides.

**Props:**
- `on` (string): Livewire event to listen for

**Usage:**
```blade
<!-- After save button -->
<div class="flex items-center gap-3">
    <x-button wire:click="save">Save</x-button>
    <x-action-message on="saved">
        Changes saved successfully!
    </x-action-message>
</div>

<!-- Multiple messages -->
<x-action-message on="profile-updated">
    Profile updated!
</x-action-message>

<x-action-message on="password-changed">
    Password changed successfully!
</x-action-message>

<!-- Custom duration -->
<x-action-message on="saved" x-data="{ timeout: 5000 }">
    Saved! This message will disappear in 5 seconds.
</x-action-message>
```

### `<x-banner>` - Banner Notification
Full-width banner for important notifications.

**Props:**
- `style` (string): Banner style - 'success', 'danger', 'warning', 'info'
- `message` (string): Banner message

**Usage:**
```blade
<!-- Session flash message -->
@if (session('flash.banner'))
    <x-banner 
        :style="session('flash.bannerStyle', 'success')"
        :message="session('flash.banner')"
    />
@endif

<!-- Static banner -->
<x-banner style="warning" message="System maintenance scheduled for tonight at 10 PM." />

<!-- With Livewire -->
@if ($showBanner)
    <x-banner 
        :style="$bannerStyle"
        :message="$bannerMessage"
        wire:click="dismissBanner"
    />
@endif
```

---

## Navigation Components

### `<x-nav-link>` - Navigation Link
Navigation link with active state detection.

**Props:**
- `href` (string): Link URL
- `active` (boolean): Active state
- `wire:navigate` (boolean): Use Livewire navigation

**Usage:**
```blade
<!-- In navigation menu -->
<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
    Dashboard
</x-nav-link>

<x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
    Users
</x-nav-link>

<!-- With Livewire navigation -->
<x-nav-link href="/profile" wire:navigate>
    Profile
</x-nav-link>

<!-- With icon -->
<x-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
    <svg class="w-4 h-4 mr-2">...</svg>
    Settings
</x-nav-link>
```

### `<x-responsive-nav-link>` - Mobile Navigation Link
Navigation link for mobile/responsive menu.

**Props:**
- Same as `<x-nav-link>`

**Usage:**
```blade
<!-- In mobile menu -->
<div class="drawer-side">
    <label for="drawer-toggle" class="drawer-overlay"></label>
    <ul class="menu p-4 w-80 bg-base-200">
        <li>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </li>
        <li>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                Users
            </x-responsive-nav-link>
        </li>
    </ul>
</div>
```

### `<x-dropdown>` - Dropdown Menu
Dropdown menu component with Alpine.js.

**Slots:**
- `trigger`: Dropdown trigger button
- `content`: Dropdown menu content

**Props:**
- `align` (string): Alignment - 'left', 'right', 'center'
- `width` (string): Width class

**Usage:**
```blade
<!-- User menu dropdown -->
<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button class="btn btn-ghost btn-circle">
            <img src="{{ auth()->user()->profile_photo_url }}" class="w-8 h-8 rounded-full">
        </button>
    </x-slot>
    
    <x-slot name="content">
        <x-dropdown-link :href="route('profile.show')">
            Profile
        </x-dropdown-link>
        
        <x-dropdown-link :href="route('settings')">
            Settings
        </x-dropdown-link>
        
        <div class="divider my-0"></div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </x-dropdown-link>
        </form>
    </x-slot>
</x-dropdown>

<!-- Actions dropdown -->
<x-dropdown>
    <x-slot name="trigger">
        <button class="btn btn-sm">
            Actions
            <svg class="w-4 h-4 ml-1">...</svg>
        </button>
    </x-slot>
    
    <x-slot name="content">
        <x-dropdown-link href="#" wire:click="edit">
            Edit
        </x-dropdown-link>
        
        <x-dropdown-link href="#" wire:click="duplicate">
            Duplicate
        </x-dropdown-link>
        
        <x-dropdown-link href="#" wire:click="confirmDelete" class="text-error">
            Delete
        </x-dropdown-link>
    </x-slot>
</x-dropdown>
```

---

## Utility Components

### `<x-application-logo>` - Application Logo
Displays the application logo.

**Props:**
- `class` (string): Additional CSS classes

**Usage:**
```blade
<!-- In navigation -->
<a href="{{ route('dashboard') }}">
    <x-application-logo class="w-10 h-10" />
</a>

<!-- In auth pages -->
<div class="flex justify-center mb-6">
    <x-application-logo class="w-20 h-20" />
</div>
```

### `<x-authentication-card>` - Auth Page Card
Card wrapper for authentication pages.

**Slots:**
- `logo`: Logo area
- Default slot: Card content

**Usage:**
```blade
<x-authentication-card>
    <x-slot name="logo">
        <x-authentication-card-logo />
    </x-slot>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <!-- Form fields -->
    </form>
</x-authentication-card>
```

### `<x-switchable-team>` - Team Switcher
Team switcher component for multi-team support.

**Props:**
- `team` (Team): Team model instance

**Usage:**
```blade
<!-- In team list -->
@foreach (Auth::user()->allTeams() as $team)
    <x-switchable-team :team="$team" />
@endforeach
```

---

## Complete Form Example

Here's a comprehensive example showing multiple components working together:

```blade
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" />
        
        <!-- Form Section -->
        <x-form-section submit="saveUser">
            <x-slot name="title">
                User Information
            </x-slot>
            
            <x-slot name="description">
                Provide the user's personal and account information.
            </x-slot>
            
            <x-slot name="form">
                <!-- Name Field -->
                <div class="col-span-6 sm:col-span-4">
                    <x-form-control label="Name" for="name" required :error="$errors->first('user.name')">
                        <x-input id="name" type="text" wire:model.defer="user.name" />
                    </x-form-control>
                </div>
                
                <!-- Email Field -->
                <div class="col-span-6 sm:col-span-4">
                    <x-form-control label="Email" for="email" required :error="$errors->first('user.email')">
                        <x-input id="email" type="email" wire:model.defer="user.email" />
                    </x-form-control>
                </div>
                
                <!-- Role Selection -->
                <div class="col-span-6 sm:col-span-4">
                    <x-form-control label="Role" for="role" :error="$errors->first('user.role')">
                        <x-select id="role" wire:model.defer="user.role">
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </x-select>
                    </x-form-control>
                </div>
                
                <!-- Bio Textarea -->
                <div class="col-span-6">
                    <x-form-control label="Bio" for="bio" help="Tell us about yourself">
                        <x-textarea id="bio" wire:model.defer="user.bio" rows="4" />
                    </x-form-control>
                </div>
                
                <!-- Notifications Toggle -->
                <div class="col-span-6 sm:col-span-4">
                    <label class="label cursor-pointer justify-start gap-4">
                        <x-toggle wire:model.defer="user.notifications_enabled" />
                        <span class="label-text">
                            <div>Email Notifications</div>
                            <div class="text-sm opacity-70">Receive email updates about your account</div>
                        </span>
                    </label>
                </div>
                
                <!-- Permissions Checkboxes -->
                <div class="col-span-6">
                    <label class="label">
                        <span class="label-text">Permissions</span>
                    </label>
                    <div class="space-y-2">
                        @foreach($permissions as $permission)
                            <label class="label cursor-pointer justify-start gap-2">
                                <x-checkbox wire:model.defer="user.permissions.{{ $permission->id }}" />
                                <span class="label-text">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </x-slot>
            
            <x-slot name="actions">
                <x-action-message class="mr-3" on="saved">
                    User saved successfully!
                </x-action-message>
                
                <x-secondary-button wire:click="cancel">
                    Cancel
                </x-secondary-button>
                
                <x-button wire:loading.attr="disabled">
                    <span wire:loading.remove>Save User</span>
                    <span wire:loading>
                        <span class="loading loading-spinner loading-sm"></span>
                        Saving...
                    </span>
                </x-button>
            </x-slot>
        </x-form-section>
        
        <!-- Section Divider -->
        <x-section-border />
        
        <!-- Danger Zone -->
        <x-action-section>
            <x-slot name="title">
                Danger Zone
            </x-slot>
            
            <x-slot name="description">
                Irreversible and destructive actions.
            </x-slot>
            
            <x-slot name="content">
                <div class="max-w-xl text-sm">
                    Once this user is deleted, all of their resources and data will be permanently deleted.
                </div>
                
                <div class="mt-5">
                    <x-danger-button wire:click="confirmUserDeletion">
                        Delete User
                    </x-danger-button>
                </div>
            </x-slot>
        </x-action-section>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<x-confirmation-modal wire:model="confirmingUserDeletion">
    <x-slot name="title">
        Delete User
    </x-slot>
    
    <x-slot name="content">
        Are you sure you want to delete this user? This action cannot be undone.
    </x-slot>
    
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('confirmingUserDeletion', false)">
            Cancel
        </x-secondary-button>
        
        <x-danger-button wire:click="deleteUser" class="ml-2">
            Delete User
        </x-danger-button>
    </x-slot>
</x-confirmation-modal>
```

---

## Best Practices

1. **Always use form-control wrapper** for form fields to ensure consistent spacing and error handling
2. **Include loading states** for all async operations
3. **Use semantic component names** - choose the right component for the job
4. **Test mobile responsiveness** - use responsive classes like `w-full sm:w-auto`
5. **Maintain dark theme consistency** - use `bg-base-*` classes instead of `bg-gray-*`
6. **Provide user feedback** - use action messages and loading indicators
7. **Handle errors gracefully** - always include error states and messages
8. **Use proper ARIA labels** for accessibility
9. **Keep modals focused** - one primary action per modal
10. **Reuse existing components** - don't create new ones if existing ones work

---

*This reference guide is part of the Lingo Client Tracker documentation. For more information, see the main documentation files.*

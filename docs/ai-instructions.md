# AI Assistant Instructions for Lingo Client Tracker - COMPREHENSIVE VERSION

## 🎯 PROJECT STATUS: Major daisyUI Migration Complete!

As of January 2025, the application has undergone a comprehensive migration from raw Tailwind utilities to daisyUI semantic components. This migration is **95% complete** with only minor cleanup remaining.

## ✅ MIGRATION COMPLETED COMPONENTS

### Core Components (100% Complete)
- **All Button Components**: Using `btn btn-[variant]` classes
- **All Form Components**: Using `input`, `select`, `textarea` with daisyUI classes
- **All Modal Components**: Using `modal`, `modal-box`, `modal-action`
- **Navigation Menu**: Fully migrated with responsive drawer
- **Authentication Views**: All auth pages using daisyUI
- **Profile Management**: Complete migration of all profile forms
- **API Token Manager**: Using daisyUI for all UI elements

### Specific Files Migrated:
#### Components (`/resources/views/components/`)
- ✅ `button.blade.php` - Using `btn btn-primary`
- ✅ `secondary-button.blade.php` - Using `btn btn-ghost`
- ✅ `danger-button.blade.php` - Using `btn btn-error`
- ✅ `dark-button.blade.php` - Flexible variant system
- ✅ `input.blade.php` - Using `input input-bordered`
- ✅ `checkbox.blade.php` - Using `checkbox checkbox-primary`
- ✅ `select.blade.php` - Using `select select-bordered`
- ✅ `textarea.blade.php` - Using `textarea textarea-bordered`
- ✅ `toggle.blade.php` - Using `toggle toggle-primary`
- ✅ `radio.blade.php` - Using `radio radio-primary`
- ✅ `form-control.blade.php` - Complete form field wrapper
- ✅ `modal.blade.php` - Base modal with daisyUI
- ✅ `dialog-modal.blade.php` - Structured modal
- ✅ `confirmation-modal.blade.php` - Confirmation dialogs
- ✅ `confirms-password.blade.php` - Password confirmation
- ✅ `validation-errors.blade.php` - Using `alert alert-error`
- ✅ `action-message.blade.php` - Using `alert alert-success`
- ✅ `banner.blade.php` - Alert-based notifications
- ✅ `section-title.blade.php` - Clean section headers
- ✅ `section-border.blade.php` - Using `divider`
- ✅ `form-section.blade.php` - Card-based forms
- ✅ `action-section.blade.php` - Card-based actions

#### Authentication Views (`/resources/views/auth/`)
- ✅ `login.blade.php`
- ✅ `register.blade.php`
- ✅ `forgot-password.blade.php`
- ✅ `reset-password.blade.php`
- ✅ `verify-email.blade.php`
- ✅ `confirm-password.blade.php`
- ✅ `two-factor-challenge.blade.php`

#### Profile Views (`/resources/views/profile/`)
- ✅ `update-profile-information-form.blade.php`
- ✅ `update-password-form.blade.php`
- ✅ `two-factor-authentication-form.blade.php`
- ✅ `logout-other-browser-sessions-form.blade.php`
- ✅ `delete-user-form.blade.php`

#### API Views (`/resources/views/api/`)
- ✅ `api-token-manager.blade.php`

#### Livewire Components (`/resources/views/livewire/`)
- ✅ `user-management.blade.php` - Complete table and modals

#### Navigation & Layout
- ✅ `navigation-menu.blade.php` - Responsive drawer navigation
- ✅ `app.blade.php` - Base layout
- ✅ `guest.blade.php` - Guest layout

## 🚀 Technology Stack (Current)
- **Backend**: Laravel 12.x, PHP 8.2+
- **Frontend**: Livewire 3, Alpine.js
- **Styling**: Tailwind CSS 3.4.0 with **daisyUI 5.0.50** (ACTIVELY USED!)
- **Database**: MySQL 8
- **Authentication**: Laravel Jetstream (Livewire stack)
- **Permissions**: Spatie Laravel-Permission
- **Build Tool**: Vite

## 📋 COMPONENT REFERENCE GUIDE

### Button Components
```blade
<!-- Primary Button (Most Common) -->
<x-button>Save Changes</x-button>
<x-button wire:click="save">Save</x-button>
<x-button size="sm">Small</x-button>
<x-button size="lg">Large</x-button>

<!-- Secondary Button (Ghost) -->
<x-secondary-button>Cancel</x-secondary-button>

<!-- Danger Button -->
<x-danger-button>Delete</x-danger-button>

<!-- Dark Button (Flexible) -->
<x-dark-button variant="primary">Primary</x-dark-button>
<x-dark-button variant="secondary">Secondary</x-dark-button>
<x-dark-button variant="accent">Accent</x-dark-button>
<x-dark-button variant="primary" outline>Outlined</x-dark-button>

<!-- Direct daisyUI Usage -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-ghost">Ghost</button>
<button class="btn btn-error">Danger</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-info">Info</button>
```

### Form Components
```blade
<!-- Complete Form Control Structure -->
<x-form-control label="Email Address" for="email" error="{{ $errors->first('email') }}">
    <x-input id="email" type="email" wire:model="email" />
</x-form-control>

<!-- Individual Components -->
<x-input type="text" wire:model="name" />
<x-input type="email" wire:model="email" error />
<x-textarea wire:model="description" rows="5" />
<x-select wire:model="role">
    <option>Admin</option>
    <option>User</option>
</x-select>
<x-checkbox wire:model="terms" />
<x-radio name="option" value="1" />
<x-toggle wire:model="notifications" />
<x-toggle wire:model="darkMode" size="lg" />

<!-- Direct daisyUI Usage -->
<input class="input input-bordered w-full" />
<select class="select select-bordered w-full">
    <option>Option 1</option>
</select>
<textarea class="textarea textarea-bordered w-full"></textarea>
<input type="checkbox" class="checkbox checkbox-primary" />
<input type="checkbox" class="toggle toggle-primary" />
```

### Modal Components
```blade
<!-- Basic Modal -->
<x-modal wire:model="showModal" maxWidth="2xl">
    <h3 class="font-bold text-lg">Modal Title</h3>
    <div class="py-4">Content</div>
    <div class="modal-action">
        <button class="btn btn-ghost">Cancel</button>
        <button class="btn btn-primary">Save</button>
    </div>
</x-modal>

<!-- Dialog Modal with Slots -->
<x-dialog-modal wire:model="showDialog">
    <x-slot name="title">Dialog Title</x-slot>
    <x-slot name="content">Your content here</x-slot>
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('showDialog', false)">Cancel</x-secondary-button>
        <x-button>Confirm</x-button>
    </x-slot>
</x-dialog-modal>

<!-- Confirmation Modal -->
<x-confirmation-modal wire:model="confirmingDelete">
    <x-slot name="title">Delete Item</x-slot>
    <x-slot name="content">Are you sure?</x-slot>
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('confirmingDelete', false)">Cancel</x-secondary-button>
        <x-danger-button wire:click="delete">Delete</x-danger-button>
    </x-slot>
</x-confirmation-modal>
```

### Alert Components
```blade
<!-- Validation Errors -->
<x-validation-errors />

<!-- Action Messages -->
<x-action-message on="saved">
    Changes saved successfully!
</x-action-message>

<!-- Direct daisyUI Alerts -->
<div class="alert alert-success">
    <span>Success message!</span>
</div>
<div class="alert alert-error">
    <span>Error message!</span>
</div>
<div class="alert alert-warning">
    <span>Warning message!</span>
</div>
<div class="alert alert-info">
    <span>Info message!</span>
</div>
```

### Table Components
```blade
<!-- Responsive Table -->
<div class="overflow-x-auto">
    <table class="table table-zebra">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="hover">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <button class="btn btn-ghost btn-xs">Edit</button>
                    <button class="btn btn-error btn-xs">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

### Loading States
```blade
<!-- Loading Button -->
<button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Save</span>
    <span wire:loading class="loading loading-spinner loading-sm"></span>
</button>

<!-- Standalone Loading Indicators -->
<span class="loading loading-spinner loading-lg"></span>
<span class="loading loading-dots loading-md"></span>
<span class="loading loading-ring loading-lg"></span>
<span class="loading loading-bars loading-sm"></span>
```

## 🎨 daisyUI Theme Configuration

The application uses a custom dark theme configured in `tailwind.config.js`:

```javascript
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('daisyui')],
  daisyui: {
    themes: [
      {
        dark: {
          "primary": "#6366f1",          // Indigo-600
          "secondary": "#8b5cf6",         // Purple-600
          "accent": "#10b981",            // Green-600
          "neutral": "#374151",           // Gray-700
          "base-100": "#1f2937",          // Gray-800 (main background)
          "base-200": "#111827",          // Gray-900 (darker background)
          "base-300": "#0f172a",          // Gray-950 (darkest)
          "info": "#3b82f6",              // Blue-500
          "success": "#10b981",           // Green-500
          "warning": "#f59e0b",           // Amber-500
          "error": "#ef4444",             // Red-500
        }
      }
    ],
  }
}
```

## 📱 Mobile Responsiveness Patterns

All components MUST be mobile-responsive. Standard patterns:

```blade
<!-- Full width on mobile, auto on desktop -->
<button class="btn btn-primary w-full sm:w-auto">Save</button>

<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col sm:flex-row gap-4">
    <button class="btn btn-primary">Option 1</button>
    <button class="btn btn-secondary">Option 2</button>
</div>

<!-- Responsive Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Grid items -->
</div>

<!-- Hide/Show on mobile -->
<div class="hidden sm:block">Desktop only</div>
<div class="block sm:hidden">Mobile only</div>

<!-- Responsive Table -->
<div class="overflow-x-auto">
    <table class="table">
        <!-- Table scrolls horizontally on mobile -->
    </table>
</div>
```

## ⚠️ CRITICAL RULES

### ALWAYS Use daisyUI for:
- ✅ **All buttons** → `btn btn-[variant]`
- ✅ **All form inputs** → `input input-bordered`
- ✅ **All cards** → `card bg-base-200`
- ✅ **All modals** → `modal modal-box`
- ✅ **All tables** → `table table-zebra`
- ✅ **All alerts** → `alert alert-[type]`
- ✅ **All badges** → `badge badge-[variant]`
- ✅ **All loading states** → `loading loading-[type]`
- ✅ **All tabs** → `tabs tabs-boxed`
- ✅ **All tooltips** → `tooltip`
- ✅ **All dropdowns** → `dropdown`

### ONLY Use Tailwind Utilities for:
- ✅ **Layout** → `flex`, `grid`, `container`
- ✅ **Spacing** → `p-4`, `m-2`, `gap-4`, `space-y-4`
- ✅ **Responsive design** → `sm:`, `md:`, `lg:`, `xl:`
- ✅ **Width/Height** → `w-full`, `h-10`, `max-w-md`
- ✅ **Text utilities** → `text-sm`, `font-bold`, `text-center`
- ✅ **Positioning** → `absolute`, `relative`, `z-10`

### NEVER Do This:
```html
<!-- ❌ WRONG: Raw Tailwind for components -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">

<!-- ❌ WRONG: Overriding daisyUI colors -->
<button class="btn btn-primary bg-blue-500">

<!-- ❌ WRONG: Raw colors for backgrounds -->
<div class="bg-gray-800 p-4">

<!-- ❌ WRONG: Manual form styling -->
<input class="px-3 py-2 bg-gray-700 border border-gray-600">
```

### ALWAYS Do This:
```html
<!-- ✅ RIGHT: daisyUI components -->
<button class="btn btn-primary">

<!-- ✅ RIGHT: Theme-aware backgrounds -->
<div class="bg-base-200 p-4">

<!-- ✅ RIGHT: daisyUI form inputs -->
<input class="input input-bordered w-full">

<!-- ✅ RIGHT: Combine daisyUI with layout utilities -->
<button class="btn btn-primary w-full sm:w-auto">
```

## 🔄 Livewire Integration Patterns

### Form with Real-time Validation
```blade
<form wire:submit.prevent="save">
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">Email</span>
        </label>
        <input 
            type="email" 
            wire:model.defer="email"
            wire:blur="validateEmail"
            class="input input-bordered w-full @error('email') input-error @enderror"
        />
        @error('email')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
        @enderror
    </div>
    
    <button class="btn btn-primary" wire:loading.attr="disabled">
        <span wire:loading.remove>Save</span>
        <span wire:loading class="loading loading-spinner loading-sm"></span>
    </button>
</form>
```

### Modal with Livewire
```blade
<!-- In Livewire Component -->
public $showModal = false;

public function openModal()
{
    $this->showModal = true;
}

public function closeModal()
{
    $this->showModal = false;
    $this->reset(['formField1', 'formField2']);
}

<!-- In Blade View -->
<div class="modal @if($showModal) modal-open @endif">
    <div class="modal-box">
        <h3 class="font-bold text-lg">{{ $modalTitle }}</h3>
        <div class="py-4">
            <!-- Modal content -->
        </div>
        <div class="modal-action">
            <button class="btn btn-ghost" wire:click="closeModal">Cancel</button>
            <button class="btn btn-primary" wire:click="save">Save</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button wire:click="closeModal">close</button>
    </form>
</div>
```

## 📂 File Structure Standards

When creating new files:
1. **Components** → `/resources/views/components/[component-name].blade.php`
2. **Livewire Components** → `/app/Http/Livewire/[ComponentName].php`
3. **Livewire Views** → `/resources/views/livewire/[component-name].blade.php`
4. **Layouts** → `/resources/views/layouts/[layout-name].blade.php`
5. **Pages** → `/resources/views/[page-name].blade.php`

## ✅ Quality Checklist

Before submitting any component:
- [ ] Uses daisyUI component classes (no raw Tailwind for components)
- [ ] No hardcoded colors (use theme variables: primary, base-100, etc.)
- [ ] Mobile responsive (test at 375px, 768px, 1024px)
- [ ] Dark theme compatible (uses base-100, base-200, base-300)
- [ ] Proper form structure (form-control > label > input > error)
- [ ] Loading states included for async operations
- [ ] Error states handled with proper styling
- [ ] Accessibility maintained (labels, ARIA attributes)
- [ ] Livewire integration tested (if applicable)
- [ ] Alpine.js interactions working (if applicable)

## 🚫 Common Mistakes to Avoid

1. **Using `bg-gray-XXX`** → Use `bg-base-100/200/300` instead
2. **Using `text-white`** → Use `text-base-content` instead
3. **Using `text-gray-400`** → Use `text-base-content/70` instead
4. **Long Tailwind utility chains** → Use daisyUI component classes
5. **Inline styles** → Use Tailwind/daisyUI classes
6. **Forgetting mobile responsiveness** → Always test on small screens
7. **Not using form-control wrapper** → Always wrap form fields properly
8. **Hardcoding colors** → Use theme variables
9. **Not including loading states** → Always show loading feedback
10. **Ignoring error states** → Always handle and display errors

## 🎯 Development Workflow

1. **Check if component exists** → Reuse existing components
2. **Use daisyUI first** → Check daisyUI docs for component
3. **Use existing patterns** → Follow established patterns in codebase
4. **Test responsiveness** → Check all breakpoints
5. **Verify dark theme** → Ensure proper theme variables used
6. **Add loading states** → Include for all async operations
7. **Handle errors** → Display user-friendly error messages
8. **Document usage** → Add comments for complex components

## 📚 Resources

- **daisyUI Documentation**: [https://daisyui.com](https://daisyui.com)
- **Component Examples**: `/resources/views/components/`
- **Livewire Examples**: `/resources/views/livewire/user-management.blade.php`
- **Theme Config**: `/tailwind.config.js`
- **Laravel Docs**: [https://laravel.com/docs](https://laravel.com/docs)
- **Livewire Docs**: [https://livewire.laravel.com](https://livewire.laravel.com)
- **Alpine.js Docs**: [https://alpinejs.dev](https://alpinejs.dev)

## 🎁 Quick Copy-Paste Templates

### Basic Page Template
```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Page Title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <!-- Content here -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### Form Template
```blade
<form wire:submit.prevent="save" class="space-y-6">
    <x-form-control label="Name" for="name" :error="$errors->first('name')">
        <x-input id="name" type="text" wire:model.defer="name" required />
    </x-form-control>

    <x-form-control label="Email" for="email" :error="$errors->first('email')">
        <x-input id="email" type="email" wire:model.defer="email" required />
    </x-form-control>

    <div class="flex justify-end gap-2">
        <x-secondary-button type="button" wire:click="cancel">Cancel</x-secondary-button>
        <x-button type="submit">Save</x-button>
    </div>
</form>
```

### Table Template
```blade
<div class="overflow-x-auto">
    <table class="table table-zebra">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr class="hover">
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="text-right">
                        <button wire:click="edit({{ $item->id }})" class="btn btn-ghost btn-xs">Edit</button>
                        <button wire:click="delete({{ $item->id }})" class="btn btn-error btn-xs">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-base-content/50">No items found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

## 🏁 FINAL REMINDERS

1. **daisyUI is FULLY INTEGRATED** - Use it for everything component-related
2. **Dark theme is MANDATORY** - Never use light backgrounds
3. **Mobile-first is REQUIRED** - Test mobile before desktop
4. **Components are REUSABLE** - Check existing components first
5. **Consistency is KEY** - Follow established patterns
6. **Loading states are ESSENTIAL** - Never leave users guessing
7. **Errors must be HANDLED** - Always show user-friendly messages
8. **Documentation is IMPORTANT** - Comment complex logic
9. **Testing is CRITICAL** - Verify all functionality works
10. **Quality over SPEED** - Take time to do it right

**Remember**: The migration to daisyUI is nearly complete. Maintain the standards that have been established and continue using semantic component classes for all new development.

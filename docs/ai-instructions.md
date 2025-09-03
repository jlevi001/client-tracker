# AI Assistant Instructions for Lingo Client Tracker - ENHANCED VERSION

## 🚨 CRITICAL: You Have daisyUI But Aren't Using It!

The application has daisyUI 5.0.50 installed but the code ignores it completely. **STOP writing raw Tailwind utilities for components!** Use daisyUI's semantic classes that are already available.

## Technology Stack (What's ACTUALLY Installed)
- **Backend**: Laravel 12.x, PHP 8.2+
- **Frontend**: Livewire 3, Alpine.js
- **Styling**: Tailwind CSS 3.4.0 with **daisyUI 5.0.50** ← USE THIS!
- **Database**: MySQL 8
- **Authentication**: Laravel Jetstream (Livewire stack)
- **Permissions**: Spatie Laravel-Permission
- **Build Tool**: Vite

## THE FUNDAMENTAL RULE

### ❌ STOP DOING THIS (Current Bad Practice):
```html
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 
               focus:outline-none focus:ring-2 focus:ring-indigo-500 
               focus:ring-offset-2 focus:ring-offset-gray-800 
               transition-colors duration-200">
```

### ✅ START DOING THIS (Use daisyUI):
```html
<button class="btn btn-primary">
```

## daisyUI Configuration

### 1. First, Update tailwind.config.js
```javascript
module.exports = {
  // ... existing config ...
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

## Component Standards Using daisyUI

### Buttons
```html
<!-- Primary Actions -->
<button class="btn btn-primary">Save</button>
<button class="btn btn-primary btn-sm">Small Button</button>
<button class="btn btn-primary btn-block">Full Width on Mobile</button>

<!-- Secondary Actions -->
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-ghost">Cancel</button>

<!-- Danger Actions -->
<button class="btn btn-error">Delete</button>

<!-- Success Actions -->
<button class="btn btn-success">Confirm</button>

<!-- Loading State -->
<button class="btn btn-primary loading">Processing...</button>

<!-- Disabled State -->
<button class="btn btn-primary" disabled>Disabled</button>

<!-- Icon Buttons -->
<button class="btn btn-circle btn-ghost">
  <svg class="w-5 h-5">...</svg>
</button>

<!-- Responsive Buttons -->
<button class="btn btn-primary w-full sm:w-auto">Mobile Full Width</button>
```

### Form Inputs
```html
<!-- Text Input -->
<input type="text" class="input input-bordered w-full" />

<!-- With Error State -->
<input type="text" class="input input-bordered input-error w-full" />

<!-- Select Dropdown -->
<select class="select select-bordered w-full">
  <option disabled selected>Select an option</option>
  <option>Option 1</option>
</select>

<!-- Textarea -->
<textarea class="textarea textarea-bordered w-full" rows="4"></textarea>

<!-- Checkbox -->
<input type="checkbox" class="checkbox checkbox-primary" />

<!-- Radio -->
<input type="radio" class="radio radio-primary" />

<!-- Toggle Switch -->
<input type="checkbox" class="toggle toggle-primary" />

<!-- Form Control with Label -->
<div class="form-control w-full">
  <label class="label">
    <span class="label-text">Email</span>
  </label>
  <input type="email" class="input input-bordered w-full" />
  <label class="label">
    <span class="label-text-alt text-error">Error message here</span>
  </label>
</div>
```

### Cards
```html
<!-- Basic Card -->
<div class="card bg-base-200 shadow-xl">
  <div class="card-body">
    <h2 class="card-title">Card Title</h2>
    <p>Card content goes here</p>
    <div class="card-actions justify-end">
      <button class="btn btn-primary">Action</button>
    </div>
  </div>
</div>

<!-- Compact Card -->
<div class="card bg-base-200 compact">
  <div class="card-body">
    <p>Compact spacing</p>
  </div>
</div>
```

### Tables
```html
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
      <tr>
        <td>John Doe</td>
        <td>john@example.com</td>
        <td>
          <button class="btn btn-ghost btn-xs">Edit</button>
        </td>
      </tr>
      <tr class="hover">
        <td>Jane Smith</td>
        <td>jane@example.com</td>
        <td>
          <button class="btn btn-ghost btn-xs">Edit</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- Compact Table -->
<table class="table table-compact w-full">
  ...
</table>
```

### Modals (Using daisyUI Modal)
```html
<!-- Modal Toggle -->
<label for="my-modal" class="btn btn-primary">Open Modal</label>

<!-- Modal Structure -->
<input type="checkbox" id="my-modal" class="modal-toggle" />
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Modal Title</h3>
    <p class="py-4">Modal content here</p>
    <div class="modal-action">
      <label for="my-modal" class="btn btn-ghost">Cancel</label>
      <button class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

<!-- For Livewire Modals -->
<div class="modal @if($showModal) modal-open @endif">
  <div class="modal-box">
    <!-- Content -->
  </div>
</div>
```

### Alerts
```html
<!-- Success Alert -->
<div class="alert alert-success">
  <span>Success message!</span>
</div>

<!-- Error Alert -->
<div class="alert alert-error">
  <span>Error message!</span>
</div>

<!-- Warning Alert -->
<div class="alert alert-warning">
  <span>Warning message!</span>
</div>

<!-- Info Alert -->
<div class="alert alert-info">
  <span>Info message!</span>
</div>

<!-- Alert with Icon -->
<div class="alert alert-success">
  <svg class="stroke-current shrink-0 h-6 w-6">...</svg>
  <span>Your purchase has been confirmed!</span>
</div>
```

### Loading States
```html
<!-- Loading Spinner -->
<span class="loading loading-spinner loading-lg"></span>

<!-- Loading Dots -->
<span class="loading loading-dots loading-md"></span>

<!-- Loading Ring -->
<span class="loading loading-ring loading-lg"></span>

<!-- Loading Button -->
<button class="btn btn-primary">
  <span class="loading loading-spinner"></span>
  Processing
</button>
```

### Badges
```html
<!-- Status Badges -->
<span class="badge badge-primary">Admin</span>
<span class="badge badge-secondary">Manager</span>
<span class="badge badge-success">Active</span>
<span class="badge badge-warning">Pending</span>
<span class="badge badge-error">Expired</span>

<!-- Outline Badges -->
<span class="badge badge-outline">Draft</span>

<!-- Size Variants -->
<span class="badge badge-lg">Large</span>
<span class="badge badge-sm">Small</span>
```

### Navigation
```html
<!-- Tabs -->
<div class="tabs tabs-boxed">
  <a class="tab tab-active">Tab 1</a>
  <a class="tab">Tab 2</a>
  <a class="tab">Tab 3</a>
</div>

<!-- Breadcrumbs -->
<div class="text-sm breadcrumbs">
  <ul>
    <li><a>Home</a></li>
    <li><a>Documents</a></li>
    <li>Add Document</li>
  </ul>
</div>

<!-- Pagination -->
<div class="btn-group">
  <button class="btn">«</button>
  <button class="btn">Page 1</button>
  <button class="btn btn-active">Page 2</button>
  <button class="btn">Page 3</button>
  <button class="btn">»</button>
</div>
```

## Responsive Design Patterns

### Mobile-First Approach with daisyUI
```html
<!-- Responsive Button -->
<button class="btn btn-primary btn-block sm:btn-wide">
  Full width on mobile, wide on desktop
</button>

<!-- Responsive Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  <div class="card bg-base-200">...</div>
  <div class="card bg-base-200">...</div>
  <div class="card bg-base-200">...</div>
</div>

<!-- Responsive Table (converts to cards on mobile) -->
<div class="overflow-x-auto">
  <table class="table w-full">
    <!-- Table content -->
  </table>
</div>

<!-- Stack on Mobile, Side-by-Side on Desktop -->
<div class="flex flex-col sm:flex-row gap-4">
  <button class="btn btn-primary">Button 1</button>
  <button class="btn btn-secondary">Button 2</button>
</div>
```

## Laravel Blade Component Integration

### Create Reusable Blade Components
```php
<!-- resources/views/components/button.blade.php -->
@props(['variant' => 'primary', 'size' => 'md'])

<button {{ $attributes->merge(['class' => "btn btn-{$variant} btn-{$size}"]) }}>
    {{ $slot }}
</button>

<!-- Usage -->
<x-button variant="primary" wire:click="save">Save Changes</x-button>
<x-button variant="error" size="sm" wire:click="delete">Delete</x-button>
```

### Dark Theme Blade Components (Already Exist)
```html
<!-- These components already exist - USE THEM! -->
<x-dark-label for="name" value="Name" />
<x-dark-input id="name" type="text" wire:model="name" />
<x-dark-select id="role" wire:model="role">
    <option>Option 1</option>
</x-dark-select>
```

## When to Use Tailwind Utilities vs daisyUI

### Use daisyUI for:
- ✅ All buttons (`btn btn-primary`)
- ✅ All form inputs (`input input-bordered`)
- ✅ Cards (`card`)
- ✅ Modals (`modal`)
- ✅ Tables (`table`)
- ✅ Alerts (`alert`)
- ✅ Badges (`badge`)
- ✅ Loading states (`loading`)
- ✅ Tabs (`tabs`)
- ✅ Any component that daisyUI provides

### Use Tailwind Utilities for:
- ✅ Layout (`flex`, `grid`, `space-y-4`)
- ✅ Spacing (`p-4`, `mt-6`, `gap-4`)
- ✅ Responsive design (`sm:`, `md:`, `lg:`)
- ✅ Width/Height (`w-full`, `h-10`, `max-w-md`)
- ✅ Text utilities not in daisyUI (`text-sm`, `font-bold`)
- ✅ Custom positioning (`absolute`, `relative`, `z-10`)

### NEVER Do This:
```html
<!-- WRONG: Using Tailwind for what daisyUI provides -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">

<!-- WRONG: Overriding daisyUI with inline Tailwind -->
<button class="btn btn-primary bg-blue-500 hover:bg-blue-600">

<!-- WRONG: Not using semantic daisyUI classes -->
<div class="p-4 bg-gray-800 rounded-lg border border-gray-700">
```

### ALWAYS Do This:
```html
<!-- RIGHT: Use daisyUI components -->
<button class="btn btn-primary">

<!-- RIGHT: Combine daisyUI with layout utilities -->
<button class="btn btn-primary w-full sm:w-auto">

<!-- RIGHT: Use semantic components -->
<div class="card bg-base-200">
```

## Migration Strategy for Existing Code

When updating existing components:

1. **Find all long Tailwind utility strings**
2. **Replace with daisyUI equivalents**
3. **Test responsiveness**
4. **Verify dark theme consistency**

### Example Migration:
```html
<!-- OLD CODE (Current) -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md 
               hover:bg-indigo-700 focus:outline-none focus:ring-2 
               focus:ring-indigo-500 focus:ring-offset-2 
               focus:ring-offset-gray-800 transition-colors duration-200">
    Save User
</button>

<!-- NEW CODE (Use daisyUI) -->
<button class="btn btn-primary">
    Save User
</button>
```

## File Output Requirements

When creating or modifying files:
1. **Location**: Always specify exact path (e.g., `/resources/views/livewire/component.blade.php`)
2. **Complete Files**: Always provide the ENTIRE file, never snippets
3. **Use daisyUI Classes**: Every component should use daisyUI semantic classes
4. **Mobile First**: Test all breakpoints mentally before outputting
5. **Dark Theme**: Use base-100, base-200, base-300 for backgrounds

## Quality Checklist for Every Component

Before outputting any code, verify:
- [ ] Uses daisyUI component classes (btn, card, input, etc.)
- [ ] No raw color utilities (no bg-gray-800, use bg-base-200)
- [ ] Mobile responsive (w-full sm:w-auto patterns)
- [ ] Consistent spacing (using gap-4, space-y-4)
- [ ] Proper form structure (form-control > label > input)
- [ ] Loading states included where needed
- [ ] Error states handled properly
- [ ] Accessibility maintained (proper labels, ARIA)

## Common Livewire + daisyUI Patterns

### Modal with Livewire
```html
<div class="modal @if($showModal) modal-open @endif">
    <div class="modal-box">
        <h3 class="font-bold text-lg">{{ $modalTitle }}</h3>
        <div class="py-4">
            <!-- Content -->
        </div>
        <div class="modal-action">
            <button class="btn btn-ghost" wire:click="$set('showModal', false)">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="save">
                Save
            </button>
        </div>
    </div>
</div>
```

### Form with Validation
```html
<div class="form-control w-full">
    <label class="label">
        <span class="label-text">Email</span>
    </label>
    <input type="email" 
           wire:model="email" 
           class="input input-bordered w-full @error('email') input-error @enderror" />
    @error('email')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
```

### Loading Button
```html
<button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Save</span>
    <span wire:loading>
        <span class="loading loading-spinner loading-sm"></span>
        Saving...
    </span>
</button>
```

## CRITICAL REMINDERS

1. **daisyUI is INSTALLED** - Version 5.0.50 is in package.json
2. **STOP writing raw Tailwind for components** - Use daisyUI classes
3. **The dark theme should use daisyUI theme colors** - Configure in tailwind.config.js
4. **Every button should be `btn btn-[variant]`** - No more px-4 py-2...
5. **Every input should be `input input-bordered`** - No more manual styling
6. **Every card should be `card bg-base-200`** - Consistent backgrounds
7. **Test mentally for mobile** - btn-block on mobile, btn-wide on desktop
8. **Read the daisyUI docs** - https://daisyui.com/components/

## Your Mission

Transform this application from a mess of Tailwind utilities into a clean, consistent, maintainable codebase using daisyUI's semantic component classes. Every component you create or modify should demonstrate the power of semantic CSS with daisyUI while maintaining full mobile responsiveness and dark theme consistency.

**Remember**: The user installed daisyUI for exactly this reason - to have consistent, semantic components. Stop ignoring it and start using it properly!
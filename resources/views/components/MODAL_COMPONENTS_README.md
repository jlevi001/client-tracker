# Modal Components with daisyUI

## Overview

All modal components have been rewritten to use daisyUI's semantic component classes instead of raw Tailwind utilities. This provides:

- ✅ **Cleaner, more maintainable code**
- ✅ **Consistent dark theme support**
- ✅ **Mobile-responsive by default**
- ✅ **Reduced CSS bundle size**
- ✅ **Semantic class names**

## Modal Components

### 1. Base Modal Component (`modal.blade.php`)

The foundation for all modal variations.

```blade
<x-modal wire:model="showModal" maxWidth="2xl">
    <h3 class="font-bold text-lg">Modal Title</h3>
    <div class="py-4">
        Your content here...
    </div>
    <div class="modal-action">
        <button class="btn btn-ghost">Cancel</button>
        <button class="btn btn-primary">Save</button>
    </div>
</x-modal>
```

**Available Sizes:**
- `sm` - Small modal (max-w-sm)
- `md` - Medium modal (max-w-md)
- `lg` - Large modal (max-w-lg)
- `xl` - Extra large (max-w-xl)
- `2xl` - 2X large (max-w-2xl) [default]
- `3xl` to `7xl` - Larger sizes
- `full` - Full width (max-w-full)

### 2. Dialog Modal (`dialog-modal.blade.php`)

Structured modal with named slots for title, content, and footer.

```blade
<x-dialog-modal wire:model="showDialog" maxWidth="lg">
    <x-slot name="title">
        Dialog Title
    </x-slot>
    
    <x-slot name="content">
        Your content here...
    </x-slot>
    
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('showDialog', false)">
            Cancel
        </x-secondary-button>
        <x-button class="ms-2">
            Confirm
        </x-button>
    </x-slot>
</x-dialog-modal>
```

### 3. Confirmation Modal (`confirmation-modal.blade.php`)

Modal with warning icon for destructive actions.

```blade
<x-confirmation-modal wire:model="confirmingDelete">
    <x-slot name="title">
        Delete Item
    </x-slot>
    
    <x-slot name="content">
        Are you sure you want to delete this item? This action cannot be undone.
    </x-slot>
    
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('confirmingDelete', false)">
            Cancel
        </x-secondary-button>
        <x-danger-button wire:click="delete">
            Delete
        </x-danger-button>
    </x-slot>
</x-confirmation-modal>
```

### 4. Password Confirmation (`confirms-password.blade.php`)

Wrapper component for actions requiring password confirmation.

```blade
<x-confirms-password wire:then="deleteAccount">
    <x-danger-button>
        Delete Account
    </x-danger-button>
</x-confirms-password>
```

## Button Components (Updated)

All button components now use daisyUI classes:

### Primary Button
```blade
<x-button>Save Changes</x-button>
<x-button size="sm">Small Button</x-button>
<x-button size="lg">Large Button</x-button>
```

### Secondary Button (Ghost)
```blade
<x-secondary-button>Cancel</x-secondary-button>
```

### Danger Button
```blade
<x-danger-button>Delete</x-danger-button>
```

### Dark Button (Flexible Variant)
```blade
<x-dark-button variant="primary">Primary</x-dark-button>
<x-dark-button variant="secondary">Secondary</x-dark-button>
<x-dark-button variant="accent">Accent</x-dark-button>
<x-dark-button variant="primary" outline>Outlined</x-dark-button>
```

## Form Components (Updated)

All form components use daisyUI classes:

### Input
```blade
<x-input type="text" wire:model="name" />
<x-input type="email" wire:model="email" error />
```

### Select
```blade
<x-select wire:model="role">
    <option>Admin</option>
    <option>User</option>
</x-select>
```

### Textarea
```blade
<x-textarea wire:model="description" rows="5" />
```

### Checkbox
```blade
<x-checkbox wire:model="terms" />
```

### Radio
```blade
<x-radio name="option" value="1" />
```

### Toggle
```blade
<x-toggle wire:model="notifications" />
<x-toggle wire:model="darkMode" size="lg" />
```

### Form Control (Complete Structure)
```blade
<x-form-control label="Email Address" for="email" error="{{ $errors->first('email') }}">
    <x-input id="email" type="email" wire:model="email" />
</x-form-control>
```

## Loading States

### Button with Loading
```blade
<button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Save</span>
    <span wire:loading class="loading loading-spinner loading-sm"></span>
</button>
```

### Loading Indicators
```blade
<span class="loading loading-spinner loading-lg"></span>
<span class="loading loading-dots loading-md"></span>
<span class="loading loading-ring loading-lg"></span>
<span class="loading loading-bars loading-sm"></span>
```

## Alert Components

### Validation Errors
```blade
<x-validation-errors />
```

### Action Messages
```blade
<x-action-message on="saved">
    Changes saved successfully!
</x-action-message>
```

## daisyUI Classes Used

### Core Modal Classes
- `modal` - Modal container
- `modal-open` - Shows the modal
- `modal-backdrop` - Background overlay
- `modal-box` - Modal content container
- `modal-action` - Footer actions container

### Button Classes
- `btn` - Base button class
- `btn-primary` - Primary button
- `btn-secondary` - Secondary button
- `btn-accent` - Accent button
- `btn-ghost` - Ghost button (minimal style)
- `btn-error` - Danger/delete button
- `btn-outline` - Outlined button variant
- `btn-sm`, `btn-lg` - Size variants

### Form Classes
- `input` - Base input class
- `input-bordered` - Bordered input
- `input-error` - Error state
- `select` - Base select class
- `select-bordered` - Bordered select
- `textarea` - Base textarea class
- `checkbox` - Checkbox styling
- `radio` - Radio button styling
- `toggle` - Toggle switch styling
- `form-control` - Form field wrapper
- `label` - Label container
- `label-text` - Label text
- `label-text-alt` - Helper/error text

### Utility Classes
- `alert` - Alert container
- `alert-success`, `alert-error`, `alert-warning` - Alert variants
- `loading` - Loading indicator base
- `loading-spinner`, `loading-dots`, `loading-ring` - Loading styles
- `card` - Card container
- `card-body` - Card content
- `divider` - Section divider

## Color System

The application uses daisyUI's theme variables:
- `base-100` - Main background (Gray-800)
- `base-200` - Card background (Gray-900)
- `base-300` - Darkest background (Gray-950)
- `base-content` - Main text color
- `primary`, `secondary`, `accent` - Theme colors
- `success`, `error`, `warning`, `info` - Status colors

## Responsive Design

All components are mobile-first:
- Buttons are full-width on mobile (`w-full sm:w-auto`)
- Modals adapt to screen size
- Forms stack properly on small screens
- Tables become scrollable on mobile

## Migration from Raw Tailwind

### Before (Raw Tailwind):
```html
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md 
               hover:bg-indigo-700 focus:outline-none focus:ring-2 
               focus:ring-indigo-500 focus:ring-offset-2 
               focus:ring-offset-gray-800 transition-colors duration-200">
```

### After (daisyUI):
```html
<button class="btn btn-primary">
```

## Best Practices

1. **Always use semantic daisyUI classes** for components
2. **Only use Tailwind utilities** for layout and spacing
3. **Never override daisyUI colors** with Tailwind color utilities
4. **Test on mobile devices** to ensure responsiveness
5. **Use the form-control wrapper** for consistent form fields
6. **Leverage loading states** for better UX
7. **Keep modals focused** - one primary action per modal

## Examples Page

View working examples at: `/resources/views/components/modal-examples.blade.php`

This file contains live examples of all modal variations, sizes, and states.
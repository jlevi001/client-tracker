# daisyUI Conversion Guide - Complete Reference

## 📋 Table of Contents
1. [Quick Reference](#quick-reference)
2. [Component Conversions](#component-conversions)
3. [Color System](#color-system)
4. [Responsive Patterns](#responsive-patterns)
5. [Livewire Integration](#livewire-integration)
6. [Migration Checklist](#migration-checklist)
7. [Common Pitfalls](#common-pitfalls)

## Quick Reference

### Most Common Conversions
| Component | Raw Tailwind | daisyUI | Notes |
|-----------|-------------|---------|-------|
| **Primary Button** | `px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700` | `btn btn-primary` | Includes all states |
| **Input Field** | `px-3 py-2 bg-gray-700 border border-gray-600 rounded-md` | `input input-bordered` | Add `w-full` for width |
| **Card** | `bg-gray-800 rounded-lg shadow-lg p-6` | `card bg-base-200` + `card-body` | Nested structure |
| **Alert** | `bg-green-900 border-l-4 border-green-500 p-4` | `alert alert-success` | Semantic variants |
| **Table** | `min-w-full divide-y divide-gray-700` | `table table-zebra` | Auto-styling |

## Component Conversions

### Buttons

```html
<!-- ❌ OLD: Primary Button -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md 
               hover:bg-indigo-700 focus:outline-none focus:ring-2 
               focus:ring-indigo-500 focus:ring-offset-2 
               focus:ring-offset-gray-800 transition-colors duration-200">
    Save Changes
</button>

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-primary">
    Save Changes
</button>

<!-- ❌ OLD: Secondary Button -->
<button class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md 
               hover:bg-gray-600 focus:outline-none focus:ring-2 
               focus:ring-gray-500">
    Cancel
</button>

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-ghost">
    Cancel
</button>

<!-- ❌ OLD: Danger Button -->
<button class="px-4 py-2 bg-red-600 text-white rounded-md 
               hover:bg-red-700 focus:outline-none focus:ring-2 
               focus:ring-red-500">
    Delete
</button>

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-error">
    Delete
</button>

<!-- ❌ OLD: Icon Button -->
<button class="p-2 rounded-full bg-gray-700 hover:bg-gray-600 
               focus:outline-none focus:ring-2 focus:ring-gray-500">
    <svg class="w-5 h-5">...</svg>
</button>

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-circle btn-ghost">
    <svg class="w-5 h-5">...</svg>
</button>

<!-- ❌ OLD: Loading Button -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md 
               opacity-50 cursor-not-allowed" disabled>
    <svg class="animate-spin h-5 w-5 mr-3 inline">...</svg>
    Processing...
</button>

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-primary" disabled>
    <span class="loading loading-spinner"></span>
    Processing...
</button>

<!-- Button Sizes -->
<button class="btn btn-primary btn-xs">Extra Small</button>
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Normal</button>
<button class="btn btn-primary btn-lg">Large</button>

<!-- Button Variants -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-accent">Accent</button>
<button class="btn btn-ghost">Ghost</button>
<button class="btn btn-link">Link</button>
<button class="btn btn-outline btn-primary">Outlined</button>
<button class="btn btn-wide">Wide</button>
<button class="btn btn-block">Full Width</button>
```

### Form Inputs

```html
<!-- ❌ OLD: Text Input -->
<input type="text" 
       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 
              rounded-md text-white placeholder-gray-400 
              focus:bg-gray-600 focus:border-indigo-500 
              focus:ring-1 focus:ring-indigo-500">

<!-- ✅ NEW: daisyUI -->
<input type="text" class="input input-bordered w-full">

<!-- ❌ OLD: Input with Label and Error -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-300 mb-1">
        Email Address
    </label>
    <input type="email" 
           class="w-full px-3 py-2 bg-gray-700 border border-red-500 
                  rounded-md text-white">
    <p class="mt-1 text-sm text-red-500">Please enter a valid email</p>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="form-control w-full">
    <label class="label">
        <span class="label-text">Email Address</span>
    </label>
    <input type="email" class="input input-bordered input-error w-full">
    <label class="label">
        <span class="label-text-alt text-error">Please enter a valid email</span>
    </label>
</div>

<!-- ❌ OLD: Select Dropdown -->
<select class="w-full px-3 py-2 bg-gray-700 border border-gray-600 
               rounded-md text-white focus:border-indigo-500">
    <option>Option 1</option>
    <option>Option 2</option>
</select>

<!-- ✅ NEW: daisyUI -->
<select class="select select-bordered w-full">
    <option disabled selected>Choose an option</option>
    <option>Option 1</option>
    <option>Option 2</option>
</select>

<!-- ❌ OLD: Textarea -->
<textarea class="w-full px-3 py-2 bg-gray-700 border border-gray-600 
                 rounded-md text-white placeholder-gray-400 
                 focus:border-indigo-500" rows="4"></textarea>

<!-- ✅ NEW: daisyUI -->
<textarea class="textarea textarea-bordered w-full" rows="4"></textarea>

<!-- ❌ OLD: Checkbox -->
<input type="checkbox" 
       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 
              bg-gray-700 border-gray-600 rounded">

<!-- ✅ NEW: daisyUI -->
<input type="checkbox" class="checkbox checkbox-primary">

<!-- ❌ OLD: Radio Button -->
<input type="radio" 
       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 
              bg-gray-700 border-gray-600">

<!-- ✅ NEW: daisyUI -->
<input type="radio" class="radio radio-primary">

<!-- ❌ OLD: Toggle Switch -->
<button type="button" 
        class="relative inline-flex h-6 w-11 items-center 
               rounded-full bg-gray-700 transition-colors 
               focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <span class="inline-block h-4 w-4 transform rounded-full 
                 bg-white transition-transform translate-x-1"></span>
</button>

<!-- ✅ NEW: daisyUI -->
<input type="checkbox" class="toggle toggle-primary">

<!-- Input Sizes -->
<input class="input input-bordered input-xs w-full max-w-xs" />
<input class="input input-bordered input-sm w-full max-w-xs" />
<input class="input input-bordered input-md w-full max-w-xs" />
<input class="input input-bordered input-lg w-full max-w-xs" />
```

### Cards & Containers

```html
<!-- ❌ OLD: Basic Card -->
<div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
    <h3 class="text-lg font-semibold text-white mb-2">Card Title</h3>
    <p class="text-gray-300">Card content goes here</p>
    <div class="mt-4 flex justify-end space-x-2">
        <button class="px-4 py-2 bg-gray-700 text-white rounded">Cancel</button>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
    </div>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="card bg-base-200 shadow-xl">
    <div class="card-body">
        <h2 class="card-title">Card Title</h2>
        <p>Card content goes here</p>
        <div class="card-actions justify-end">
            <button class="btn btn-ghost">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</div>

<!-- ❌ OLD: Card with Image -->
<div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
    <img src="..." class="w-full h-48 object-cover">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-white">Title</h3>
        <p class="text-gray-300 mt-2">Description</p>
    </div>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="card bg-base-200 shadow-xl">
    <figure><img src="..." alt="Image" /></figure>
    <div class="card-body">
        <h2 class="card-title">Title</h2>
        <p>Description</p>
    </div>
</div>

<!-- Compact Card -->
<div class="card bg-base-200 compact">
    <div class="card-body">
        <p>Less padding</p>
    </div>
</div>

<!-- Side Image Card -->
<div class="card card-side bg-base-200 shadow-xl">
    <figure><img src="..." /></figure>
    <div class="card-body">
        <h2 class="card-title">Title</h2>
        <p>Content</p>
    </div>
</div>
```

### Tables

```html
<!-- ❌ OLD: Data Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium 
                           text-gray-300 uppercase tracking-wider">
                    Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium 
                           text-gray-300 uppercase tracking-wider">
                    Email
                </th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700">
            <tr class="hover:bg-gray-800">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                    John Doe
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                    john@example.com
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="overflow-x-auto">
    <table class="table table-zebra">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover">
                <td>John Doe</td>
                <td>john@example.com</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Table Variants -->
<table class="table">Default</table>
<table class="table table-zebra">Zebra Striped</table>
<table class="table table-compact">Compact</table>
<table class="table table-fixed">Fixed Layout</table>
```

### Modals

```html
<!-- ❌ OLD: Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto" x-show="showModal">
    <div class="flex min-h-screen items-center justify-center">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="relative bg-gray-800 rounded-lg p-6 max-w-lg w-full">
            <h3 class="text-lg font-semibold text-white">Modal Title</h3>
            <div class="mt-4 text-gray-300">Content</div>
            <div class="mt-6 flex justify-end space-x-2">
                <button class="px-4 py-2 bg-gray-700 text-white rounded">
                    Cancel
                </button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ NEW: daisyUI (with Livewire) -->
<div class="modal @if($showModal) modal-open @endif">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Modal Title</h3>
        <div class="py-4">Content</div>
        <div class="modal-action">
            <button class="btn btn-ghost" wire:click="$set('showModal', false)">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="save">
                Save
            </button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button wire:click="$set('showModal', false)">close</button>
    </form>
</div>

<!-- ✅ NEW: daisyUI (with Alpine.js) -->
<div x-data="{ open: false }">
    <button @click="open = true" class="btn btn-primary">Open Modal</button>
    
    <div class="modal" :class="open && 'modal-open'">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Modal Title</h3>
            <div class="py-4">Content</div>
            <div class="modal-action">
                <button class="btn btn-ghost" @click="open = false">Cancel</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button @click="open = false">close</button>
        </form>
    </div>
</div>
```

### Alerts & Notifications

```html
<!-- ❌ OLD: Success Alert -->
<div class="bg-green-900 border-l-4 border-green-500 text-green-200 p-4 rounded">
    <p class="font-bold">Success!</p>
    <p>Your changes have been saved.</p>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="alert alert-success">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>Your changes have been saved.</span>
</div>

<!-- ❌ OLD: Error Alert -->
<div class="bg-red-900 border-l-4 border-red-500 text-red-200 p-4 rounded">
    <p class="font-bold">Error!</p>
    <p>Something went wrong.</p>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="alert alert-error">
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>Something went wrong.</span>
</div>

<!-- Alert Variants -->
<div class="alert">Default</div>
<div class="alert alert-info">Info</div>
<div class="alert alert-success">Success</div>
<div class="alert alert-warning">Warning</div>
<div class="alert alert-error">Error</div>
```

### Badges & Tags

```html
<!-- ❌ OLD: Status Badge -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full 
             text-xs font-medium bg-green-900 text-green-200">
    Active
</span>

<!-- ✅ NEW: daisyUI -->
<span class="badge badge-success">Active</span>

<!-- ❌ OLD: Role Badge -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full 
             text-xs font-medium bg-indigo-900 text-indigo-200">
    Admin
</span>

<!-- ✅ NEW: daisyUI -->
<span class="badge badge-primary">Admin</span>

<!-- Badge Variants -->
<span class="badge">Default</span>
<span class="badge badge-primary">Primary</span>
<span class="badge badge-secondary">Secondary</span>
<span class="badge badge-accent">Accent</span>
<span class="badge badge-ghost">Ghost</span>
<span class="badge badge-info">Info</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-error">Error</span>
<span class="badge badge-outline">Outline</span>
<span class="badge badge-lg">Large</span>
<span class="badge badge-md">Medium</span>
<span class="badge badge-sm">Small</span>
<span class="badge badge-xs">Extra Small</span>
```

### Loading States

```html
<!-- ❌ OLD: Loading Spinner -->
<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>

<!-- ✅ NEW: daisyUI -->
<span class="loading loading-spinner loading-md"></span>

<!-- ❌ OLD: Loading Dots -->
<div class="flex space-x-1">
    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
</div>

<!-- ✅ NEW: daisyUI -->
<span class="loading loading-dots loading-md"></span>

<!-- Loading Types -->
<span class="loading loading-spinner loading-xs"></span>
<span class="loading loading-dots loading-sm"></span>
<span class="loading loading-ring loading-md"></span>
<span class="loading loading-ball loading-lg"></span>
<span class="loading loading-bars loading-sm"></span>
<span class="loading loading-infinity loading-lg"></span>
```

### Navigation

```html
<!-- ❌ OLD: Tabs -->
<div class="border-b border-gray-700">
    <nav class="flex space-x-8">
        <a class="border-b-2 border-indigo-500 px-1 py-4 text-sm 
                  font-medium text-white">
            Tab 1
        </a>
        <a class="border-b-2 border-transparent px-1 py-4 text-sm 
                  font-medium text-gray-400 hover:text-white 
                  hover:border-gray-300">
            Tab 2
        </a>
    </nav>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="tabs tabs-boxed">
    <a class="tab tab-active">Tab 1</a>
    <a class="tab">Tab 2</a>
    <a class="tab">Tab 3</a>
</div>

<!-- Tab Variants -->
<div class="tabs">Default</div>
<div class="tabs tabs-boxed">Boxed</div>
<div class="tabs tabs-bordered">Bordered</div>
<div class="tabs tabs-lifted">Lifted</div>

<!-- ❌ OLD: Breadcrumbs -->
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1">
        <li class="inline-flex items-center">
            <a href="#" class="text-gray-400 hover:text-white">Home</a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1">...</svg>
                <a href="#" class="text-gray-400 hover:text-white">Projects</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1">...</svg>
                <span class="text-gray-300">Current</span>
            </div>
        </li>
    </ol>
</nav>

<!-- ✅ NEW: daisyUI -->
<div class="text-sm breadcrumbs">
    <ul>
        <li><a>Home</a></li>
        <li><a>Projects</a></li>
        <li>Current</li>
    </ul>
</div>

<!-- ❌ OLD: Pagination -->
<div class="flex items-center justify-between">
    <button class="px-4 py-2 text-sm font-medium text-gray-400 
                   bg-gray-800 rounded-md hover:bg-gray-700">
        Previous
    </button>
    <span class="text-sm text-gray-400">Page 1 of 10</span>
    <button class="px-4 py-2 text-sm font-medium text-gray-400 
                   bg-gray-800 rounded-md hover:bg-gray-700">
        Next
    </button>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="join">
    <button class="join-item btn">«</button>
    <button class="join-item btn">Page 1</button>
    <button class="join-item btn btn-active">Page 2</button>
    <button class="join-item btn">Page 3</button>
    <button class="join-item btn">»</button>
</div>
```

## Color System

### Theme Variable Mapping

| Purpose | Raw Tailwind | daisyUI Variable | CSS Variable |
|---------|-------------|------------------|--------------|
| **Main Background** | `bg-gray-800` | `bg-base-100` | `--b1` |
| **Card Background** | `bg-gray-900` | `bg-base-200` | `--b2` |
| **Darker Background** | `bg-gray-950` | `bg-base-300` | `--b3` |
| **Main Text** | `text-white` | `text-base-content` | `--bc` |
| **Muted Text** | `text-gray-400` | `text-base-content/70` | `--bc` with opacity |
| **Primary Color** | `bg-indigo-600` | `bg-primary` | `--p` |
| **Primary Text** | `text-indigo-600` | `text-primary` | `--p` |
| **Secondary Color** | `bg-purple-600` | `bg-secondary` | `--s` |
| **Accent Color** | `bg-green-600` | `bg-accent` | `--a` |
| **Success** | `bg-green-500` | `bg-success` | `--su` |
| **Warning** | `bg-yellow-500` | `bg-warning` | `--wa` |
| **Error** | `bg-red-500` | `bg-error` | `--er` |
| **Info** | `bg-blue-500` | `bg-info` | `--in` |
| **Border** | `border-gray-700` | `border-base-300` | `--b3` |

### Using Theme Colors

```html
<!-- Backgrounds -->
<div class="bg-base-100">Main background</div>
<div class="bg-base-200">Card/Section background</div>
<div class="bg-base-300">Darker accents</div>
<div class="bg-primary">Primary color background</div>
<div class="bg-secondary">Secondary color background</div>

<!-- Text Colors -->
<p class="text-base-content">Main text color</p>
<p class="text-base-content/70">Muted text (70% opacity)</p>
<p class="text-base-content/50">Very muted text (50% opacity)</p>
<p class="text-primary">Primary color text</p>
<p class="text-secondary">Secondary color text</p>
<p class="text-accent">Accent color text</p>
<p class="text-success">Success text</p>
<p class="text-warning">Warning text</p>
<p class="text-error">Error text</p>

<!-- Borders -->
<div class="border border-base-300">Default border</div>
<div class="border-2 border-primary">Primary border</div>
<div class="border-l-4 border-error">Error accent border</div>
```

## Responsive Patterns

### Mobile-First Design

```html
<!-- Full width on mobile, auto on desktop -->
<button class="btn btn-primary w-full sm:w-auto">
    Responsive Button
</button>

<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col sm:flex-row gap-4">
    <button class="btn btn-primary">Option 1</button>
    <button class="btn btn-secondary">Option 2</button>
</div>

<!-- Different columns on different screens -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    <div class="card bg-base-200">Card 1</div>
    <div class="card bg-base-200">Card 2</div>
    <div class="card bg-base-200">Card 3</div>
    <div class="card bg-base-200">Card 4</div>
</div>

<!-- Hide/Show Elements -->
<div class="hidden sm:block">Visible on tablet and up</div>
<div class="block sm:hidden">Visible on mobile only</div>
<div class="hidden lg:block">Visible on desktop only</div>

<!-- Responsive Text -->
<h1 class="text-2xl sm:text-3xl lg:text-4xl">Responsive Heading</h1>
<p class="text-sm sm:text-base lg:text-lg">Responsive paragraph</p>

<!-- Responsive Spacing -->
<div class="p-4 sm:p-6 lg:p-8">Responsive padding</div>
<div class="mt-4 sm:mt-6 lg:mt-8">Responsive margin</div>

<!-- Responsive Tables -->
<div class="overflow-x-auto">
    <table class="table">
        <!-- Table scrolls horizontally on mobile -->
    </table>
</div>
```

## Livewire Integration

### Form with Validation

```blade
<form wire:submit.prevent="save" class="space-y-6">
    <!-- Text Input with Error -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">Name</span>
            <span class="label-text-alt">Required</span>
        </label>
        <input 
            type="text" 
            wire:model.defer="name"
            class="input input-bordered w-full @error('name') input-error @enderror"
        />
        @error('name')
            <label class="label">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </label>
        @enderror
    </div>

    <!-- Select with Loading -->
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">Category</span>
        </label>
        <select 
            wire:model="category"
            wire:change="updateSubcategories"
            class="select select-bordered w-full"
            wire:loading.attr="disabled"
        >
            <option disabled selected>Choose category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <div wire:loading wire:target="updateSubcategories" class="label">
            <span class="loading loading-dots loading-sm"></span>
        </div>
    </div>

    <!-- Submit Button with Loading -->
    <div class="flex justify-end gap-2">
        <button type="button" wire:click="cancel" class="btn btn-ghost">
            Cancel
        </button>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="save">Save</span>
            <span wire:loading wire:target="save">
                <span class="loading loading-spinner loading-sm"></span>
                Saving...
            </span>
        </button>
    </div>
</form>
```

### Modal with Livewire

```blade
<!-- Component Class -->
public $showModal = false;
public $editingUser = null;

public function edit($userId)
{
    $this->editingUser = User::find($userId);
    $this->showModal = true;
}

public function closeModal()
{
    $this->showModal = false;
    $this->reset(['editingUser']);
}

<!-- Blade Template -->
<div class="modal @if($showModal) modal-open @endif">
    <div class="modal-box max-w-2xl">
        <h3 class="font-bold text-lg">
            {{ $editingUser ? 'Edit User' : 'Create User' }}
        </h3>
        
        <div class="py-4">
            <!-- Form content -->
        </div>
        
        <div class="modal-action">
            <button class="btn btn-ghost" wire:click="closeModal">
                Cancel
            </button>
            <button class="btn btn-primary" wire:click="save">
                Save
            </button>
        </div>
    </div>
    
    <form method="dialog" class="modal-backdrop">
        <button wire:click="closeModal">close</button>
    </form>
</div>
```

### Real-time Search

```blade
<div class="form-control">
    <input 
        type="text" 
        wire:model.debounce.300ms="search"
        placeholder="Search users..."
        class="input input-bordered w-full"
    />
    <div wire:loading wire:target="search" class="label">
        <span class="loading loading-bars loading-sm"></span>
        <span class="label-text-alt">Searching...</span>
    </div>
</div>

<div class="mt-4">
    @forelse($searchResults as $result)
        <div class="card bg-base-200 mb-2">
            <div class="card-body">
                {{ $result->name }}
            </div>
        </div>
    @empty
        <div class="alert">
            <span>No results found</span>
        </div>
    @endforelse
</div>
```

## Migration Checklist

When migrating a component:

### 1. Identify Component Type
- [ ] Is it a button? → Use `btn btn-[variant]`
- [ ] Is it an input? → Use `input input-bordered`
- [ ] Is it a card? → Use `card bg-base-200`
- [ ] Is it a modal? → Use `modal modal-box`
- [ ] Is it a table? → Use `table`
- [ ] Is it an alert? → Use `alert alert-[type]`

### 2. Replace Colors
- [ ] Replace `bg-gray-XXX` with `bg-base-100/200/300`
- [ ] Replace `text-white` with `text-base-content`
- [ ] Replace `text-gray-XXX` with `text-base-content/70`
- [ ] Replace `border-gray-XXX` with `border-base-300`
- [ ] Replace specific colors with theme variables

### 3. Add Responsive Classes
- [ ] Add `w-full sm:w-auto` for mobile-first buttons
- [ ] Use `flex-col sm:flex-row` for stacking
- [ ] Add `overflow-x-auto` for tables
- [ ] Test at 375px, 768px, 1024px breakpoints

### 4. Handle States
- [ ] Add `@error() input-error @enderror` for errors
- [ ] Add loading states with `loading loading-[type]`
- [ ] Add hover states with `hover` class
- [ ] Add disabled states properly

### 5. Test Integration
- [ ] Test with Livewire if applicable
- [ ] Test with Alpine.js if applicable
- [ ] Verify dark theme consistency
- [ ] Check mobile responsiveness

## Common Pitfalls

### ❌ DON'T Mix Systems
```html
<!-- WRONG: Mixing daisyUI with raw Tailwind colors -->
<button class="btn btn-primary bg-blue-600">
```

### ❌ DON'T Override Theme Colors
```html
<!-- WRONG: Overriding theme colors -->
<div class="card bg-gray-800">
```

### ❌ DON'T Forget Mobile
```html
<!-- WRONG: Not mobile responsive -->
<button class="btn btn-primary w-96">
```

### ❌ DON'T Use Inline Styles
```html
<!-- WRONG: Inline styles -->
<div style="background-color: #1f2937">
```

### ✅ DO Use Theme Variables
```html
<!-- RIGHT: Using theme variables -->
<div class="card bg-base-200">
```

### ✅ DO Test Responsiveness
```html
<!-- RIGHT: Mobile responsive -->
<button class="btn btn-primary w-full sm:w-auto">
```

### ✅ DO Use Semantic Classes
```html
<!-- RIGHT: Semantic component classes -->
<div class="alert alert-success">
```

## Quick Reference Tables

### Button Quick Reference
| Need | Class |
|------|-------|
| Primary button | `btn btn-primary` |
| Secondary button | `btn btn-secondary` |
| Ghost button | `btn btn-ghost` |
| Link button | `btn btn-link` |
| Danger button | `btn btn-error` |
| Success button | `btn btn-success` |
| Small button | `btn btn-sm` |
| Large button | `btn btn-lg` |
| Full width button | `btn btn-block` |
| Loading button | `btn loading` |
| Disabled button | `btn` + `disabled` attribute |
| Icon button | `btn btn-circle` |
| Outlined button | `btn btn-outline` |

### Input Quick Reference
| Need | Class |
|------|-------|
| Text input | `input input-bordered` |
| Error input | `input input-bordered input-error` |
| Small input | `input input-bordered input-sm` |
| Large input | `input input-bordered input-lg` |
| Select dropdown | `select select-bordered` |
| Textarea | `textarea textarea-bordered` |
| Checkbox | `checkbox checkbox-primary` |
| Radio | `radio radio-primary` |
| Toggle | `toggle toggle-primary` |
| File input | `file-input file-input-bordered` |
| Range slider | `range range-primary` |

### Alert Quick Reference
| Need | Class |
|------|-------|
| Default alert | `alert` |
| Success alert | `alert alert-success` |
| Error alert | `alert alert-error` |
| Warning alert | `alert alert-warning` |
| Info alert | `alert alert-info` |

### Component Size Reference
| Size | Buttons | Inputs | Badges | Loading |
|------|---------|--------|--------|---------|
| Extra Small | `btn-xs` | `input-xs` | `badge-xs` | `loading-xs` |
| Small | `btn-sm` | `input-sm` | `badge-sm` | `loading-sm` |
| Medium | (default) | `input-md` | `badge-md` | `loading-md` |
| Large | `btn-lg` | `input-lg` | `badge-lg` | `loading-lg` |

---

## Summary

The migration from raw Tailwind to daisyUI is about:
1. **Simplification** - Less code, same result
2. **Consistency** - Semantic classes across the app
3. **Maintainability** - Easier to update and modify
4. **Theming** - Centralized color management
5. **Responsiveness** - Mobile-first by default

Remember: **Always use daisyUI components when available, only use Tailwind for layout and spacing.**

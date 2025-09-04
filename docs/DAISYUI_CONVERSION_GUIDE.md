# daisyUI Conversion Guide

## ❌ STOP Writing This → ✅ START Writing This

### Buttons

```html
<!-- ❌ OLD: Raw Tailwind -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 
               focus:outline-none focus:ring-2 focus:ring-indigo-500 
               focus:ring-offset-2 focus:ring-offset-gray-800 
               transition-colors duration-200">

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-primary">

<!-- ❌ OLD: Small button -->
<button class="px-2 py-1 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-primary btn-sm">

<!-- ❌ OLD: Full width on mobile -->
<button class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md">

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-primary w-full sm:w-auto">

<!-- ❌ OLD: Icon button -->
<button class="p-2 rounded-full bg-gray-700 hover:bg-gray-600">

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-circle btn-ghost">

<!-- ❌ OLD: Loading button -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md opacity-50 cursor-not-allowed">
    <svg class="animate-spin h-5 w-5 mr-3" ...>
    Processing...
</button>

<!-- ✅ NEW: daisyUI -->
<button class="btn btn-primary" disabled>
    <span class="loading loading-spinner"></span>
    Processing...
</button>
```

### Form Inputs

```html
<!-- ❌ OLD: Text input -->
<input type="text" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 
                          rounded-md text-white placeholder-gray-400 
                          focus:bg-gray-600 focus:border-indigo-500 
                          focus:ring-1 focus:ring-indigo-500">

<!-- ✅ NEW: daisyUI -->
<input type="text" class="input input-bordered w-full">

<!-- ❌ OLD: Input with error -->
<input type="email" class="w-full px-3 py-2 bg-gray-700 border border-red-500 
                           rounded-md text-white">
<span class="text-red-500 text-sm">Error message</span>

<!-- ✅ NEW: daisyUI -->
<div class="form-control w-full">
    <input type="email" class="input input-bordered input-error w-full">
    <label class="label">
        <span class="label-text-alt text-error">Error message</span>
    </label>
</div>

<!-- ❌ OLD: Select dropdown -->
<select class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white">

<!-- ✅ NEW: daisyUI -->
<select class="select select-bordered w-full">

<!-- ❌ OLD: Checkbox -->
<input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 
                              bg-gray-700 border-gray-600 rounded">

<!-- ✅ NEW: daisyUI -->
<input type="checkbox" class="checkbox checkbox-primary">

<!-- ❌ OLD: Toggle switch -->
<button type="button" class="relative inline-flex h-6 w-11 items-center 
                              rounded-full bg-gray-700">

<!-- ✅ NEW: daisyUI -->
<input type="checkbox" class="toggle toggle-primary">
```

### Cards

```html
<!-- ❌ OLD: Card -->
<div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
    <h3 class="text-lg font-semibold text-white mb-2">Title</h3>
    <p class="text-gray-300">Content</p>
    <div class="mt-4 flex justify-end space-x-2">
        <button class="px-4 py-2 bg-gray-700 text-white rounded">Cancel</button>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
    </div>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="card bg-base-200 shadow-xl">
    <div class="card-body">
        <h2 class="card-title">Title</h2>
        <p>Content</p>
        <div class="card-actions justify-end">
            <button class="btn btn-ghost">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
```

### Tables

```html
<!-- ❌ OLD: Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">

<!-- ✅ NEW: daisyUI -->
<div class="overflow-x-auto">
    <table class="table table-zebra">
        <thead>
            <tr>
                <th>

<!-- ❌ OLD: Table row -->
<tr class="bg-gray-800 hover:bg-gray-700">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">

<!-- ✅ NEW: daisyUI -->
<tr class="hover">
    <td>
```

### Modals

```html
<!-- ❌ OLD: Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto" x-show="showModal">
    <div class="flex min-h-screen items-center justify-center">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="relative bg-gray-800 rounded-lg p-6 max-w-lg w-full">
            <h3 class="text-lg font-semibold text-white">Modal Title</h3>
            <div class="mt-4">Content</div>
            <div class="mt-6 flex justify-end space-x-2">
                <button class="px-4 py-2 bg-gray-700 text-white rounded">Cancel</button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="modal @if($showModal) modal-open @endif">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Modal Title</h3>
        <div class="py-4">Content</div>
        <div class="modal-action">
            <button class="btn btn-ghost">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
```

### Alerts

```html
<!-- ❌ OLD: Success alert -->
<div class="bg-green-900 border-l-4 border-green-500 text-green-200 p-4">
    <p class="font-bold">Success</p>
    <p>Your changes have been saved.</p>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="alert alert-success">
    <span>Your changes have been saved.</span>
</div>

<!-- ❌ OLD: Error alert -->
<div class="bg-red-900 border-l-4 border-red-500 text-red-200 p-4">

<!-- ✅ NEW: daisyUI -->
<div class="alert alert-error">
```

### Badges/Tags

```html
<!-- ❌ OLD: Status badge -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs 
             font-medium bg-green-900 text-green-200">
    Active
</span>

<!-- ✅ NEW: daisyUI -->
<span class="badge badge-success">Active</span>

<!-- ❌ OLD: Role badge -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs 
             font-medium bg-indigo-900 text-indigo-200">

<!-- ✅ NEW: daisyUI -->
<span class="badge badge-primary">
```

### Loading States

```html
<!-- ❌ OLD: Loading spinner -->
<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" ...></path>
</svg>

<!-- ✅ NEW: daisyUI -->
<span class="loading loading-spinner loading-md"></span>

<!-- ❌ OLD: Loading dots -->
<div class="flex space-x-1">
    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
</div>

<!-- ✅ NEW: daisyUI -->
<span class="loading loading-dots loading-md"></span>
```

### Navigation

```html
<!-- ❌ OLD: Tabs -->
<div class="border-b border-gray-700">
    <nav class="flex space-x-8">
        <a class="border-b-2 border-indigo-500 px-1 py-4 text-sm font-medium text-white">
            Tab 1
        </a>
        <a class="border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-400 
                  hover:text-white hover:border-gray-300">
            Tab 2
        </a>
    </nav>
</div>

<!-- ✅ NEW: daisyUI -->
<div class="tabs tabs-boxed">
    <a class="tab tab-active">Tab 1</a>
    <a class="tab">Tab 2</a>
</div>

<!-- ❌ OLD: Pagination -->
<div class="flex items-center justify-between">
    <button class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-800 
                   rounded-md hover:bg-gray-700">
        Previous
    </button>
    <span class="text-sm text-gray-400">Page 1 of 10</span>
    <button class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-800 
                   rounded-md hover:bg-gray-700">
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

## Color Mapping

| Raw Tailwind | daisyUI Theme Variable | Usage |
|-------------|------------------------|--------|
| `bg-gray-800` | `bg-base-100` | Main background |
| `bg-gray-900` | `bg-base-200` | Card/Section background |
| `bg-gray-950` | `bg-base-300` | Darker accents |
| `text-white` | `text-base-content` | Main text |
| `text-gray-400` | `text-base-content/70` | Secondary text |
| `bg-indigo-600` | `bg-primary` | Primary actions |
| `bg-green-600` | `bg-success` | Success states |
| `bg-red-600` | `bg-error` | Error/danger states |
| `bg-yellow-500` | `bg-warning` | Warning states |
| `border-gray-700` | `border-base-300` | Borders |

## Mobile Responsive Patterns

```html
<!-- Full width on mobile, auto on desktop -->
<button class="btn btn-primary w-full sm:w-auto">

<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col sm:flex-row gap-4">

<!-- Hide on mobile -->
<div class="hidden sm:block">

<!-- Show only on mobile -->
<div class="block sm:hidden">

<!-- Responsive grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
```

## Livewire Integration

```html
<!-- Loading state -->
<button class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Save</span>
    <span wire:loading class="loading loading-spinner loading-sm"></span>
</button>

<!-- Conditional modal -->
<div class="modal @if($showModal) modal-open @endif">

<!-- Error states -->
<input class="input input-bordered @error('email') input-error @enderror">
```

## Remember

1. **ALWAYS use daisyUI component classes** for buttons, inputs, cards, etc.
2. **ONLY use Tailwind utilities** for layout, spacing, and responsive design
3. **NEVER mix color utilities** with daisyUI components
4. **ALWAYS test on mobile** - most components should be full width on mobile
5. **USE semantic naming** - `btn-primary` not `bg-indigo-600`
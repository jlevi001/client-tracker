{{-- 
    Button Components Usage Guide
    This file demonstrates all button variants and options using daisyUI
    Place this in a test page to see all button styles
--}}

<div class="p-6 space-y-8 bg-base-100">
    
    {{-- Basic Buttons --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Basic Buttons</h2>
            <div class="flex flex-wrap gap-2">
                <x-button>Primary Button</x-button>
                <x-secondary-button>Secondary Button</x-secondary-button>
                <x-danger-button>Danger Button</x-danger-button>
            </div>
        </div>
    </div>

    {{-- UI Button Variants --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">UI Button Variants</h2>
            <div class="flex flex-wrap gap-2">
                <x-ui-button variant="primary">Primary</x-ui-button>
                <x-ui-button variant="secondary">Secondary</x-ui-button>
                <x-ui-button variant="accent">Accent</x-ui-button>
                <x-ui-button variant="success">Success</x-ui-button>
                <x-ui-button variant="warning">Warning</x-ui-button>
                <x-ui-button variant="info">Info</x-ui-button>
                <x-ui-button variant="error">Error</x-ui-button>
                <x-ui-button variant="neutral">Neutral</x-ui-button>
            </div>
        </div>
    </div>

    {{-- Button Sizes --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Button Sizes</h2>
            <div class="flex flex-wrap items-center gap-2">
                <x-ui-button size="xs">Extra Small</x-ui-button>
                <x-ui-button size="sm">Small</x-ui-button>
                <x-ui-button size="md">Medium</x-ui-button>
                <x-ui-button size="lg">Large</x-ui-button>
            </div>
        </div>
    </div>

    {{-- Button Styles --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Button Styles</h2>
            <div class="flex flex-wrap gap-2">
                <x-ui-button outline>Outline</x-ui-button>
                <x-ui-button ghost>Ghost</x-ui-button>
                <x-ui-button link>Link</x-ui-button>
                <x-ui-button glass>Glass</x-ui-button>
                <x-ui-button variant="success" outline>Outline Success</x-ui-button>
                <x-ui-button variant="error" outline>Outline Error</x-ui-button>
            </div>
        </div>
    </div>

    {{-- Button Shapes --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Button Shapes & Widths</h2>
            <div class="space-y-2">
                <div class="flex flex-wrap gap-2">
                    <x-ui-button wide>Wide Button</x-ui-button>
                    <x-ui-button block>Block Button (Full Width)</x-ui-button>
                </div>
                <div class="flex flex-wrap gap-2">
                    <x-icon-button shape="circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </x-icon-button>
                    <x-icon-button shape="square" variant="primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-icon-button>
                </div>
            </div>
        </div>
    </div>

    {{-- Icon Buttons with Tooltips --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Icon Buttons with Tooltips</h2>
            <div class="flex flex-wrap gap-2">
                <x-icon-button tooltip="Edit" variant="primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </x-icon-button>
                <x-icon-button tooltip="Delete" tooltipPosition="bottom" variant="error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </x-icon-button>
                <x-icon-button tooltip="View" tooltipPosition="right" variant="info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </x-icon-button>
            </div>
        </div>
    </div>

    {{-- Button Groups --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Button Groups</h2>
            <div class="space-y-4">
                {{-- Horizontal Join --}}
                <div>
                    <p class="text-sm text-base-content/70 mb-2">Joined Horizontal</p>
                    <x-button-group>
                        <button class="btn join-item">One</button>
                        <button class="btn join-item btn-active">Two</button>
                        <button class="btn join-item">Three</button>
                    </x-button-group>
                </div>
                
                {{-- Vertical Join --}}
                <div>
                    <p class="text-sm text-base-content/70 mb-2">Joined Vertical</p>
                    <x-button-group vertical>
                        <button class="btn join-item btn-primary">Option A</button>
                        <button class="btn join-item btn-primary">Option B</button>
                        <button class="btn join-item btn-primary">Option C</button>
                    </x-button-group>
                </div>
                
                {{-- With Gap --}}
                <div>
                    <p class="text-sm text-base-content/70 mb-2">With Gap</p>
                    <x-button-group gap>
                        <x-ui-button variant="success">Save</x-ui-button>
                        <x-ui-button variant="secondary">Cancel</x-ui-button>
                        <x-ui-button variant="error" outline>Delete</x-ui-button>
                    </x-button-group>
                </div>
            </div>
        </div>
    </div>

    {{-- Loading States --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Loading States</h2>
            <div class="flex flex-wrap gap-2">
                <x-ui-button loading>
                    Loading
                </x-ui-button>
                <x-ui-button variant="success" loading loadingType="dots">
                    Processing
                </x-ui-button>
                <x-ui-button variant="info" loading loadingType="ring">
                    Fetching
                </x-ui-button>
                <button class="btn btn-primary" disabled>
                    <span class="loading loading-spinner"></span>
                    Loading...
                </button>
            </div>
        </div>
    </div>

    {{-- Disabled States --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Disabled States</h2>
            <div class="flex flex-wrap gap-2">
                <x-ui-button disabled>Disabled Primary</x-ui-button>
                <x-ui-button variant="secondary" disabled>Disabled Secondary</x-ui-button>
                <x-ui-button variant="success" outline disabled>Disabled Outline</x-ui-button>
                <x-ui-button ghost disabled>Disabled Ghost</x-ui-button>
            </div>
        </div>
    </div>

    {{-- Responsive Buttons --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Responsive Buttons</h2>
            <div class="space-y-2">
                <x-ui-button fullWidthOnMobile>
                    Full Width on Mobile
                </x-ui-button>
                <x-ui-button variant="success" fullWidthOnMobile>
                    Another Mobile Full Width
                </x-ui-button>
                <x-button-group fullWidthOnMobile>
                    <button class="btn join-item btn-primary flex-1">Accept</button>
                    <button class="btn join-item btn-ghost flex-1">Decline</button>
                </x-button-group>
            </div>
        </div>
    </div>

    {{-- Livewire Integration Examples --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Livewire Integration</h2>
            <div class="space-y-2">
                <p class="text-sm text-base-content/70">Examples with wire:click (functional when connected to Livewire components)</p>
                <div class="flex flex-wrap gap-2">
                    <x-loading-button wire:click="save">
                        Save Changes
                    </x-loading-button>
                    <x-loading-button 
                        wire:click="delete" 
                        variant="error"
                        loadingText="Deleting..."
                    >
                        Delete Item
                    </x-loading-button>
                    <x-loading-button 
                        wire:click="process" 
                        variant="info"
                        loadingType="dots"
                        loadingText="Processing..."
                    >
                        Process Data
                    </x-loading-button>
                </div>
            </div>
        </div>
    </div>

    {{-- Complex Button Examples --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Complex Examples</h2>
            <div class="space-y-4">
                {{-- Action Buttons in Table --}}
                <div>
                    <p class="text-sm text-base-content/70 mb-2">Table Actions</p>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Item Name</td>
                                    <td>
                                        <div class="flex gap-1">
                                            <x-icon-button size="sm" tooltip="View">
                                                <x-icon-eye class="w-4 h-4" />
                                            </x-icon-button>
                                            <x-icon-button size="sm" variant="primary" tooltip="Edit">
                                                <x-icon-edit class="w-4 h-4" />
                                            </x-icon-button>
                                            <x-icon-button size="sm" variant="error" tooltip="Delete">
                                                <x-icon-trash class="w-4 h-4" />
                                            </x-icon-button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Modal Actions --}}
                <div>
                    <p class="text-sm text-base-content/70 mb-2">Modal Footer Actions</p>
                    <div class="flex justify-end gap-2">
                        <x-ui-button variant="ghost">Cancel</x-ui-button>
                        <x-ui-button variant="primary">Save Changes</x-ui-button>
                    </div>
                </div>
                
                {{-- Form Actions --}}
                <div>
                    <p class="text-sm text-base-content/70 mb-2">Form Actions</p>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-ui-button variant="primary" fullWidthOnMobile>
                            Submit Form
                        </x-ui-button>
                        <x-ui-button variant="secondary" outline fullWidthOnMobile>
                            Save as Draft
                        </x-ui-button>
                        <x-ui-button ghost fullWidthOnMobile>
                            Cancel
                        </x-ui-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
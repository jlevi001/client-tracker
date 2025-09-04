{{-- Example usage of modals with daisyUI --}}
<div class="p-6 space-y-6 bg-base-100">
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Modal Examples with daisyUI</h2>
            <p class="text-base-content/70">Here are examples of how to use the rewritten modal components with daisyUI classes.</p>
        </div>
    </div>

    {{-- Basic Modal Example --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h3 class="text-lg font-bold">Basic Modal</h3>
            <div class="divider"></div>
            
            {{-- Trigger Button --}}
            <button class="btn btn-primary" wire:click="$set('showModal', true)">
                Open Basic Modal
            </button>

            {{-- Modal --}}
            <x-modal wire:model="showModal" maxWidth="2xl">
                <h3 class="font-bold text-lg">Basic Modal Title</h3>
                <div class="py-4">
                    <p class="text-base-content/70">
                        This is a basic modal using daisyUI classes. It's clean, semantic, and mobile-responsive.
                    </p>
                </div>
                <div class="modal-action">
                    <button class="btn btn-ghost" wire:click="$set('showModal', false)">Cancel</button>
                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </x-modal>
        </div>
    </div>

    {{-- Dialog Modal Example --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h3 class="text-lg font-bold">Dialog Modal</h3>
            <div class="divider"></div>
            
            {{-- Trigger Button --}}
            <button class="btn btn-secondary" wire:click="$set('showDialogModal', true)">
                Open Dialog Modal
            </button>

            {{-- Dialog Modal --}}
            <x-dialog-modal wire:model="showDialogModal" maxWidth="lg">
                <x-slot name="title">
                    Dialog Modal Title
                </x-slot>

                <x-slot name="content">
                    <p>This is a dialog modal with structured slots for title, content, and footer.</p>
                    <p class="mt-2">It uses daisyUI's semantic classes for consistent styling.</p>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$set('showDialogModal', false)">
                        Cancel
                    </x-secondary-button>
                    <x-button class="ms-2" wire:click="processDialog">
                        Confirm
                    </x-button>
                </x-slot>
            </x-dialog-modal>
        </div>
    </div>

    {{-- Confirmation Modal Example --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h3 class="text-lg font-bold">Confirmation Modal</h3>
            <div class="divider"></div>
            
            {{-- Trigger Button --}}
            <button class="btn btn-warning" wire:click="$set('showConfirmationModal', true)">
                Delete Item
            </button>

            {{-- Confirmation Modal --}}
            <x-confirmation-modal wire:model="showConfirmationModal" maxWidth="md">
                <x-slot name="title">
                    Delete Confirmation
                </x-slot>

                <x-slot name="content">
                    Are you sure you want to delete this item? This action cannot be undone.
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$set('showConfirmationModal', false)">
                        Cancel
                    </x-secondary-button>
                    <x-danger-button class="ms-2" wire:click="deleteItem">
                        Delete Item
                    </x-danger-button>
                </x-slot>
            </x-confirmation-modal>
        </div>
    </div>

    {{-- Password Confirmation Example --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h3 class="text-lg font-bold">Password Confirmation</h3>
            <div class="divider"></div>
            
            {{-- Trigger with Password Confirmation --}}
            <x-confirms-password wire:then="performSensitiveAction">
                <button class="btn btn-error">
                    Perform Sensitive Action
                </button>
            </x-confirms-password>
        </div>
    </div>

    {{-- Modal Size Variations --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h3 class="text-lg font-bold">Modal Sizes</h3>
            <div class="divider"></div>
            
            <div class="flex flex-wrap gap-2">
                <button class="btn btn-outline btn-sm" wire:click="$set('showSmallModal', true)">
                    Small Modal
                </button>
                <button class="btn btn-outline" wire:click="$set('showMediumModal', true)">
                    Medium Modal
                </button>
                <button class="btn btn-outline btn-lg" wire:click="$set('showLargeModal', true)">
                    Large Modal
                </button>
            </div>

            {{-- Small Modal --}}
            <x-modal wire:model="showSmallModal" maxWidth="sm">
                <h3 class="font-bold text-lg">Small Modal</h3>
                <div class="py-4">
                    <p class="text-base-content/70">This is a small modal (max-w-sm).</p>
                </div>
                <div class="modal-action">
                    <button class="btn btn-sm btn-ghost" wire:click="$set('showSmallModal', false)">Close</button>
                </div>
            </x-modal>

            {{-- Medium Modal --}}
            <x-modal wire:model="showMediumModal" maxWidth="lg">
                <h3 class="font-bold text-lg">Medium Modal</h3>
                <div class="py-4">
                    <p class="text-base-content/70">This is a medium modal (max-w-lg).</p>
                </div>
                <div class="modal-action">
                    <button class="btn btn-ghost" wire:click="$set('showMediumModal', false)">Close</button>
                </div>
            </x-modal>

            {{-- Large Modal --}}
            <x-modal wire:model="showLargeModal" maxWidth="5xl">
                <h3 class="font-bold text-lg">Large Modal</h3>
                <div class="py-4">
                    <p class="text-base-content/70">This is a large modal (max-w-5xl). Perfect for forms or detailed content.</p>
                </div>
                <div class="modal-action">
                    <button class="btn btn-ghost" wire:click="$set('showLargeModal', false)">Close</button>
                </div>
            </x-modal>
        </div>
    </div>

    {{-- Loading State Example --}}
    <div class="card bg-base-200">
        <div class="card-body">
            <h3 class="text-lg font-bold">Modal with Loading States</h3>
            <div class="divider"></div>
            
            <button class="btn btn-accent" wire:click="$set('showLoadingModal', true)">
                Open Modal with Loading
            </button>

            <x-modal wire:model="showLoadingModal" maxWidth="md">
                <h3 class="font-bold text-lg">Processing Data</h3>
                <div class="py-4">
                    <p class="text-base-content/70 mb-4">Click save to see the loading state.</p>
                </div>
                <div class="modal-action">
                    <button class="btn btn-ghost" wire:click="$set('showLoadingModal', false)">
                        Cancel
                    </button>
                    <button class="btn btn-primary" wire:click="saveWithDelay" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="saveWithDelay">Save</span>
                        <span wire:loading wire:target="saveWithDelay" class="flex items-center gap-2">
                            <span class="loading loading-spinner loading-sm"></span>
                            Processing...
                        </span>
                    </button>
                </div>
            </x-modal>
        </div>
    </div>
</div>
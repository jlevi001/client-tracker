{{-- 
    Example form showing proper usage of daisyUI form components
    This is for reference and documentation purposes
--}}

<form wire:submit.prevent="save" class="space-y-6">
    {{-- Simple text input with label --}}
    <x-form-control label="Full Name" for="name" required>
        <x-input 
            id="name" 
            type="text" 
            wire:model="name" 
            :error="$errors->has('name')"
            placeholder="Enter your full name"
        />
        @error('name')
            <x-input-error for="name" />
        @enderror
    </x-form-control>

    {{-- Email input with hint text --}}
    <x-form-control 
        label="Email Address" 
        for="email" 
        hint="We'll never share your email"
        required
    >
        <x-input 
            id="email" 
            type="email" 
            wire:model="email" 
            :error="$errors->has('email')"
            placeholder="email@example.com"
        />
        @error('email')
            <x-input-error for="email" />
        @enderror
    </x-form-control>

    {{-- Select dropdown --}}
    <x-form-control label="Role" for="role">
        <x-select 
            id="role" 
            wire:model="role" 
            :error="$errors->has('role')"
        >
            <option disabled selected>Select a role</option>
            <option value="admin">Administrator</option>
            <option value="user">User</option>
            <option value="guest">Guest</option>
        </x-select>
        @error('role')
            <x-input-error for="role" />
        @enderror
    </x-form-control>

    {{-- Textarea --}}
    <x-form-control label="Description" for="description">
        <x-textarea 
            id="description" 
            wire:model="description" 
            rows="4"
            :error="$errors->has('description')"
            placeholder="Tell us about yourself..."
        />
        @error('description')
            <x-input-error for="description" />
        @enderror
    </x-form-control>

    {{-- Checkbox --}}
    <div class="form-control">
        <label class="label cursor-pointer justify-start space-x-3">
            <x-checkbox 
                wire:model="terms" 
                :error="$errors->has('terms')"
            />
            <span class="label-text">I agree to the terms and conditions</span>
        </label>
        @error('terms')
            <x-input-error for="terms" />
        @enderror
    </div>

    {{-- Toggle switch --}}
    <div class="form-control">
        <label class="label cursor-pointer justify-start space-x-3">
            <x-toggle 
                wire:model="notifications" 
                size="md"
            />
            <span class="label-text">Enable email notifications</span>
        </label>
    </div>

    {{-- Radio group --}}
    <x-form-control label="Subscription Plan">
        <div class="space-y-2">
            <label class="label cursor-pointer justify-start space-x-3">
                <x-radio 
                    name="plan" 
                    value="basic" 
                    wire:model="plan" 
                />
                <span class="label-text">Basic Plan - $10/month</span>
            </label>
            <label class="label cursor-pointer justify-start space-x-3">
                <x-radio 
                    name="plan" 
                    value="pro" 
                    wire:model="plan" 
                />
                <span class="label-text">Pro Plan - $25/month</span>
            </label>
            <label class="label cursor-pointer justify-start space-x-3">
                <x-radio 
                    name="plan" 
                    value="enterprise" 
                    wire:model="plan" 
                />
                <span class="label-text">Enterprise Plan - $100/month</span>
            </label>
        </div>
        @error('plan')
            <x-input-error for="plan" />
        @enderror
    </x-form-control>

    {{-- Form actions with proper daisyUI buttons --}}
    <div class="flex flex-col sm:flex-row gap-4 pt-4">
        <button 
            type="submit" 
            class="btn btn-primary w-full sm:w-auto"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Save Changes</span>
            <span wire:loading class="loading loading-spinner loading-sm"></span>
            <span wire:loading>Saving...</span>
        </button>
        
        <button 
            type="button" 
            class="btn btn-ghost w-full sm:w-auto"
            wire:click="cancel"
        >
            Cancel
        </button>
    </div>
</form>

{{-- 
    Mobile-First Responsive Patterns Used:
    - w-full on mobile, sm:w-auto on desktop for buttons
    - flex-col on mobile, sm:flex-row on desktop for button groups
    - Full width inputs by default (w-full class)
    - Proper touch targets for checkboxes, radios, and toggles
    
    daisyUI Classes Used:
    - form-control: Wrapper for form fields
    - input input-bordered: Text inputs
    - select select-bordered: Dropdowns
    - textarea textarea-bordered: Text areas
    - checkbox checkbox-primary: Checkboxes
    - radio radio-primary: Radio buttons
    - toggle toggle-primary: Toggle switches
    - btn btn-primary: Primary buttons
    - btn btn-ghost: Secondary/cancel buttons
    - label, label-text: Proper label styling
    - loading loading-spinner: Loading states
--}}
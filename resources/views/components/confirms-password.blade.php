@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-dialog-modal wire:model.live="confirmingPassword">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        {{ $content }}

        <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <div class="form-control w-full">
                <input 
                    type="password" 
                    class="input input-bordered w-3/4" 
                    placeholder="{{ __('Password') }}" 
                    autocomplete="current-password"
                    x-ref="confirmable_password"
                    wire:model="confirmablePassword"
                    wire:keydown.enter="confirmPassword" 
                />
                
                @error('confirmable_password')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button 
            class="btn btn-ghost" 
            wire:click="stopConfirmingPassword" 
            wire:loading.attr="disabled"
        >
            {{ __('Cancel') }}
        </button>

        <button 
            class="btn btn-primary" 
            dusk="confirm-password-button" 
            wire:click="confirmPassword" 
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>{{ $button }}</span>
            <span wire:loading class="loading loading-spinner loading-sm"></span>
        </button>
    </x-slot>
</x-dialog-modal>
@endonce
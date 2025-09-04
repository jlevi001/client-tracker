@props([
    'label' => null,
    'for' => null,
    'error' => null,
    'hint' => null,
    'required' => false
])

<div {{ $attributes->merge(['class' => 'form-control w-full']) }}>
    @if($label)
        <label class="label" @if($for) for="{{ $for }}" @endif>
            <span class="label-text">
                {{ $label }}
                @if($required)
                    <span class="text-error">*</span>
                @endif
            </span>
        </label>
    @endif
    
    {{ $slot }}
    
    @if($error)
        <label class="label">
            <span class="label-text-alt text-error">{{ $error }}</span>
        </label>
    @elseif($hint)
        <label class="label">
            <span class="label-text-alt">{{ $hint }}</span>
        </label>
    @endif
</div>
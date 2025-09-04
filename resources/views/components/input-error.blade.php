@props(['for'])

@error($for)
    <label class="label">
        <span class="label-text-alt text-error">{{ $message }}</span>
    </label>
@enderror
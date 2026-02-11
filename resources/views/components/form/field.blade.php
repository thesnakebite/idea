@props(['label', 'name', 'type' => 'text'])

<div class="space-y-2">
    <label for="{{ $name }}" class="label text-sm">{{ $label }}</label>
    <input type="{{ $type }}" class="input" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" {{ $attributes }} />

    @error($name)
        <span class="error text-xs">{{ $message }}</span>
    @enderror
</div>

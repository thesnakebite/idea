@props(['name'])

@error($name)
    <span class="error text-xs">{{ $message }}</span>
@enderror

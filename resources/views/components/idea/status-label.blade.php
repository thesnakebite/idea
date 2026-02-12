@props(['status' => 'pending'])

@php
    $classes = 'inline-block rounded-full border px-2 py-1 text-xs font-medium';

    if ($status === 'pending') {
        $classes .= ' bg-amber-500/10 text-amber-500 border-amber-500/20';
    }

    if ($status === 'in_progress') {
        $classes .= ' bg-blue-500/10 text-blue-500 border-blue-500/20';
    }

    if ($status === 'completed') {
        $classes .= ' bg-primary/10 text-primary border-primary/20';
    }
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

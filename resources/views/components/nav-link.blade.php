@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors'
            : 'flex items-center gap-3 px-4 py-3 text-primary dark:text-inverse-primary font-bold border-r-4 border-primary dark:border-inverse-primary bg-surface-container-high transition-all';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

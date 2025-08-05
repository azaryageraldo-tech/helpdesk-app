@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 text-sm text-white bg-gray-700'
            : 'flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

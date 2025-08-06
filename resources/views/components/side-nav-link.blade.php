@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 text-sm text-white bg-gray-950' // Gaya link aktif
            : 'flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white'; // Gaya link normal
@endphp

<a {{ $attributes->merge(['class' => 'relative transition-colors duration-200']) }}>
    <!-- Indikator Garis Vertikal untuk Link Aktif -->
    <span class="{{ $active ? 'absolute inset-y-0 left-0 w-1 bg-indigo-500 rounded-r-lg' : 'hidden' }}" aria-hidden="true"></span>
    
    <div {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </div>
</a>

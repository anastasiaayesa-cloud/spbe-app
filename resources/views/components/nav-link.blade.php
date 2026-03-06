@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center w-full px-3 py-2 rounded-lg text-sm font-semibold text-indigo-700 bg-indigo-50 whitespace-nowrap'
    : 'flex items-center w-full px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-700 hover:bg-gray-100 whitespace-nowrap';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

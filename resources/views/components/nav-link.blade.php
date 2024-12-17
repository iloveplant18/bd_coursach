@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link inline-flex items-center pt-1 text-sm font-medium leading-5 text-gray-900 px-3 active'
            : 'nav-link inline-flex items-center pt-1 text-sm font-medium leading-5 text-gray-500 px-3 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

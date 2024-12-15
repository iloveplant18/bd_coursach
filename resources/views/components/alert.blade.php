@props(['type' => 'info'])

@php
@endphp

<div
    @class([
        "p-4 mb-4 text-sm rounded-lg",
        "border border-blue-400 bg-blue-50 text-blue-800 dark:bg-gray-800 dark:text-blue-400" => $type === 'info',
        "border border-red-400 text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400" => $type === 'danger',
        "border border-green-400 text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400" => $type === 'success',
        "border border-yellow-400 text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400" => $type === 'warning',
        "border border-gray-400 text-gray-800 bg-gray-50 dark:bg-gray-800 dark:text-gray-400" => $type === 'dark',
    ])
    role="alert"
>
    <span class="font-semibold">
        {{ $title }}
    </span>
    {{ $slot    }}
</div>

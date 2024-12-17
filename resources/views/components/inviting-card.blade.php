@props(['href'])

<article class="flex flex-col max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <a href="{{ $href }}">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $title }}
        </h5>
    </a>
    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
        {{ $slot }}
    </p>

    <x-alternative-button-or-link class="mt-auto w-fit" type="link" href="{{ $href }}" :withArrow="true">
        {{ $action }}
    </x-alternative-button-or-link>
</article>

@props(['services'])

<x-app-layout>
    <x-slot name="header">
        Available services
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto">
            <x-alert>
                <x-slot name="title">Want to order something?</x-slot>
                Just open one of your current or future bookings and click "add service" button!
            </x-alert>
            <ul class="space-y-2">
                @foreach($services as $service)
                    <li class="flex gap-x-3 justify-between items-center">
                        <span class="text-2xl">
                            {{ $service->Описание_услуги }}
                        </span>
                        <span class="text-xl">
                            {{ $service->Стоимость }}₽
                        </span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

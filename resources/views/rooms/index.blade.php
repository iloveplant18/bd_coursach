<x-app-layout>
    <x-slot name="header">
        Available rooms
    </x-slot>

    <form action="/rooms" method="get" class="flex flex-col items-center sm:flex-row justify-center align-center gap-4">
        <div>
            <x-datepicker
                class="block"
                name="start_date"
                id="start-datepicker"
                placeholder="Start date"
            />
            <x-input-error :messages="$errors->get('start_date')"/>
        </div>
        <div>
            <x-datepicker
                class="block"
                name="end_date"
                id="end-datepicker"
                placeholder="End date"
            />
            <x-input-error :messages="$errors->get('end_date')"/>
        </div>
        <x-dropdown>
            <x-slot name="trigger">
                <x-secondary-button type="button" title="click me">
                    Тип номера
                </x-secondary-button>
                <x-input-error :messages="$errors->get('room_type')"/>
            </x-slot>
            <x-slot name="content">
                <ul class="w-full flex flex-col items-stretch">
                    @foreach($roomTypes as $roomType)
                        <li class="w-full">
                            <label class="w-full py-1 px-3 flex justify-between has-[input:checked]:bg-gray-300" >
                                <span class="text-bold me-2">
                                    {{ $roomType->Название }}
                                </span>
                                <span>
                                    {{ $roomType->Цена_за_сутки }}
                                </span>
                                <input class="hidden" type="radio" name="room_type" value="{{ $roomType->Название }}"/>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </x-slot>
        </x-dropdown>
        <x-primary-button>
            Find
        </x-primary-button>
    </form>

    <ul class="mx-auto w-fit grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        @foreach($rooms as $room)
            <li>
                <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Room number: {{ $room->Номер_комнаты }}</h5>
                        <a href="rooms/{{$room->Номер_комнаты}}" class="ms-4 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                            View room
                        </a>
                    </div>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-1 min-w-0">
                                        <p class="flex justify-between gap-x-2 border-b-2 border-gray-300 last:border-0 text-sm font-medium text-gray-900 truncate dark:text-white">
                                            <span>Tarif:</span> <span>{{ $room->Название }}</span>
                                        </p>
                                        <p class="flex justify-between gap-x-2 border-b-2 border-gray-300 last:border-0 text-sm text-gray-500 truncate dark:text-gray-400">
                                            <span>Floor:</span> <span>{{ $room->Этаж }}</span>
                                        </p>
                                        <p class="flex justify-between gap-x-2 border-b-2 border-gray-300 last:border-0 text-sm text-gray-500 truncate dark:text-gray-400">
                                            <span>Persons:</span> <span>{{ $room->Количество_мест }}</span>
                                        </p>
                                    </div>
                                    <div class="ms-16 inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $room->Цена_за_сутки }}/day
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </li>
        @endforeach
    </ul>
</x-app-layout>

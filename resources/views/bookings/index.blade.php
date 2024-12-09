<x-app-layout>
    <x-slot name="header">
        Your bookings
    </x-slot>

    <section>
        <ul>
            @foreach($bookings as $booking)
                <li>
                    <div class="w-full p-4 flex flex-wrap gap-3 justify-between items-center text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <div class="items-center gap-4 flex flex-row">
                            Booking dates:
                            <div class="w-full sm:w-auto bg-gray-800 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                <div class="text-left rtl:text-right">
                                    <div class="mb-1 text-xs">Start date</div>
                                    <div class="-mt-1 font-sans text-sm font-semibold">{{ $booking->Дата_заезда }}</div>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto bg-gray-800  text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                <div class="text-left rtl:text-right">
                                    <div class="mb-1 text-xs">End date</div>
                                    <div class="-mt-1 font-sans text-sm font-semibold">{{ $booking->Дата_выезда }}</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl">
                                Room number <span class="font-bold">{{ $booking->Номер_комнаты }}</span>
                            </h2>
                            <x-link href="{{ route('rooms.show', $booking->Номер_комнаты) }}">
                                Jump to room
                            </x-link>
                        </div>
                        <div>
                            <h2 class="text-2xl">
                                Final cost
                            </h2>
                            <span>
                                {{ $booking->Стоимость }}₽
                            </span>
                        </div>
                        <x-alternative-button-or-link type="link" href="{{ route('bookings.edit', $booking->Номер_бронирования) }}">
                            Redact
                        </x-alternative-button-or-link>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </section>
</x-app-layout>

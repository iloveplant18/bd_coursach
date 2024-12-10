@props(['booking'])

@php
    $bookingType = null;
    if ($booking->Дата_выезда < now()) {
        $bookingType = 'past';
    }
    elseif ($booking->Дата_заезда < now()) {
        $bookingType = 'current';
    }
    else {
        $bookingType = 'future';
    }

@endphp
<div
    @class([
        "relative w-full p-4 overflow-hidden flex flex-wrap gap-3 justify-between items-center text-center border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700",
        'bg-gray-300' => ($bookingType === 'past'),
        'bg-white' => ($bookingType === 'current'),
        'bg-blue-100' => ($bookingType === 'future')
    ])
>
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
    <span class="absolute top-0 right-0 px-3 py-1 bg-gray-600 text-white rounded">
        @if ($bookingType === 'past')
            past booking
        @elseif($bookingType === 'current')
            current booking
        @else
            future booking
        @endif
    </span>
</div>

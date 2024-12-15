@php use Illuminate\Support\Facades\Http; @endphp
<x-app-layout>
    <x-slot name="header">
        Logovo Babushki - your favorite mini-hotel
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @auth()
                @can('do-client-action')
                    @if($nearestBooking)
                        <div class="p-6 flex flex-col gap-y-4 justify-between items-center gap-x-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 md:flex-row ">
                            <span class="text-3xl">Nearest booking:</span>
                            <div class="flex items-center gap-x-4">
                                <span class="text-nowrap">{{ $nearestBooking->Дата_заезда }}</span>-<span class="text-nowrap">{{ $nearestBooking->Дата_выезда }}</span>
                                <x-alternative-button-or-link class="text-nowrap" type="link" href="{{ route('bookings') }}">
                                    To bookings
                                </x-alternative-button-or-link>
                            </div>
                            <div class="flex items-center gap-x-4">
                                <span>Room number: {{ $nearestBooking->Номер_комнаты }}</span>
                                <x-alternative-button-or-link class="text-nowrap" type="link" href="{{ route('rooms.show', $nearestBooking->Номер_комнаты) }}">
                                    To room
                                </x-alternative-button-or-link>
                            </div>
                        </div>
                    @endif
                @endcan
            @endauth

            <div class="mt-8 grid justify-center md:grid-cols-3 gap-8">
                <article class="flex flex-col max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('tariffs') }}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Tariffs</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        Checkout our tariffs to know about actual prices
                    </p>

                    <x-alternative-button-or-link class="mt-auto w-fit" type="link" href="{{ route('tariffs') }}" :withArrow="true">
                        Checkout
                    </x-alternative-button-or-link>
                </article>

                <article class="flex flex-col max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('rooms') }}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Rooms</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        Jump to rooms page and see all our available rooms to choose from
                    </p>
                    <x-alternative-button-or-link class="mt-auto w-fit" type="link" href="{{ route('rooms') }}" :withArrow="true">
                        Jump
                    </x-alternative-button-or-link>
                </article>
            </div>

        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        Logovo Babushki - your favorite
        @can('do-personal-action')
            employer
        @else
            mini-hotel
        @endcan
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

            @cannot('do-personal-action')
                <div class="mt-8 grid justify-center md:grid-cols-3 gap-8">
                    <x-inviting-card :href="route('tariffs')">
                        <x-slot:title>
                            Tariffs
                        </x-slot:title>
                        Checkout our tariffs to know about actual prices
                        <x-slot:action>
                            Checkout
                        </x-slot:action>
                    </x-inviting-card>

                    <x-inviting-card :href="route('rooms')">
                        <x-slot:title>
                            Rooms
                        </x-slot:title>
                        Jump to rooms page and see all our available rooms to choose from
                        <x-slot:action>
                            Jump
                        </x-slot:action>
                    </x-inviting-card>
                </div>
            @endcannot

            @auth()
                @can('do-personal-action')
                    Hi, {{ Auth::user()->name }}, let's do a good job today. There is a part of today tasks:
                    <div>
                        @if ($todayInclusions->isEmpty())
                            <x-alert class="mt-4">
                                <x-slot:title>
                                    Halyava!
                                </x-slot:title>
                                No tasks at the moment! Get some tea and relax
                            </x-alert>
                        @else
                            <ul class="mt-4 flex flex-col gap-5">
                                @foreach($todayInclusions as $inclusion)
                                    <li>
                                        <x-inclusion
                                            :number="$inclusion->Номер_применения"
                                            :name="$inclusion->service->Описание_услуги"
                                            :date="$inclusion->Дата_включения"
                                            :room="$inclusion->booking->Номер_комнаты"
                                            :clientName="$inclusion->booking->client->user->name"
                                        />
                                    </li>
                                @endforeach
                            </ul>
                            <x-alternative-button-or-link
                                class="mt-4"
                                type="link"
                                :href="route('inclusions.index')"
                                withArrow
                            >
                                See all
                            </x-alternative-button-or-link>
                        @endif
                    </div>
                @endcan
                @can('do-admin-action')
                    <div class="mt-8 grid justify-center md:grid-cols-3 gap-8">
                        <x-inviting-card :href="route('statistics')">
                            <x-slot:title>
                                Statistics
                            </x-slot:title>
                            Analyze various statistics about anything that going on at <mini-></mini->hotel
                            <x-slot:action>
                                Analyze
                            </x-slot:action>
                        </x-inviting-card>
                    </div>
                @endcan
            @endauth
        </div>
    </div>
</x-app-layout>

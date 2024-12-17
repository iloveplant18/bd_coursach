<x-app-layout>
    <x-slot:header>
        Statistics
    </x-slot:header>

    <section>
        <section>
            <h2 class="sr-only">
                Statistics
            </h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <x-alert class="flex">
                    <x-slot:title>
                        Booking cancellation percent
                    </x-slot:title>
                    <div class="ml-auto">
                        {{ $cancellationPercentage }}%
                    </div>
                </x-alert>
                <x-alert class="flex">
                    <x-slot:title>
                        Most popular service
                    </x-slot:title>
                    <div class="ml-auto">
                        {{ $mostPopularService['name'] }}
                    </div>
                </x-alert>
                <x-alert class="flex">
                    <x-slot:title>
                        Count of most popular service
                    </x-slot:title>
                    <div class="ml-auto">
                        {{ $mostPopularService['count'] }}
                    </div>
                </x-alert>
                <x-alert class="flex">
                    <x-slot:title>
                        Layoff percentage
                    </x-slot:title>
                    <div class="ml-auto">
                        {{ $layoffPercentage }}%
                    </div>
                </x-alert>
            </div>
        </section>
        <section>
            <h2 class="text-lg">
                Unpaid bookings:
            </h2>
            <div class="mt-2">
                @if($unpaidBookings)
                    <ul>
                        @foreach($unpaidBookings as $booking)
                            <li class="flex flex-wrap gap-2 justify-between items-center bg-gray-200 border border-gray-300 py-2 px-4 rounded-lg">
                                <span>
                                    Client: {{ $booking->client->user->name }}
                                </span>
                                <span>
                                    Start date: {{ $booking->Дата_заезда }}
                                </span>
                                <span>
                                    End date: {{ $booking->Дата_выезда }}
                                </span>
                                <span>
                                    Room: {{ $booking->Номер_комнаты }}
                                </span>
                                <span>
                                    Total cost: {{ $booking->Стоимость }}
                                </span>
                                <span>
                                    Debt: {{ $booking->Стоимость - $booking->payments_sumсумма }}
                                </span>
                                <x-alternative-button-or-link
                                    type="link"
                                    :href="route('bookings.show', $booking->Номер_бронирования)"
                                    withArrow
                                >
                                    Go to booking
                                </x-alternative-button-or-link>
                                <form
                                    action="{{ route('payment.store', $booking->Номер_бронирования) }}"
                                    method="post"
                                >
                                    @csrf
                                    <x-text-input name="money" value="0" type="number"/>
                                    <x-primary-button>
                                        Внести сумму
                                    </x-primary-button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    Nothing to show`
                @endif
            </div>
        </section>
    </section>
</x-app-layout>

@props(['booking'])

@php
    $bookingType = $booking->Дата_выезда < now()->format('Y-m-d') ? 'past' : 'not past'
@endphp

<x-app-layout>
    <x-slot:header>
        Booking
    </x-slot:header>

    <div class="">
        {{-- Даты заезда-выезда --}}
        <h2 class="text-xl sm:text-3xl">
            You booked room {{ $booking->Номер_бронирования }} at this period: <wbr/>
            <span class="text-nowrap">
                <span class="font-bold">{{ $booking->Дата_заезда }}</span> -
                <span class="font-bold">{{ $booking->Дата_выезда }}</span>
            </span>
        </h2>
        <section class="mt-8 grid gap-3 xl:grid-cols-2">
            <div class="flex flex-col gap-y-3">
                {{-- Дата создания бронирования --}}
                <div>
                    Creation date:
                    <span class="font-bold">
                        {{ $booking->Дата_совершения_бронирования }}
                    </span>
                </div>
            {{-- Ссылка на комнату --}}
                <div>
                    Checkout your room:
                    <x-alternative-button-or-link
                        type="link"
                        :href="route('rooms.show', $booking->Номер_комнаты)"
                        withArrow
                    >
                        Checkout
                    </x-alternative-button-or-link>
                </div>
            {{-- Тариф --}}
                <div>
                    Tariff for this room:
                    <span class="font-bold">
                        {{ $booking->room->tariff->Название }},
                        {{ $booking->room->tariff->Цена_за_сутки }}/per day
                    </span>
                </div>
            {{-- Итоговая стоимость бронирования --}}
                <div>
                    Total cost:
                    <span class="font-bold">
                        {{ $booking->Стоимость }}
                    </span>
                </div>
            {{-- Закрепленный за бронированием администратор --}}
                <div>
                    <x-alert>
                        <x-slot:title>
                            Notice.
                        </x-slot:title>
                        If you experience any problem you can ask your booking manager to help
                    </x-alert>
                    Your booking manager:
                    <span class="font-bold">
                        {{ $booking->personal->ФИО }}
                    </span>
                </div>
            {{-- Ссылка на редактирование --}}
                @if($bookingType !== 'past')
                    <div>
                        <x-alert type="warning">
                            <x-slot:title>
                                Edit your dates
                            </x-slot:title>
                            You can edit dates of booking if its future, or the end date if its current booking
                        </x-alert>
                        Link to edition page:
                        <x-alternative-button-or-link
                            type="link"
                            :href="route('bookings.edit', $booking->Номер_бронирования)"
                            withArrow
                        >
                            Edit
                        </x-alternative-button-or-link>
                    </div>
                @endif
            </div>
        {{-- Управление услугами (поиск, заказ, удаление если еще не выполнена) --}}
            <div>
                @if($bookingType === 'not past')
                    <x-alert>
                        <x-slot:title>
                            Services
                        </x-slot:title>
                        You can add any services to this booking
                    </x-alert>
                    <x-alternative-button-or-link
                        type="link"
                        :href="route('inclusions.create', $booking->Номер_бронирования)"
                        withArrow
                    >
                        Order service
                    </x-alternative-button-or-link>
                @else
                    <x-alert type="danger">
                        <x-slot:title>
                            Booking is past
                        </x-slot:title>
                        You can not add and delete services to this booking
                    </x-alert>
                @endif
                <h3 class="text-xl text-center">
                    Your services for this booking:
                </h3>
                <ul class="mt-4 flex flex-col gap-y-1">
                    @foreach($booking->inclusions as $inclusion)
                        <li>
                            <form
                                method="post"
                                action="{{ route('inclusions.destroy', $booking->Номер_бронирования) }}"
                                class="py-2 px-4 flex justify-between items-center bg-gray-300 rounded-lg"
                            >
                                @csrf
                                @method('delete')
                                <input class="hidden" type="number" name="inclusion_number" value="{{$inclusion->Номер_применения}}" />
                                <span>
                                    {{ $inclusion->service->Описание_услуги }}
                                </span>
                                <span>
                                    {{ $inclusion->service->Стоимость }}
                                </span>
                                <span>
                                    {{ $inclusion->Дата_включения }}
                                </span>
                                @if($inclusion->Дата_включения >= now()->format('Y-m-d') && !$inclusion->realization)
                                    <x-secondary-button type="submit">
                                        remove
                                    </x-secondary-button>
                                @elseif($inclusion->realization)
                                    Completed
                                @else
                                    Failed
                                @endif
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

    </div>
</x-app-layout>

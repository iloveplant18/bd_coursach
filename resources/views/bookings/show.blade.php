@props(['booking'])

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
        <section class="mt-8 flex flex-col gap-y-3">
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
        </section>
        {{-- Закрепленный за бронированием администратор --}}
        {{-- Ссылка на редактирование --}}
        {{-- Управление услугами (поиск, заказ, удаление если еще не выполнена) --}}

    </div>
</x-app-layout>

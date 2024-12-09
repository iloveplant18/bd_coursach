<x-app-layout>
    <x-slot name="header">
        Room info
    </x-slot>

    <div class="max-w-5xl mx-auto grid sm:grid-cols-5 gap-20">
        <div class="col-span-3 grid grid-cols-2 gap-5 h-fit">
            <h2 class="pb-2 col-span-2 text-5xl font-bold border-b-2 border-gray-300">
                Room number {{ $room->Номер_комнаты }}
            </h2>
            <div class="grid grid-cols-subgrid col-span-2 border-b-2 border-gray-200">
                <span>
                    Floor:
                </span>
                <span class="text-right">
                    {{ $room->Этаж }}
                </span>
            </div>
            <div class="grid grid-cols-subgrid col-span-2 border-b-2 border-gray-200">
                <span>
                    Persons:
                </span>
                <span class="text-right">
                    {{ $room->Количество_мест }}
                </span></div>
            <div class="grid grid-cols-subgrid col-span-2 border-b-2 border-gray-200">
                <span>
                    Tariff:
                </span>
                <span class="text-right">
                    {{ $room->Название }}
                </span></div>
            <div class="grid grid-cols-subgrid col-span-2 border-b-2 border-gray-200">
                <span>
                    Cost per dat:
                </span>
                <span class="text-right">
                    {{ $room->Цена_за_сутки }}
                </span>
            </div>
        </div>
        <form action='{{ route("bookings.store") }}' method="post" class="col-span-2 flex flex-col gap-y-5">
            @csrf
            <h2 class="pb-2 text-5xl font-bold border-b-2 border-gray-300">
                Booking
            </h2>
            <x-text-input class="hidden" name="room_id" value="{{ $room->Номер_комнаты }}"/>
            <x-text-input class="hidden" name="is_available_at_period" value=""/>
            <x-input-error class="mt-1" :messages="$errors->get('is_available_at_period')"/>
            <div>
                <x-datepicker
                    name="start_date"
                    id="start-datepicker"
                    placeholder="Start date"
                    type="text"
                    :value="old('start_date')"
                />
                <x-input-error class="mt-1" :messages="$errors->get('start_date')"/>
            </div>
            <div>
                <x-datepicker
                    name="end_date"
                    id="end-datepicker"
                    placeholder="End date"
                    type="text"
                    :value="old('end_date')"
                />
                <x-input-error class="mt-1" :messages="$errors->get('end_date')"/>
            </div>
            <x-primary-button class="justify-center">
                Забронировать
            </x-primary-button>
        </form>
    </div>
</x-app-layout>

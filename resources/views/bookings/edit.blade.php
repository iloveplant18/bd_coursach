@props(['booking'])

@php
$booking->Дата_заезда = \Illuminate\Support\Carbon::parse($booking->Дата_заезда)->format('m/d/Y');
$booking->Дата_выезда = \Illuminate\Support\Carbon::parse($booking->Дата_выезда)->format('m/d/Y');
@endphp

<x-app-layout>
    <x-slot name="header">
        Redact booking
    </x-slot>

    <form action="{{ route('bookings.update', $booking->Номер_бронирования) }}" method="post" class="flex flex-col gap-y-4">
        @csrf
        @method('patch')
        <input class="hidden" type="text" name="is_available_at_period" />
        <x-input-error :messages="$errors->get('is_available_at_period')" />
        <x-input-error :messages="$errors->get('booking')" />
        <div class="sm:col-span-6">
            <x-input-label for="start_date" value="Start date" />
            <x-datepicker
                id="start_date"
                name="start_date"
                class="mt-1"
                :value="str_replace('-', '/', $booking->Дата_заезда)"
            />
            <x-input-error :messages="$errors->get('start_date')" />
        </div>
        <div class="sm:col-span-6">
            <x-input-label for="end_date" value="End date" />
            <x-datepicker
                id="end_date"
                name="end_date"
                class="mt-1"
                :value="str_replace('-', '/', $booking->Дата_выезда)"
            />
            <x-input-error :messages="$errors->get('end_date')" />
        </div>
        <div class="flex mt-3 items-center gap-x-4">
            <x-danger-button class="me-auto" form="destroy-form">
                Delete
            </x-danger-button>
            <x-link :href="route('bookings')">
                Cancel
            </x-link>
            <x-primary-button>
                Save
            </x-primary-button>
        </div>
    </form>

    <form id="destroy-form" method="post" action="{{route('bookings.destroy', $booking->Номер_бронирования)}}">
        @csrf
        @method('delete')
    </form>
</x-app-layout>

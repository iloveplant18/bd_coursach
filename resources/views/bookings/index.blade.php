<x-app-layout>
    <x-slot name="header">
        Your bookings
    </x-slot>

    <section>
        <ul>
            @foreach($bookings as $booking)
                <li>
                    <x-booking :booking="$booking" />
                </li>
            @endforeach
        </ul>
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </section>
</x-app-layout>

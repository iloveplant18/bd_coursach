@props(['services', 'booking'])

<x-app-layout>
    <x-slot:header>
        Ordering services for booking at {{$booking->Дата_заезда}} - {{$booking->Дата_выезда}}
    </x-slot:header>

    <section class="max-w-5xl mx-auto">

        <div class="flex justify-center items-center gap-x-2">
            @csrf
            Enter a date when you want to order this service:
            <x-datepicker
                name="service_date"
                id="service-date"
                placeholder="Service date"
                :value="old('service_date')"
            />
        </div>
        <div class="text-center">
            <x-input-error :messages="$errors->get('service_date')"/>
            <x-input-error :messages="$errors->get('service_code')"/>
        </div>
        <ul class="flex flex-col gap-y-2">
            @foreach($services as $service)
                <li>
                    <form
                        class="flex justify-between items-center"
                        method="post"
                        action="{{route('inclusions.store', $booking->Номер_бронирования)}}"
                    >
                        @csrf
                        {{ $service->Описание_услуги }}
                        <input
                            class="hidden"
                            name="service_code"
                            type="text"
                            value="{{$service->Код_услуги}}"
                        />
                        <span class="flex items-center gap-x-2">
                            {{ $service->Стоимость }}
                            <x-primary-button>
                                order
                            </x-primary-button>
                        </span>
                    </form>
                </li>
            @endforeach
        </ul>
        <div class="mt-4">
            {{ $services->links() }}
        </div>
    </section>


    <script>
        document.addEventListener('submit', function (event) {
            event.preventDefault()
            let date = document.querySelector('#service-date').value
            let input = document.createElement('input')
            input.type = 'text'
            input.setAttribute('hidden', 'hidden')
            input.value = date
            input.name = 'service_date'
            event.target.append(input)
            event.target.submit()
        })
    </script>
</x-app-layout>

    <x-app-layout>
    <x-slot name="header">
        Tariffs and pricing
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <ul class=" flex flex-col">
            @foreach($tariffs as $tariff)
                <li class="w-full p-4 flex justify-between items-center border-b-2 border-gray-300 last:border-0">
                    <span class="text-2xl">{{ $tariff->Название }}</span>
                    <span>{{ $tariff->Цена_за_сутки }}/day</span>
                </li>
            @endforeach
        </ul>
    </div>

</x-app-layout>

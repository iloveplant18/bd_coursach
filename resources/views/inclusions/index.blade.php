<x-app-layout>
    <x-slot:header>
        Ordered services
    </x-slot:header>

    <section>
        <header class="flex flex-wrap gap-x-10 gap-y-4">
            Sorting:
            <form
                action=""
                method="get"
                class="flex flex-wrap gap-x-10 gap-y-3 items-center"
            >
                <fieldset>
                    <header>
                        Date:
                    </header>
                    <div class="flex gap-x-4">
                        <x-input-label class="flex w-fit items-center gap-x-2">
                            <x-checkbox
                                name="future"
                                value="true"
                            />
                            Future
                        </x-input-label>
                        <x-input-label class="flex w-fit items-center gap-x-2">
                            <x-checkbox
                                name="today"
                                value="true"
                            />
                            Today
                        </x-input-label>
                        <x-input-label class="flex w-fit items-center gap-x-2">
                            <x-checkbox
                                name="passed"
                                value="true"
                            />
                            Passed
                        </x-input-label>
                    </div>
                </fieldset>
                <fieldset>
                    <header>
                        Show only my realized services:
                    </header>
                    <x-input-label class="flex w-fit items-center gap-x-2">
                        <x-checkbox
                            name="currentPersonal"
                            value="true"
                        />
                        Show
                    </x-input-label>
                </fieldset>
                <x-primary-button>
                    sort
                </x-primary-button>
            </form>

            <div>
                Legend:
                <ul class="flex gap-2">
                    <li class="flex items-center">
                        <span class="w-4 inline-block mr-1 aspect-square bg-red-300"></span>
                        <span>
                            Failed
                        </span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-4 inline-block mr-1 aspect-square bg-green-300"></span>
                        <span>
                            Completed
                        </span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-4 inline-block mr-1 aspect-square bg-gray-300"></span>
                        <span>
                            Current
                        </span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-4 inline-block mr-1 aspect-square bg-blue-300"></span>
                        <span>
                            Future
                        </span>
                    </li>
                </ul>
            </div>
        </header>

        <ul class="mt-4 flex flex-col gap-2">
            @foreach($inclusions as $inclusion)
                <li>
                    @php
                        $type = 'future';
                        $currentDate = now()->format('Y-m-d');
                        if ($inclusion->realization) {
                            $type = 'completed';
                        } elseif ($inclusion->Дата_включения < $currentDate) {
                            $type = 'failed';
                        } elseif ($inclusion->Дата_включения === $currentDate) {
                            $type = 'current';
                        }

                    @endphp
                    <x-inclusion
                        :number="$inclusion->Номер_применения"
                        :name="$inclusion->service->Описание_услуги"
                        :date="$inclusion->Дата_включения"
                        :room="$inclusion->booking->Номер_комнаты"
                        :clientName="$inclusion->booking->client->user->name"
                        :type="$type"
                        :executor="$inclusion->realization?->personal->user->name"
                    />
                </li>
            @endforeach
        </ul>
        <div class="mt-4">
            {{ $inclusions->links() }}
        </div>
    </section>
</x-app-layout>

@props(['number', 'name', 'date', 'room', 'clientName', 'type' => 'current', 'executor' => null])

<article @class([
    'relative rounded-lg pt-7 sm:pt-4 border p-4 overflow-hidden',
    'bg-gray-50 border-gray-300' => $type === 'current',
    'bg-green-50 border-green-300' => $type === 'completed',
    'bg-red-50 border-red-300' => $type === 'failed',
    'bg-blue-50 border-blue-300' => $type === 'future',
])>
    @if ($type === 'future')
        <span class="bg-gray-600 px-2 text-sm text-white rounded-bl-lg absolute top-0 right-0">
            future
        </span>
    @endif
    <div class="flex items-center justify-between">
        <span>
            Service requested: <span class="font-bold">{{ $name }}</span>    at room {{ $room }}
        </span>
        <span>
            Date of ordering: {{ $date }}
        </span>
        <span>
            Client name: {{ $clientName }}
        </span>
        @if($executor)
        <span>
            Executor: {{ $executor }}
        </span>
        @endif
        @if ($type === 'current')
            <form action="{{route('realizations.store', $number)}}" method="post">
                @csrf
                <x-secondary-button type="submit">
                    Complete
                </x-secondary-button>
            </form>
        @endif
    </div>
</article>

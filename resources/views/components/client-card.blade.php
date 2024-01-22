<a href="{{ route('clients.show', $client->id) }}"
    class="{{ $client->status == 1
        ? 'bg-orange-300'
        : ($client->waitlist == 1
            ? 'bg-blue-300'
            : ($client->special_sessions > 0
                ? 'bg-purple-300'
                : 'bg-green-300')) }} min-h-content relative z-0 m-2 flex flex-row justify-between rounded-lg border border-blue-200 p-2 shadow-md shadow-blue-100 transition-all duration-200 ease-in hover:border hover:border-blue-500 hover:shadow-lg"
    style="z-index: 1;">
    <div class="-mt-1.5 flex flex-col justify-between p-1">
        <p class="capitalize">{{ $client->client_code }}</p>
        {{-- <p class="text-right text-sm">{{ $client->pronouns }}</p> --}}
        @if ($user->admin)
            <div class="flex flex-row justify-between p-1">
                <p class="text-left text-sm">Therapist:
                    {{ $client && $client->user && $client->user->preferred_name ? $client->user->preferred_name : ($client && $client->user ? $client->user->name : '') }}
                </p>
            </div>
        @endif
    </div>
    <div class="-mb-1 p-1 text-xs">
        <p class="text-left text-xs">
            Sessions: {{ $client->therapySessions->whereIn('attendance', ['no-show', 'attended'])->count() }}
            <span class="text-xs text-gray-600">/</span>
            {{ $client->max_sessions }}
        </p>
        <p><span
                class="mr-2 text-green-700">{{ $client->therapySessions->whereIn('attendance', 'attended')->count() }}</span>Attended
        </p>

        <p><span class="mr-2 text-red-500">
                {{ $client->therapySessions->whereIn('attendance', 'no-show')->count() }}</span>No show</p>
        <p><span class="mr-2 text-yellow-700">
                {{ $client->therapySessions->whereIn('attendance', 'canceled')->count() }}</span>Canceled</p>
    </div>
</a>

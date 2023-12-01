<a href="{{ route('clients.show', $client->id) }}" class="relative z-0 flex flex-col justify-between p-2 m-2 transition-all duration-200 ease-in {{ $client->status == 1 ? 'bg-orange-300' : 'bg-green-300' }} border border-blue-200 rounded-lg shadow-md min-h-content shadow-blue-100 hover:border hover:border-blue-500 hover:shadow-lg" style="z-index: 1;">

    <div class="-mt-1.5 flex w-full flex-row justify-between p-1">
        <p class="capitalize">{{ $client->client_code }}</p>
        <p class="text-sm text-right">{{ $client->pronouns }}</p>
    </div>
    @if ($user->admin)
    <div class="flex flex-row justify-between p-1">
        <p class="text-sm text-left">Therapist: {{ $client->user->preferred_name ? $client->user->preferred_name : $client->user->name }}</p>
    </div>
    @endif
    <div class="p-1 -mb-1 text-xs">
        <p class="text-xs text-left">
            Sessions: {{ $client->therapySessions->whereIn('attendance',  ['no-show', 'attended'])->count() }}
            <span class="text-xs text-gray-600">/</span>
            {{ $client->max_sessions }}
        </p>
        <p><span class="mr-2 text-green-700">{{ $client->therapySessions->whereIn('attendance',  'attended')->count() }}</span>Attended</p>

        <p><span class="mr-2 text-red-500"> {{ $client->therapySessions->whereIn('attendance',  'no-show')->count() }}</span>No show</p>
        {{-- do the canceled --}}
        <p><span class="mr-2 text-yellow-700"> {{ $client->therapySessions->whereIn('attendance',  'canceled')->count() }}</span>Canceled</p>
    </div>
</a>

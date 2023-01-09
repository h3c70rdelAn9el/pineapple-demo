<a href="{{ route('clients.show', $client->id) }}"
    {{-- class="flex flex-col justify-between w-full h-20 p-2 m-2 text-center transition-all duration-200 ease-in bg-blue-200 border border-transparent rounded-md shadow-md group shadow-blue-100 hover:border hover:border-blue-500 hover:shadow-lg"> --}}
      class="relative flex flex-col justify-between w-full h-20 p-2 m-2 transition-all duration-200 ease-in bg-blue-200 border border-blue-200 rounded-lg shadow-md shadow-blue-100 hover:border hover:border-blue-500 hover:shadow-lg">

    <div class="flex flex-row justify-between w-full p-1">
        <p class="capitalize">{{ $client->chosen_name }}</p>
        <p class="text-sm text-right">{{ $client->pronouns }}</p>
    </div>
    <div class="p-1">
        <p class="text-xs text-left">
            Sessions: {{ $client->therapySessions->count() }}
            <span class="text-xs text-gray-600">/</span>
            {{ $client->max_sessions }}
        </p>
    </div>

    @if ($user->admin)
        <div class="ml-1 text-left">
            <p class="text-sm">Therapist: {{ $therapist->name }}</p>
        </div>
    @endif

</a>

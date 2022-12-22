<a href="{{ route('clients.show', $client->id) }}"
    class="flex flex-col justify-between w-full p-2 m-2 text-center transition-all duration-200 ease-in bg-blue-200 border border-transparent rounded-md shadow-md hover:border hover:border-blue-500 shadow-blue-100 hover:shadow-lg">
    <div
        class="flex flex-row justify-between w-full p-1">
        <p class="capitalize ">{{ $client->chosen_name }}</p>
        <p class="text-sm text-right">{{ $client->pronouns }}</p>
    </div>
    <div class="flex flex-col text-xs text-left">
        {{-- TODO:  ADD THERAPIST --}}
        {{-- <p>Therapist:</p> --}}
        {{-- <p>{{ $therapist }}</p> --}}
        {{-- {{ $therapist->name }} --}}
    </div>
</a>

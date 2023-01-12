<a href="{{ route('therapist.show', $therapist->id) }}"
    class="relative w-full p-2 m-2 transition-all duration-200 ease-in border border-blue-200 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:border hover:border-blue-400 hover:shadow-lg">
    {{-- <div
        class="flex flex-row justify-between w-full h-full p-2 text-center transition-all duration-200 ease-in bg-blue-200 rounded-md shadow-md shadow-blue-100 hover:shadow-lg" > --}}
    <div class="flex flex-row justify-between w-full ml-1">

        <p class="ml-2 capitalize">
            {{ $therapist->name }}
        </p>
        <p class="inline-block mr-2">
            Clients:
            <span class="">{{ $therapist->clients->count() }}</span>
        </p>

    </div>
</a>

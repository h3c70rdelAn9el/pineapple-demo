<a href="{{ route('therapist.show', $therapist->id) }}"
    class="h-16 m-2 text-center lg:h-12">
    <div
        class="flex flex-row justify-between w-full h-full p-2 text-center transition-all duration-200 ease-in bg-blue-200 rounded-md shadow-md shadow-blue-100 hover:shadow-lg" >
        <p class="ml-2 capitalize ">
            {{ $therapist->name }}
        </p>
        <p class="inline-block mr-2">
            Clients:
            <span class="">{{ $therapist->clients->count() }}</span>
        </p>

    </div>
</a>

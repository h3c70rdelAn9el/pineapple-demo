<a href="{{ route('therapist.show', $therapist->id) }}"
    class="h-16 m-2 text-center lg:h-12">
    <div
        class="flex flex-row w-full h-full p-2 text-center transition-all duration-200 ease-in bg-blue-200 rounded-md shadow-md lg:w-40 shadow-blue-100 hover:shadow-lg" >
        <p class="m-auto text-center capitalize">
            {{ $therapist->name }}
        </p>
    </div>
</a>

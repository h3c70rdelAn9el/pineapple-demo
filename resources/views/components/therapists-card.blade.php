<a href="{{ route('therapist.show', $therapist->id) }}"
    class="flex flex-row">
    <div
        class="flex flex-row w-40 p-2 m-2 text-center transition-all duration-200 ease-in bg-blue-200 rounded-md shadow-md shadow-blue-100 hover:scale-105 hover:shadow-lg">
        <p class="text-center capitalize">
            {{ $therapist->name }}
        </p>
    </div>
</a>

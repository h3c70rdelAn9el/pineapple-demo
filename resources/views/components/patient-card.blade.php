<a href="{{ route('patient', $patient->id) }}"
    class="flex flex-row">
    <div
        class="relative w-full p-2 m-2 duration-200 bg-blue-200 border border-blue-300 rounded-lg shadow-md lg:w-44 shadow-blue-100 hover:shadow-lg">

        <p class="text-center capitalize">{{ $patient->first }} {{ $patient->last }}</p>
    </div>
</a>

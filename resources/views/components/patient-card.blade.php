<a href="{{ route('patient', $patient->id) }}"
    class="flex flex-row">
    <div
        class="flex flex-row w-40 p-2 m-2 text-center transition-all duration-200 ease-in rounded-md shadow-md bg-blue-50 shadow-blue-100 hover:scale-105 hover:shadow-lg hover:shadow-blue-200">
        <p class="text-center capitalize">{{ $patient->first }} {{ $patient->last }}</p>
    </div>
</a>

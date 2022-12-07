<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-11/12 mx-auto border border-blue-500 shadow-lg max-w-7xl rounded-xl shadow-blue-100 sm:px-6 lg:px-8">
        <section class="flex flex-row items-center w-full max-w-5xl mx-auto justify-evenly md:flex-row md:justify-between">
            <div class="p-4 text-center capitalize bg-white shadow-sm sm:rounded-lg">
                <p class="text-lg md:text-xl">Welcome<span class="font-bold"> {{ $user->name }}</span></p>
            </div>

            <x-clock></x-clock>
            <div class="hidden p-4 text-center bg-white rounded-lg shadow-sm md:block">
                Total Patients: {{ $patients->count() }}
            </div>
            <div>
        </section>
        <div class="flex">
            <div class="p-4 mx-auto text-center bg-white shadow-lg rounded-xl md:hidden md:text-lg">
                Total Patients: {{ $patients->count() }}
            </div>
        </div>


        <h3 class="mt-3 text-lg font-bold text-center">Patients:</h3>
        <div class="flex flex-row flex-wrap justify-center">
            @foreach ($patients as $patient)
                {{-- <a href="{{ route('patient', ['patient' => $patient, 'patient_id' => $patient->id]) }}"
                    class="flex flex-row">
                    <div
                        class="flex flex-row w-40 p-2 m-2 text-center transition-all duration-200 ease-in rounded-md shadow-md bg-blue-50 shadow-blue-100 hover:scale-105 hover:shadow-lg hover:shadow-blue-200">
                        <p class="text-center capitalize">{{ $patient->first }} {{ $patient->last }}</p>
                    </div>
                </a> --}}
                @include('components.patient-card')
            @endforeach
        </div>


        <div class="w-5/6 p-2 mx-auto mt-2 rounded-md shadow-md bg-blue-50 shadow-blue-100 lg:w-1/2">
            <p class="text-lg font-bold">Add New Patient:</p>
            <x-dashboard-form></x-dashboard-form>
        </div>

    </div>
</x-app-layout>

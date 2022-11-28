<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-2 capitalize bg-white shadow-lg shadow-blue-100 sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <p class="text-xl">welcome<span class="font-bold"> {{ $user->name }}</span></p>
            </div>

            <div class="w-5/6 p-2 mx-auto mt-2 rounded-md shadow-md bg-blue-50 lg:w-1/2 shadow-blue-100">
                <p class="text-lg font-bold">Add New Patient:</p>
                <form action="{{ route('patient.store') }}" class="p-4">
                    @csrf
                    <div>
                        <label for="first">first</label>
                        <input type="text"
                            id="first"
                            name="first"
                            class="form-input"
                            >
                    </div>
                    <div>
                        <label for="last">last</label>
                        <input type="text"
                            id="last"
                            name="last"
                            class="form-input"
                            >
                    </div>
                    <div>
                        <label for="email">email</label>
                        <input type="text"
                            id="email"
                            name="email"
                            class="form-input"
                            >
                    </div>
                    <div>
                        <label for="phone">phone</label>
                        <input type="text"
                            id="phone"
                            name="phone"
                            class="form-input"
                            >
                    </div>
                    <div>
                        <label for="insurance">insurance</label>
                        <input type="text"
                            id="insurance"
                            name="insurance"
                            class="form-input">
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110">
                            Add
                        </button>
                    </div>

                </form>
            </div>

            <h3 class="mt-3 text-lg font-bold text-center">Patients:</h3>
            <div class="flex flex-row flex-wrap justify-center">
                @foreach ($patients as $patient)
                    <a href="{{ route('patient', ['patient' => $patient, 'patient_id' => $patient->id]) }}"
                        class="flex flex-row">
                        <div
                            class="flex flex-row w-40 p-2 m-2 text-center transition-all duration-200 ease-in rounded-md shadow-md shadow-blue-100 bg-blue-50 hover:scale-105 hover:shadow-blue-200 hover:shadow-lg">
                            <p class="text-center capitalize ">{{ $patient->first }} {{ $patient->last }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

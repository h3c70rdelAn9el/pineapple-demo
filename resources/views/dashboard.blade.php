<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <p class="text-xl">welcome<span class="font-bold"> {{ $user->name }}</span></p>
            </div>

                <div class="flex flex-row">
                    @foreach ($patients as $patient)
                    <div class="flex flex-row w-40 p-2 m-2 transition-all duration-200 ease-in rounded-md shadow-md hover:scale-105 hover:shadow-lg">
                        <a href="{{ route('patient', ['patient' => $patient, 'patient_id' => $patient->id]) }}" class="flex flex-row">
                            <p class="flex flex-row">{{ $patient->first }} {{ $patient->last }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>

            <form
                action="{{ route('patient.store') }}">
                @csrf
                <div>
                    <label for="first">first</label>
                    <input type="text" id="first" name="first">
                </div>
                <div>
                    <label for="last">last</label>
                    <input type="text" id="last" name="last">
                </div>
                <div>
                    <label for="email">email</label>
                    <input type="text" id="email" name="email">
                </div>
                <div>
                    <label for="phone">phone</label>
                    <input type="text" id="phone" name="phone">
                </div>
                <div>
                    <label for="insurance">insurance</label>
                    <input type="text" id="insurance" name="insurance">
                </div>
                <button type="submit">
                    Add
                </button>

            </form>
        </div>
    </div>
</x-app-layout>

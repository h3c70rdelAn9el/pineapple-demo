<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 capitalize">
            {{ __('Patient: ') }}<span class="font-bold">{{ $patient->first }} {{ $patient->last }}</span>
        </h2>
    </x-slot>

    <div class="w-5/6 p-2 mx-auto mt-2 mb-2 rounded-md shadow-md bg-blue-50 shadow-blue-100 lg:w-1/2">
        <form action="{{ route('session.store') }}"
            class="capitalize">
            @csrf
            <div>
                <label for="total_bill">total bill</label>
                <input type="text"
                    id="total_bill"
                    name="total_bill"
                    class="form-input">
            </div>
            <div>
                <label for="covered_cost">covered cost</label>
                <input type="text"
                    id="total_bill"
                    name="covered_cost"
                    class="form-input">
            </div>
            <div>
                <label for="patient_id">id</label>
                <input type="text"
                    id="patient_id"
                    name="patient_id"
                    class="form-input">
            </div>
            <div class="mt-2">
                <button type="submit"
                    class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110">
                    Submit
                </button>
            </div>
        </form>
    </div>

    {{-- <div class="flex flex-row border border-orange-700"> --}}
    <div class="container grid w-5/6 grid-cols-3 gap-5 mx-auto rounded-lg lg:w-2/3">

        @forelse ($patient->therapySessions as $therapySession)
            <a href="{{ route('session.show', $therapySession->id) }}"
                class="relative p-2 duration-200 border border-blue-300 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:scale-105">
                <div class="flex">
                    <p class="text-lg font-bold">{{ $therapySession->created_at->format('M d Y') }}</p>
                </div>
                <div class="w-full text-xs text-right">
                    <div class="">
                        <p><span class="font-bold">Total Bill</span>: {{ $therapySession->total_bill }}</p>
                    </div>
                    <div class="">
                        <p><span class="font-bold">Covered Cost</span>: {{ $therapySession->covered_cost }}</p>
                    </div>
                    {{-- <p>
                        {{ $therapySession->covered_cost }}
                    </p> --}}
                </div>
                <div class="text-xs">
                    <button>
                        View more
                    </button>
                </div>
            </a>
        @empty
            <p>nothing to display</p>
        @endforelse
    </div>

</x-app-layout>

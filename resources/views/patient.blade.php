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
                <label for="session_cost">session cost</label>
                <input type="text"
                    id="session_cost"
                    name="session_cost"
                    class="form-input">
            </div>
            <div>
                <label for="client_contribution">client contribution</label>
                <input type="text"
                    id="client_contribution"
                    name="client_contribution"
                    class="form-input">
            </div>
            <div class="hidden">
                <label for="patient_id">id</label>
                <input type="text"
                    id="patient_id"
                    name="patient_id"
                    class="form-input"
                    value="{{ $patient->id }}"
                    readonly
                    >
            </div>
            <div class="mt-2">
                <button type="submit"
                    class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110">
                    Submit
                </button>
            </div>
        </form>
    </div>


    <div class="container w-5/6 mx-auto rounded-lg lg:w-2/3">
        <h2 class="my-2 text-lg font-bold">Patient Sessions:</h2>
        <div class="container grid grid-cols-3 gap-5 ">

            @forelse ($patient->therapySessions as $therapySession)
                <a href="{{ route('session.show', $therapySession->id) }}"
                    class="relative p-2 duration-200 border border-blue-300 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:shadow-xl hover:shadow-blue-100">
                    <div class="flex">
                        {{-- <p class="text-lg font-bold">{{ $therapySession->created_at->format('M d Y') }}</p> --}}
                        <p class="text-lg font-bold">{{ $therapySession->created_at->format('M d Y') }}</p>

                    </div>
                    <div class="w-full text-xs text-right">
                        <div class="">
                            <p><span class="font-bold">Session Cost</span>: {{ $therapySession->session_cost }}</p>
                        </div>
                        <div class="">
                            <p><span class="font-bold">Client Contribution</span>: {{ $therapySession->client_contribution }}</p>
                        </div>
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
    </div>
</x-app-layout>

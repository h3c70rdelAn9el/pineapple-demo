<x-app-layout>

    <h2 class="flex flex-row text-xl">
        {{ $patient->first }} {{ $patient->last }}
    </h2>


    {{-- <div class="flex flex-row border border-orange-700"> --}}
    <div class="grid grid-cols-3 gap-4 border border-orange-700 rounded-lg">

        @forelse ($patient->therapySessions as $therapySession)
        <div class="relative p-2 border border-orange-800 rounded-lg shadow-md">
            <div class="flex flex-row justify-between">
                <p class="text-lg">{{ $therapySession->id }}</p>
                <p class="text-lg font-bold">{{ $therapySession->created_at->format('M d Y') }}</p>
            </div>
            <div class="w-full text-xs text-right ">
                <div class="">
                    <p><span class="font-bold">Total Bill</span>:  {{ $therapySession->total_bill }}</p>
                </div>
                <div class="">
                    <p><span class="font-bold">Covered Cost</span>:  {{ $therapySession->covered_cost }}</p>
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
        </div>
        @empty
            <p>nothing to display</p>
        @endforelse
    </div>

</x-app-layout>

<a href="{{ route('session.show', $therapySession->id) }}"
    class="relative p-2 duration-200 border border-blue-300 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:shadow-xl hover:shadow-blue-100">
    <div class="flex justify-between p-1 mx-2">
        {{-- <p class="text-lg font-bold">{{ $therapySession->created_at->format('M d Y') }}</p> --}}
        <p class="text-lg">{{ $therapySession->created_at->format('M d Y') }}</p>
        <p class="text-lg">{{ $therapySession->created_at->format('h:m') }}</p>
    </div>
    <div class="w-full text-xs text-right">
        <div class="">
            <p><span class="font-bold">Total Bill</span>: {{ $therapySession->total_bill }}</p>
        </div>
        <div class="">
            <p><span class="font-bold">Covered Cost</span>: {{ $therapySession->covered_cost }}</p>
        </div>
    </div>
    <div class="text-xs">
        <button>
            View more
        </button>
    </div>
</a>

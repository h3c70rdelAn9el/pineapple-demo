<a href="{{ route('session.show', $therapySession->id) }}"
    class="relative w-full p-2 m-2 transition-all duration-200 ease-in border border-blue-200 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:border hover:border-blue-400 hover:shadow-lg">
    <div class="flex flex-row justify-between w-full ml-1 text-xs">
        <div class="flex flex-col">
            @if (Auth::user()->admin)
                <div class="flex flex-row">
                    <p class="mr-1">Therapist:</p>
                    <p class="capitalize">{{ $therapySession->client->user->name }}</p>
                </div>
            @endif
            <div>
                <p class="">{{ $therapySession->created_at->format('M d Y') }}</p>
            </div>
        </div>
        <div class="mr-1 text-right">
            <div class="">
                <p><span class="font-bold">Total Bill</span>: {{ $therapySession->total_bill }}</p>
            </div>
            <div class="">
                <p><span class="font-bold">Covered Cost</span>: {{ $therapySession->covered_cost }}</p>
            </div>
        </div>
    </div>
</a>

<a href="{{ route('session.show', $therapySession->id) }}"
    class="relative w-full p-2 m-2 transition-all duration-200 ease-in border border-blue-200 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:border hover:border-blue-400 hover:shadow-lg ">

    <div class="flex justify-between p-1">
        <p class="text">{{ $therapySession->created_at->format('M d Y') }}</p>
        {{-- TODO: ADD PROPER TIME --}}
        {{-- <p class="text">{{ $therapySession->created_at->format('h:m') }}</p> --}}
    </div>
    <div class="flex justify-between w-full ml-1 text-xs">
        {{-- TODO: add therapist name!!! --}}
       {{-- <div>
            <p>Therapist:</p>
            <p class="text">{{ $therapist->name }}</p>

       </div> --}}
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

<div class="w-full flex flex-col">
    <a class="m-2 rounded-lg border-2 border-blue-900 p-2 shadow-md transition-all duration-200 ease-in hover:border-blue-400 hover:shadow-lg"
        href="{{ route('therapist.show', $therapist->id) }}"
        x-data="{ isActive: {{ $therapist->active_status === 0 ? 'true' : 'false' }} }"
        :class="{ ' bg-blue-200 border-blue-400 hover:border-blue-600 border hover:bg-blue-300 transition-all duration-200': isActive, 'bg-red-200 border-red-400 border hover:bg-red-300  transition-all ease-in-out duration-200':
                !isActive
                }"
                >
        <div class="ml-1 flex  flex-row justify-between">
            <div class="ml-2">
                <p class=" capitalize">
                    {{ $therapist->preferred_name ? $therapist->preferred_name : $therapist->name }}
                </p>
           {{-- @if( $therapist->contract_signed === null || $therapist->public_liability_insurance === null || $therapist->all_documents === null || $therapist->signed_documents === null || $therapist->leah_signed === null) --}}
           @if($incompleteTherapists)
                    <p class="text-red-600 text-xs">Incomplete</p>
                @endif
                {{-- @php
                    dd($incompleteTherapists);
                @endphp --}}
        {{-- <p class="text-red-600 text-xs">Incomplete</p>
    @endif
    @php
        dd($incompleteTherapists);
    @endphp --}}
            </div>
            <p class="mr-2 inline-block">
                Clients:
                <span class="">{{ $therapist->clients->count() }}</span>
            </p>
        </div>
    </a>
</div>

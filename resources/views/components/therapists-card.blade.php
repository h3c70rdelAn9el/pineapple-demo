@php
    $user = Auth::user();
    // $inactiveTherapists = $user->where('active_status', 1)->count();
    $adminTherapistsCount = $user->where('admin', 0)->count();
    // dd($adminTherapistsCount);
    // $incompleteTherapist =
@endphp

<div class="flex w-full flex-col">
    <a class="m-2 rounded-lg border-2 border-blue-900 p-2 shadow-md transition-all duration-200 ease-in hover:border-blue-400 hover:shadow-lg"
        href="{{ route('therapist.show', $therapist->id) }}" x-data="{
            isActive: {{ $therapist->active_status !== 1 ? 'true' : 'false' }},
            isIncomplete: {{ $therapist->isComplete()['status'] ? 'false' : 'true' }},
            isAdmin: {{ $user->admin === 1 ? 'true' : 'false' }}
        }"
        :class="{
            'bg-blue-200 border-blue-400 hover:border-blue-600 border hover:bg-blue-300 transition-all duration-200': isActive,
            'bg-gray-300 border-gray-400 border hover:bg-gray-500 transition-all ease-in-out duration-200': !
                isIncomplete && !isActive,
            'bg-red-300 border-red-300 border hover:bg-red-500 transition-all ease-in-out duration-200': isIncomplete &&
                !isAdmin && isActive,
            'bg-gray-300 border-red-400 border hover:bg-red-500 transition-all ease-in-out duration-200': isIncomplete &&
                !isAdmin && !isActive
        }">

        <div class="ml-1 flex flex-row justify-between">
            <div class="ml-2">
                <p class="capitalize">
                    {{ $therapist->preferred_name ? $therapist->preferred_name : $therapist->name }}
                </p>
                <div class="flex flex-row gap-2 text-xs">
                    @if (!$therapist->isComplete()['status'])
                        <p class="text-xs text-red-600">Incomplete</p>
                    @endif
                    @if (!$therapist->isVerified()['status'])
                        <p class="text-yellow-700">Unverified</p>
                    @endif
                </div>
            </div>
            <p class="mr-2 inline-block">
                Clients:
                <span class="">{{ $therapist->clients->count() }}</span>
            </p>
        </div>
    </a>
</div>

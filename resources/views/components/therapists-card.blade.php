<a class="relative m-2 w-full rounded-lg border border-blue-200 p-2 shadow-md transition-all duration-200 ease-in hover:border-blue-400 hover:shadow-lg"
    href="{{ route('therapist.show', $therapist->id) }}"
    x-data="{ isActive: {{ $therapist->active_status === 0 ? 'true' : 'false' }} }"
    :class="{ 'bg-blue-200 border-blue-400 hover:border-blue-600 border hover:bg-blue-300 transition-all duration-200': isActive, 'bg-red-200 border-red-400 border hover:bg-red-300  transition-all ease-in-out duration-200':
            !isActive }">
    <div class="ml-1 flex w-full flex-row justify-between">
        <p class="ml-2 capitalize">
            {{ $therapist->name }}
        </p>
        <p class="mr-2 inline-block">
            Clients:
            <span class="">{{ $therapist->clients->count() }}</span>
        </p>
    </div>
</a>

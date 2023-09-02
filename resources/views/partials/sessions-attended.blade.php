<div class="flex flex-col mt-4 text-xs">
    @php
        $attendedCount = $client->therapySessions->where('attendance', 'attended')->count();
        $noShowCount = $client->therapySessions->where('attendance', 'no-show')->count();
        $sessionsLeft = $client->max_sessions - $attendedSessions->count();
    @endphp

    <p class="text-gray-500">
        <span class="mr-3 font-bold">{{ $sessionsLeft }}</span>Sessions Left
    </p>
    <p class="text-green-600">
        <span class="mr-1">{{ $attendedCount }}</span>Attended
    </p>
    <p class="text-red-600">
        <span class="mr-2">{{ $noShowCount }}</span>No Show
    </p>
</div>

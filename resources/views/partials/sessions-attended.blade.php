@php
    $attendedCount = $client->therapySessions->where('attendance', 'attended')->count();
    $noShowCount = $client->therapySessions->where('attendance', 'no-show')->count();
    $sessionsLeft = $client->max_sessions - $attendedSessions->count();
    $defaultSpecialSessions = $client->special_sessions ?: 6;
$specialSessionsCount = $client->special_sessions? $client->special_sessions : 6;

    $specialSessionsLeft = max(0, $defaultSpecialSessions - $specialSessionsCount);
@endphp
<div class="flex flex-col mt-4 text-xs">

    <p class="text-gray-500">
        <span class="mr-3 font-bold">{{ $sessionsLeft }}</span>Sessions Left
    </p>
    <p class="text-green-600">
        <span class="mr-3">{{ $attendedCount }}</span>Attended
    </p>
    <p class="text-red-600">
        <span class="mr-3">{{ $noShowCount }}</span>No Show
    </p>

    {{-- @php
        dd($specialSessionsLeft);
    @endphp --}}

    @if ($client->special_sessions > 0)
        <p class="text-purple-600">
            <span class="mr-3">{{ $specialSessionsCount }}</span>Special Sessions
        </p>
    @endif


</div>

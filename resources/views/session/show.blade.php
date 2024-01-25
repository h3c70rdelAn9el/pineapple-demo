<x-app-layout>
    <div class="mt-2 flex">
        <a class="mx-auto w-5/6 text-blue-600 transition duration-200 hover:text-blue-700 lg:w-1/2"
            href="{{ route('clients.show', $therapySession->client_id) }}">Back to client Details</a>
    </div>
    <section
        class="mx-auto mt-3 h-full w-5/6 rounded-lg border border-black bg-gray-100 p-2 text-gray-800 shadow-md shadow-blue-100 lg:w-1/2">
        <div>
            <p class="text-lg">Client: <span
                    class="font-bold capitalize">{{ $therapySession->client->preferred_name }}</span></p>
            <p class="text-center text-lg">Session Details</p>
        </div>
        @foreach ([
        'Preferred Name' => $client->preferred_name,
        'Therapist' => $client->user->name,
        'Session ID' => $therapySession->id,
        'Session Date' => date('F d, Y', strtotime($therapySession->created_at)),
        'Session Cost' => $therapySession->session_cost,
        'Original Client Contribution' => $client->client_contribution,
        'Remaining Client Contribution' => $therapySession->remaining_client_contribution,
        'Session Attendance' => $therapySession->attendance,
    ] as $label => $value)
            <div class="flex flex-row">
                <div class="w-1/2 border-b border-r border-gray-400 p-2">{{ $label }}:</div>
                <div
                    class="@if ($label === 'Session Attendance') text-{{ $attendanceColor }} @endif w-1/2 border-b border-gray-400 p-2">
                    @if ($label === 'Session Attendance')
                        <span class="capitalize">{{ $value }}</span>
                    @else
                        {{ $value }}
                    @endif
                </div>
            </div>
        @endforeach
        <div class="flex flex-row">
            <div class="w-1/2 border-r border-gray-400 p-2">Session Notes:</div>
            <div class="w-1/2 border-gray-400 p-2">{{ $therapySession->notes }}</div>
        </div>
    </section>
    <div class="mt-2 flex">
        <a class="mx-auto w-5/6 text-blue-600 transition duration-200 hover:text-blue-700 lg:w-1/2"
            href="{{ route('clients.show', $therapySession->client_id) }}">Back to client Details</a>
    </div>
</x-app-layout>

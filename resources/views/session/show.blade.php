<x-app-layout>
        <section
                 class="w-5/6 h-full p-2 mx-auto mt-3 text-gray-800 bg-gray-100 border border-black rounded-lg shadow-md shadow-blue-100 lg:w-1/2">
            <div>
                <p class="text-lg">Client: <span class="font-bold capitalize">{{ $therapySession->client->preferred_name
                        }}</span></p>
                <p class="text-lg text-center">Session Details</p>
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
                <div class="w-1/2 p-2 border-b border-r border-gray-400">{{ $label }}:</div>
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
                <div class="w-1/2 p-2 border-r border-gray-400">Session Notes:</div>
                <div class="w-1/2 p-2 border-gray-400">{{ $therapySession->notes }}</div>
            </div>
        </section>
        <div class="flex mt-2">
            <a class="mx-auto hover:text-blue-500" href="{{ route('clients.show', $therapySession->client_id) }}">Back to client Details</a>
        </div>
</x-app-layout>

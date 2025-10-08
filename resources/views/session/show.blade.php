<x-app-layout>
    <section
        class="w-5/6 h-full p-2 mx-auto mt-3 text-gray-800 bg-gray-100 border border-black rounded-lg shadow-md shadow-blue-100 lg:w-1/2">
        <div>
            <p class="text-lg">Client: <span class="font-bold capitalize">
                    <a href="{{ route('clients.show', $therapySession->client_id) }}"
                        class="text-blue-500 hover:text-blue-800">
                        {{ $therapySession->client->preferred_name }}</a>
                </span></p>
            <p class="text-lg text-center">Session Details</p>
        </div>
        @foreach ([
        'Preferred Name' => $client->preferred_name,
        'Therapist' => $therapySession->therapist->name ?? 'N/A',
        'Session ID' => $therapySession->id,
        'Session Date' => date('F d, Y', strtotime($therapySession->created_at)),
        'Session Cost' => $therapySession->session_cost,
        'Original Client Contribution' => $therapySession->client_contribution,
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


    @if (auth()->user()->admin == 1)
    <form action="{{ route('session.destroy', $therapySession) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-blue-500 btn btn-danger hover:text-blue-800"
            onclick="return confirm('Are you really sure that you want to delete this session?')">Delete</button>
    </form>
    @endif
</x-app-layout>

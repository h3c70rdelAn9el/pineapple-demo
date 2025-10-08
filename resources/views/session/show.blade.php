<x-app-layout>
    <section
        class="w-5/6 h-full p-2 mx-auto mt-3 text-gray-800 bg-gray-100 border border-black rounded-lg shadow-md shadow-blue-100 lg:w-1/2"
        x-data="{ editMode: false }">
        <div>
            <p class="text-lg">Client: <span class="font-bold capitalize">
                    <a href="{{ route('clients.show', $therapySession->client_id) }}"
                        class="text-blue-500 hover:text-blue-800">
                        {{ $therapySession->client->preferred_name }}</a>
                </span></p>
            <div class="flex items-center justify-between">
                <p class="text-lg text-center flex-grow">Session Details</p>
                @if (auth()->user()->admin == 1)
                    <button
                        @click="editMode = !editMode"
                        type="button"
                        class="px-3 py-1 text-sm text-white transition duration-200 ease-in-out bg-blue-500 rounded hover:bg-blue-600"
                        x-text="editMode ? 'Cancel' : 'Edit Amounts'">
                    </button>
                @endif
            </div>
        </div>

        <!-- View Mode -->
        <div x-show="!editMode">
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
        </div>

        <!-- Edit Mode -->
        @if (auth()->user()->admin == 1)
        <div x-show="editMode" x-cloak>
            <form action="{{ route('session.update', $therapySession) }}" method="POST">
                @csrf
                @method('PATCH')

                @foreach ([
                'Preferred Name' => ['value' => $client->preferred_name, 'editable' => false],
                'Therapist' => ['value' => $therapySession->therapist->name ?? 'N/A', 'editable' => false],
                'Session ID' => ['value' => $therapySession->id, 'editable' => false],
                'Session Date' => ['value' => date('F d, Y', strtotime($therapySession->created_at)), 'editable' => false],
                'Session Cost' => ['value' => $therapySession->session_cost, 'editable' => true, 'field' => 'session_cost'],
                'Original Client Contribution' => ['value' => $therapySession->client_contribution, 'editable' => true, 'field' => 'client_contribution'],
                'Remaining Client Contribution' => ['value' => $therapySession->remaining_client_contribution, 'editable' => true, 'field' => 'remaining_client_contribution'],
                'Session Attendance' => ['value' => $therapySession->attendance, 'editable' => false],
            ] as $label => $data)
                    <div class="flex flex-row">
                        <div class="w-1/2 p-2 border-b border-r border-gray-400">{{ $label }}:</div>
                        <div class="w-1/2 p-2 border-b border-gray-400">
                            @if ($data['editable'])
                                <input
                                    type="number"
                                    step="0.01"
                                    name="{{ $data['field'] }}"
                                    value="{{ old($data['field'], $data['value']) }}"
                                    class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error($data['field'])
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            @else
                                @if ($label === 'Session Attendance')
                                    <span class="capitalize text-{{ $attendanceColor }}">{{ $data['value'] }}</span>
                                @else
                                    {{ $data['value'] }}
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="flex flex-row">
                    <div class="w-1/2 p-2 border-r border-gray-400">Session Notes:</div>
                    <div class="w-1/2 p-2 border-gray-400">{{ $therapySession->notes }}</div>
                </div>

                <div class="flex gap-2 mt-4">
                    <button
                        type="submit"
                        class="px-4 py-2 text-white transition duration-200 ease-in-out bg-green-500 rounded hover:bg-green-600">
                        Save Changes
                    </button>
                    <button
                        type="button"
                        @click="editMode = false"
                        class="px-4 py-2 text-gray-700 transition duration-200 ease-in-out bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
        @endif
    </section>

    @if (session('success'))
        <div class="w-5/6 p-4 mx-auto mt-3 text-green-800 bg-green-100 border border-green-400 rounded lg:w-1/2">
            {{ session('success') }}
        </div>
    @endif

    @if (auth()->user()->admin == 1)
    <form action="{{ route('session.destroy', $therapySession) }}" method="POST" class="w-5/6 mx-auto mt-3 lg:w-1/2">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-blue-500 btn btn-danger hover:text-blue-800"
            onclick="return confirm('Are you really sure that you want to delete this session?')">Delete</button>
    </form>
    @endif
</x-app-layout>

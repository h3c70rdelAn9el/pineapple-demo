<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full table-fixed">
                    <thead class="border-b bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Attendance
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Therapist
                            </th>
                            <th scope="col" class="max-w-20 text -gray-900 px-6 py-4 text-left text-sm font-medium">
                                Date
                            </th>
                            {{-- <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Notes
                            </th> --}}
                            <th scope="col" class="max-w-20 px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Special Session
                            </th>

                        </tr>
                    </thead>
                    {{-- <tbody> --}}

                    @foreach ($therapySessions as $therapySession)
                        <tr
                            class="{{ $therapySession->attendance == 'attended'
                                ? 'bg-orange-300'
                                : ($therapySession->attendance == 'no-show'
                                    ? 'bg-red-300'
                                    : ($therapySession->special > 0
                                        ? 'bg-purple-300'
                                        : 'bg-green-300')) }} border-b-4">
                            {{-- <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">
                                <a href="{{ route('clients.show', $client->id) }}"
                                    class="text-blue-600 hover:text-blue-800">

                                    {{ $therapySession->id }}
                                </a>
                            </td> --}}
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                  {{ $therapySession->client->client_code }}

                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                {{ $therapySession->attendance }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                {{ $therapySession->therapist->name }}
                            </td>


                             <td class="max-w-20 whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                    {{ $therapySession->created_at ? $therapySession->created_at->format('m-d-Y') : 'N/A' }}
                            </td>
                             {{-- <td class="max-w-20 whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                {{ $therapySession->notes }}
                            </td> --}}
                            <td class="max-w-20 whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                {{ $therapySession->special ? 'Yes' : 'No' }}
                            </td>

                            {{-- <td class="max-w-20 whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                {{ $client->therapySessions->whereIn('attendance', 'attended')->count() }}
                            </td>
                            <td class="max-w-20 whitespace-nowrap px-6 py-4 text-sm font-light text-gray-900">
                                @if ($client->therapy_sessions)
                                    {{ $client->therapy_sessions->where('attendance', 'no-show')->count() }}
                                @else
                                    0
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-light text-gray-900">
                                {{ $client->status == 1 ? 'Inactive' : 'Active' }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-light text-gray-900">
                                {{ $client->waitlist == 1 ? 'Yes' : 'No' }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-light text-gray-900">
                                <a href="{{ route('clients.show', $client->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="border-b bg-white">
                        {{-- <td colspan="10" class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $clients->links() }}
                        </td> --}}
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full table-fixed">
                    <thead class="border-b bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Client Code
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Therapist
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Possible Support
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Email
                            </th>
                            <th scope="col" class="max-w-20 px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Max Sessions
                            </th>
                            <th scope="col" class="max-w-20 px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Attended Sessions
                            </th>
                            <th scope="col" class="max-w-20 px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Missed Sessions
                            </th>
                            <th scope="col" class="w-6 px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Status
                            </th>
                            <th scope="col" class="w-6 px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Waitlist
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr
                                class="{{ $client->status == 1 ? 'bg-orange-300' : ($client->waitlist == 1 ? 'bg-blue-300' : 'bg-green-300') }} border-b-4">
                                <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">
                                    {{ $client->client_code }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                    {{ $client && $client->user && $client->user->preferred_name ? $client->user->preferred_name : ($client && $client->user ? $client->user->name : '') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                    {{ $client->possible_support_needed }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                    {{ $client->email }}
                                </td>
                                <td class="max-w-20 whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                    {{ $client->max_sessions }}
                                </td>
                                <td class="max-w-20 whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-b bg-white">
                        <td colspan="10" class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $clients->links() }}
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

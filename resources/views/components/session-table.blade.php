<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full table-fixed">
                    <thead class="border-b bg-white">
                        <tr>
                            <th scope="col" class="th-table-header">
                                ID
                            </th>
                            <th scope="col" class="th-table-header">
                                Client Code
                            </th>
                            <th scope="col" class="th-table-header">
                                Attendance
                            </th>
                            <th scope="col" class="th-table-header">
                                Therapist
                            </th>
                            <th scope="col" class="max-w-20 th-table-header">
                                Date
                            </th>
                            {{-- <th scope="col" class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                Notes
                            </th> --}}
                            <th scope="col" class="max-w-20 th-table-header">
                                Special Session
                            </th>
                            <th scope="col" class="max-w-20 th-table-header">
                                Action
                            </th>
                        </tr>
                    </thead>
                    {{-- <tbody> --}}

                    @foreach ($therapySessions as $therapySession)
                        <tr
                            class="{{ $therapySession->special == 1 ? 'bg-purple-300' : ($therapySession->attendance === 'no-show' ? 'bg-red-300' : 'bg-green-300') }} border-b-4">
                            <td class="td-table-data">
                                {{ $therapySession->client->id }}
                            </td>
                            <td class="td-table-data">
                                {{ $therapySession->client->client_code }}
                            </td>

                            <td class="td-table-data">
                                {{ $therapySession->attendance }}
                            </td>
                            <td class="td-table-data">
                                {{ $therapySession->therapist->name }}
                            </td>

                            <td class="max-w-20 td-table-data">
                                {{ $therapySession->created_at ? $therapySession->created_at->format('m-d-Y') : 'N/A' }}
                            </td>
                            {{-- <td class="max-w-20 whitespace-nowrap px-4 py-4 text-sm font-light text-gray-900">
                                {{ $therapySession->notes }}
                            </td> --}}
                            <td class="max-w-20 td-table-data">
                                {{ $therapySession->special ? 'Yes' : 'No' }}
                            </td>
                            <td class="max-w-20 td-table-data text-blue-700">
                                <a href="{{ route('session.show', $therapySession->id) }}" class="hover:text-blue-800 hover:font-normal transition duration-200">
                                    View
                                </a>
                            </td>
                        </tr>
                        </a>
                    @endforeach

                    </tbody>
                    <tfoot class="border-b bg-white">
                        <td colspan="10" class="whitespace-nowrap px-6 py-2 text-sm font-medium text-gray-900">
                            {{ $therapySessions->links() }}
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

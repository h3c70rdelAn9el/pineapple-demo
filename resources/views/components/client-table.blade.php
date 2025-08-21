<div class="flex flex-col">
    <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full table-fixed">
                    <thead class="border-b bg-white">
                        <tr>
                            <th scope="col" class="td-table-header text-sm">
                                Client Code
                            </th>
                            <th scope="col" class="td-table-header text-sm">
                                Therapist
                            </th>
                            <th scope="col" class="max-w-20 td-table-header text-sm">
                                Email
                            </th>
                            <th scope="col" class="max-w-20 td-table-header text-sm">
                                Possible Support
                            </th>
                            <th scope="col" class="max-w-20 td-table-header text-sm">
                                Special Sessions
                            </th>

                            <th scope="col" class="max-w-24 td-table-header text-sm">
                                Max Sessions
                            </th>
                            <th scope="col" class="max-w-24 td-table-header text-sm">
                                Attended Sessions
                            </th>
                            <th scope="col" class="max-w-24 td-table-header text-sm">
                                Missed Sessions
                            </th>

                            <th scope="col" class="td-table-header w-6 text-sm">
                                Status
                            </th>
                            <th scope="col" class="td-table-header w-6 text-sm">
                                Waitlist
                            </th>
                            @if (auth()->user() && auth()->user()->admin == 1)
                                <th scope="col" class="td-table-header w-6 text-sm">
                                    Contacted
                                </th>
                            @endif
                            <th scope="col" class="th-table-header text-sm font-bold">
                                Created At
                            </th>
                        </tr>
                    </thead>
                    {{-- <tbody> --}}

                    @foreach ($clients as $client)
                        <tr onclick="window.location='{{ route('clients.show', $client->id) }}'"
                            class="{{ $client->status == 1
                                ? 'bg-orange-300'
                                : ($client->waitlist == 1
                                    ? 'bg-blue-300'
                                    : ($client->special_sessions > 0
                                        ? 'bg-purple-300'
                                        : 'bg-green-300')) }} border border-transparent hover:rounded hover:border-blue-500 hover:border cursor-pointer">
                            <td class="td-table-data">
                                {{ $client->client_code }}
                            </td>
                            <td class="td-table-data">
                                {{ $client && $client->user && $client->user->preferred_name ? $client->user->preferred_name : ($client && $client->user ? $client->user->name : '') }}
                            </td>

                            <td class="td-table-data">
                                {{ $client->email }}
                            </td>
                            <td class="td-table-data max-w-52 overflow-hidden text-ellipsis">
                                {{ str_replace(['[', ']', '"'], '', $client->possible_support_needed) }}
                            </td>
                            <td class="max-w-20 td-table-data">
                                {{ $client->special_sessions > 0 ? 'Yes' : 'No' }}
                            </td>
                            <td class="max-w-20 td-table-data">
                                {{ $client->max_sessions }}
                            </td>
                            <td class="max-w-20 td-table-data">
                                {{ $client->therapySessions->whereIn('attendance', 'attended')->count() }}
                            </td>
                            <td class="max-w-20 td-table-data">
                                @if ($client->therapy_sessions)
                                    {{ $client->therapy_sessions->where('attendance', 'no-show')->count() }}
                                @else
                                    0
                                @endif
                            </td>
                            <td class="td-table-data">
                                {{ $client->status == 1 ? 'Inactive' : 'Active' }}
                            </td>
                            <td class="td-table-data">
                                {{ $client->waitlist == 1 ? 'Yes' : 'No' }}
                            </td>
                            @if (auth()->user() && auth()->user()->admin == 1)
                                <td class="td-table-data">
                                    {{ $client->has_been_contacted ? 'Yes' : 'No' }}
                                </td>
                            @endif
                            <td class="td-table-data">
                                {{ $client->created_at ? $client->created_at->format('d/m/Y') : 'Created At needed' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="w-full border-b bg-white">
                        <td colspan="{{ auth()->user() && auth()->user()->admin == 1 ? '13' : '12' }}" class="td-table-data">
                            @if ($clients->count() > 10)
                                {{ $clients->links() }}
                            @endif
                        </td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

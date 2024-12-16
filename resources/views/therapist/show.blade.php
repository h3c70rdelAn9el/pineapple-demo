<x-app-layout>


        <div class="mt-2 ml-7 w-fit ">
            <table class="w-full ml-4">
                <tbody class="text-sm">
                    <tr>
                        <td>Total Sessions' Cost:</td>
                        <td><span class="ml-4 font-bold">{{ $totalSessionCost }}</span></td>
                    </tr>
                    <tr>
                        <td>Total Clients' Contribution:</td>
                        <td><span class="ml-4 font-bold text-blue-500">{{ $totalClientContribution }}</span></td>
                    </tr>

                    <tr>
                        <td>Total:</td>
                        <td>
                            <span class="font-bold ml-4 {{ $total < 0 ? 'text-red-500' : '' }}">
                                {{ $total }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>incomplete status:</td>
                        <td>
                            <span class="font-bold ml-4 {{ !$therapist->isComplete()['status'] ? 'text-red-500' : '' }}">
                                {{ $therapist->isComplete()['status'] ? 'Yes' : 'No' }}
                                <br/>
                                {{ $therapist->isComplete()['reason'] }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>verified status:</td>
                        <td>
                            <span class="font-bold ml-4 {{ !$therapist->isVerified()['status'] ? 'text-red-500' : '' }}">
                                {{ $therapist->isVerified()['status'] ? 'Yes' : 'No' }}
                                <br/>
                                {{ $therapist->isVerified   ()['reason'] }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            {{-- left/top --}}
            <x-container-content :user="$user">\
                <x-slot name="title">
                    <div class="flex flex-row items-center justify-between w-full">
                        <div class="flex flex-col text-left">
                            <p>{{ $therapist->name }}</p>
                            <p class="text-sm">{{ $therapist->gender }}</p>
                        </div>
                        @if (auth()->user()->admin == 1)
                            <div class="flex flex-row justify-end">
                                <a class="mt-1 button"
                                    href="{{ route('therapist.edit', $therapist->id) }}">Edit</a>
                            </div>
                        @endif
                    </div>
                </x-slot>
                <x-slot name="count">
                </x-slot>
                <x-slot name="content">
                    <div class="p-2 text-sm font-normal capitalize">
                        @foreach ([
                                'Title' => $therapist->title ?: 'Title n/a',
                                'Name' => $therapist->name ?: 'Name n/a',
                                'Preferred Name' => $therapist->preferred_name ?: 'Preferred Name n/a',
                                'gender' => $therapist->gender ?: 'Gender n/a',
                                'Therapist is' => $therapist->on_vacation ? 'On Vacation' : 'Available',
                                'intern' => $therapist->intern ?: 'Intern n/a',
                                'Supervisor Name' => $therapist->supervisor_name ?: 'Supervisor Name n/a',
                                'Clients' => $therapist->clients->count(),
                                'Space for New Clients' => $space_for_new_clients,
                                'session cost' => $therapist->session_cost ?: 'Session Cost needed',
                                'currency' => $therapist->currency ?: 'Currency needed',
                                'Email' => $therapist->email ?: 'Email n/a',
                                'Timezone' => $therapist->timezone ?: 'Timezone n/a',
                                'Home County/Town' => $therapist->county_town ?: 'County/Town n/a',
                                'Home State' => $therapist->home_address_state ?: 'State n/a',
                                'Home Country' => $therapist->home_address_country ?: 'Country n/a',
                                'Out of State Coaching' => $therapist->out_of_state_coaching == 1 ? 'Yes' : 'No',
                                'Client Extensions' => $therapist->client_extensions ?: 'Client Extensions n/a',
                                'active status' => $therapist->active_status ? 'Active' : 'Inactive',
                                'contract signed' => $therapist->contract_signed ?: 'Contract Signed needed',
                                'All documents Recieved' => $therapist->all_documents ?: 'All Documents needed',
                                'website' => $therapist->website ?: 'Website n/a',
                                'quickbooks' => $therapist->quickbooks ?: 'Quickbooks needed',
                                'contact for promotionals' => $therapist->contact_for_promotionals ?: 'Contact for Promotionals n/a',
                                'notes' => $therapist->notes ?: 'Notes needed',
                            ] as $label => $value)
                            <div class="flex flex-row">
                                <div class="w-1/2 p-2 border-b border-r border-gray-400">{{ $label }}:</div>
                                <div class="w-1/2 p-2 border-b border-gray-400">{{ $value }}</div>
                            </div>
                        @endforeach

                        <div class="flex flex-wrap mt-5">
                            <div class="relative">
                                <a class="text-blue-500 hover:text-blue-800"
                                    href="{{ route('therapist.forms', $therapist) }}">View Forms</a>
                            </div>
                        </div>
                        @if (auth()->user()->admin == 1)
                        <div class="flex flex-row justify-end">
                            <form action="{{ route('therapist.destroy', $therapist->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this therapist?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 btn btn-danger">Delete Therapist</button>
                            </form>
                        </div>
                    @endif
                    </div>
                </x-slot>
            </x-container-content>

            {{-- right/bottom --}}
            <x-container-content>
                <x-slot name="title">
                    Clients
                </x-slot>
                <x-slot name="count">
                    {{ $therapist->clients->count() }}
                </x-slot>
                <x-slot name="content">
                    @foreach ($therapist->clients as $client)
                        <x-client-card :client="$client"
                            :therapist="$therapist"
                            :user="$user"></x-client-card>
                    @endforeach
                </x-slot>
            </x-container-content>
        </div>
</x-app-layout>

<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>

        <div class="flex flex-col w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            {{-- left/top --}}
            <x-container-content :user="$user">
                <x-slot name="title">
                    <div class="flex flex-row items-center justify-between w-full">
                        <div class="flex flex-col text-left">
                            <p>{{ $therapist->name }}</p>
                            <p class="text-sm">{{ $therapist->gender }}</p>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="count">
                {{-- TODO: LEAVE THIS OUT: WILL REDO --}}
                    {{-- {{ $therapist->clients->count() }} --}}
                </x-slot>
                <x-slot name="content">
                    <div class="p-2 text-sm font-normal">
                        @foreach ([
                            'Therapist is' => $therapist->on_vacation ? 'On Vacation' : 'Available',
                            'Clients' => $therapist->clients->count(),
                            'Space for New Clients' => $space_for_new_clients,
                            'Home Address' => $therapist->home_address_state ? "$therapist->home_address_state, $therapist->home_address_country" : 'Home Address needed',
                            'Timezone' => $therapist->timezone ?: 'Timezone needed',
                            'Email' => $therapist->email ?: 'Email needed',
                            'Phone' => $therapist->phone ?: 'Phone needed',
                            'Clinical License' => $therapist->clinical_license ?: 'Clinical license needed',
                            'UK Complaints Date' => $therapist->annual_contact_about_complaints_uk_date ?: 'UK Complaints Date not provided',
                            'State License Board' => $therapist->state_license_board ?: 'State License Board not provided',
                            'Insurance' => $therapist->insurance ?: 'Insurance needed',
                            'Signed Documents' => $therapist->signed_documents ?: 'Signed Documents needed',
                            'Leah Signature' => $therapist->leah_signed ?: 'Leah Signature needed',
                            'Out of State Coaching' => $therapist->out_of_state_coaching ?: 'Out of State Coaching n/a',
                            'W9' => $therapist->w9 ?: 'W9 needed',
                            'Voided Cheque' => $therapist->voided_cheque ?: 'Voided Cheque needed',
                            'Bio' => $therapist->bio ?: 'Bio n/a',
                            'Website' => $therapist->website ?: 'Website n/a',
                            'Quickbooks' => $therapist->quickbooks ?: 'Quickbooks n/a',
                            'Dropbox' => $therapist->dropbox ?: 'Dropbox n/a',
                            'Client Extensions' => $therapist->client_extensions ?: 'Client Extensions n/a',
                            'Notes' => $therapist->notes ?: 'Notes not provided',
                            'Covid Fundraise' => $therapist->covid_fundraise ?: 'Covid Fundraise n/a',
                        ] as $label => $value)
                            <div class="flex flex-row">
                                <div class="w-1/2 p-2 border-b border-r border-gray-400">{{ $label }}:</div>
                                <div class="w-1/2 p-2 border-b border-gray-400">{{ $value }}</div>
                            </div>
                        @endforeach

                        <div class="flex flex-wrap mt-5">
                            <div class="relative">
                                <a href="{{ route('therapist.forms', $therapist) }}" class="text-blue-500 hover:text-blue-800">View Forms</a>
                            </div>
                        </div>
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
                        <x-client-card :client="$client" :therapist="$therapist" :user="$user"></x-client-card>
                    @endforeach
                </x-slot>
            </x-container-content>
        </div>
    </x-main-container>
</x-app-layout>

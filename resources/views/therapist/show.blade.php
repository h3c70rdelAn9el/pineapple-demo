<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>

        <div class="mx-auto mt-3 flex h-full w-full max-w-6xl flex-col rounded-md p-4 md:flex-row">
            {{-- left/top --}}
            <x-container-content :user="$user">\
                <x-slot name="title">
                    <div class="flex w-full flex-row items-center justify-between">
                        <div class="flex flex-col text-left">
                            <p>{{ $therapist->name }}</p>
                            <p class="text-sm">{{ $therapist->gender }}</p>
                        </div>
                        @if (auth()->user()->admin === 1)
                            <div class="flex flex-row justify-end">
                                <a class="button mt-1"
                                    href="{{ route('therapist.edit', $therapist) }}">Edit</a>
                            </div>
                        @endif
                    </div>
                </x-slot>
                <x-slot name="count">
                </x-slot>
                <x-slot name="content">
                    <div class="p-2 text-sm font-normal capitalize">
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
                            'Title' => $therapist->title ?: 'Title needed',
                            'Name' => $therapist->name ?: 'Name needed',
                            'Preferred Name' => $therapist->preferred_name ?: 'Preferred Name needed',
                            'email' => $therapist->email ?: 'Email needed',
                            'gender' => $therapist->gender ?: 'Gender needed',
                            'intern' => $therapist->intern ?: 'Intern needed',
                            'contact_for_promotionals' => $therapist->contact_for_promotionals ?: 'Contact for Promotionals needed',
                            'active_status' => $therapist->active_status ?: 'Active Status needed',
                            'contract_signed' => $therapist->contract_signed ?: 'Contract Signed needed',
                            'all_documents' => $therapist->all_documents ?: 'All Documents needed',
                            'website' => $therapist->website ?: 'Website needed',
                            'quickbooks' => $therapist->quickbooks ?: 'Quickbooks needed',
                            'session_cost' => $therapist->session_cost ?: 'Session Cost needed',
                            'client_extensions' => $therapist->client_extensions ?: 'Client Extensions needed',
                            'notes' => $therapist->notes ?: 'Notes needed',
                        ] as $label => $value)
                            <div class="flex flex-row">
                                <div class="w-1/2 border-b border-r border-gray-400 p-2">{{ $label }}:</div>
                                <div class="w-1/2 border-b border-gray-400 p-2">{{ $value }}</div>
                            </div>
                        @endforeach

                        <div class="mt-5 flex flex-wrap">
                            <div class="relative">
                                <a class="text-blue-500 hover:text-blue-800"
                                    href="{{ route('therapist.forms', $therapist) }}">View Forms</a>
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
                        <x-client-card :client="$client"
                            :therapist="$therapist"
                            :user="$user"></x-client-card>
                    @endforeach
                </x-slot>
            </x-container-content>
        </div>
    </x-main-container>
</x-app-layout>

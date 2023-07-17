<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
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

                        @if ($user->admin == '1')
                        <div class="relative">
                            <a href="{{ route('therapist.edit', $therapist) }}" class="text-blue-500 hover:text-blue-800">Edit</a>
                        </div>
                        @endif



               </div>
                </x-slot>
                <x-slot name="count">
                </x-slot>
                <x-slot name="content">
                    <div class="p-2 text-sm font-normal">
                        <p>
                            Therapist is <span>{{ $therapist->on_vacation ? 'On Vacation' : 'Available'  }}</span>
                        </p>
                        <p>
                            {{ $therapist->clients->count() }} clients
                        </p>
                        <p><span>{{ $space_for_new_clients}} </span> of {{ $therapist->number_of_potential_clients }} openings remaining</p>
                        <div class="flex flex-row">
                            @if ($therapist->home_address_state)
                            <p>{{ $therapist->home_address_state }},</p>
                            @else
                            <p class="mr-2">California,</p>
                            @endif

                            @if ($therapist->home_address_country)
                            <p>{{ $therapist->home_address_country }}</p>
                            @else
                            <p class="mr-2">US</p>
                            @endif

                            @if ($therapist->timezone)
                            <p>{{ $therapist->timezone }}</p>
                            @else
                            <p class="mt-[1px] text-sm">(PST)</p>
                            @endif
                        </div>
                        <div>
                            @if ($therapist->email)
                            <p>{{ $therapist->email }}</p>
                            @else
                            <p>Email needed</p>
                            @endif
                        </div>
                        <div>
                            @if ($therapist->phone)
                            <p>{{ $therapist->phone }}</p>
                            @else
                            <p>Phone needed</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->clinical_license)
                            <p>Clinical License: {{ $therapist->clinical_license }}</p>
                            @else
                            <p>Clinical license needed</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->annual_contact_about_complaints_uk_date )
                            <p>UK complaints date: {{ $therapist->annual_contact_about_complaints_uk_date }}</p>
                            @else
                            <p>UK Complaints Date not provided</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->state_license_board)
                            @if (filter_var($therapist->state_license_board, FILTER_VALIDATE_URL))
                            <p>State License Board: <a href="{{ $therapist->state_license_board }}">{{ $therapist->astate_license_board }}</a></p>
                            @else
                            <p>State License Board: {{ $therapist->state_license_board }}</p>
                            @endif
                            @else
                            <p>State License Board not provided</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->insurance)
                            <p>Insurance: {{ $therapist->insurance }}</p>
                            @else
                            <p>Insurance needed</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->signed_documents)
                            <p>Signed Documents: {{ $therapist->signed_documents }}</p>
                            @else
                            <p>Signed Documents needed</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->leah_signed)
                            <p>Leah Signature: {{ $therapist->leah_signed }}</p>
                            @else
                            <p>Leah Signature needed</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->out_of_state_coaching)
                            <p>Out of State Coaching: {{ $therapist->out_of_state_coaching }}</p>
                            @else
                            <p>Out of State Coaching n/a</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->w9)
                            <p>W9 recieved: {{ $therapist->w9 }}</p>
                            @else
                            <p>W9 needed</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->voided_cheque)
                            <p>Voided Cheque recieved: {{ $therapist->voided_cheque }}</p>
                            @else
                            <p>Voided Cheque needed</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->bio)
                            <p>Bio: {{ $therapist->bio }}</p>
                            @else
                            <p>Bio n/a</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->website)
                            <p>Website: {{ $therapist->website }}</p>
                            @else
                            <p>Website n/a</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->quickbooks)
                            <p>Quickbooks: {{ $therapist->quickbooks }}</p>
                            @else
                            <p>Quickbooks n/a</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->dropbox)
                            <p>Dropbox: {{ $therapist->dropbox }}</p>
                            @else
                            <p>Dropbox n/a</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->client_extensions)
                            <p>Client Extensions: {{ $therapist->client_extensions }}</p>
                            @else
                            <p>Client Extensions n/a</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->notes)
                            <p>Notes: {{ $therapist->notes }}</p>
                            @else
                            <p>Notes not provided</p>
                            @endif
                        </div>

                        <div>
                            @if ($therapist->covid_fundraise)
                            <p>Covid Fundraise: {{ $therapist->covid_fundraise }}</p>
                            @else
                            <p>Covid Fundraise n/a</p>
                            @endif
                        </div>

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
                    {{ $clients->count() }}
                </x-slot>
                <x-slot name="content">
                    @foreach ($clients as $client)
                    <x-client-card :client="$client" :therapist="$therapist" :user="$user"></x-client-card>
                    @endforeach
                </x-slot>
            </x-container-content>
        </div>
    </x-main-container>
</x-app-layout>

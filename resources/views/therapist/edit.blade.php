<x-app-layout>
    {{-- make a sample edit page and form from other client-form --}}
    <x-main-container>
        <h2 class="text-center font-bold text-lg">
            Therapist: {{ $therapist->name }}
        </h2>
        {{-- <form class="w-1/2 mx-auto" action="{{ route('clients.update', $client->id) }}" method="POST"> --}}

        {{-- <form action="{{ route('therapist.update', ['id' => $therapist->id]) }}" method="POST" class="w-1/2 mx-auto"> --}}
        <form action="{{ route('therapist.update',  $therapist->id) }}" method="POST" class="w-1/2 mx-auto">

            @csrf
            @method('PUT')

            {{-- title --}}
            <x-form-field name="title"
                type="text"
                label="Title">
                {{ $therapist->title }}
            </x-form-field>

            {{-- name --}}
            <x-form-field name="name"
                type="text"
                label="Name">
                {{ $therapist->name }}
            </x-form-field>

            {{-- preferred_name --}}
            <x-form-field name="preferred_name"
                type="text"
                label="Preferred Name">
                {{ $therapist->preferred_name }}
            </x-form-field>

            {{-- email --}}
            <x-form-field name="email"
                type="text"
                label="Email">
                {{ $therapist->email }}
            </x-form-field>
            {{-- gender --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-multi-select id="gender"
                    name="gender"
                    value="{{ $therapist->gender }}"
                    label="Gender:   (previous selection: {{ $therapist->gender }}) "
                    placeholder="{{ $therapist->gender }}"
                    :options="['Male', 'Female', 'Non-binary', 'Prefer Not To Say']"></x-multi-select>
            </div>

            {{-- intern --}}
            <div class="col-span-6 my-4 sm:col-span-4">
                <x-jet-label for="intern"
                    value="Intern:  previous: {{ $therapist->intern == 0 ? 'No' : 'Yes' }}" />
                <input class="rounded"
                    id="intern"
                    type="checkbox"
                    wire:model.defer="state.intern"
                    autocomplete="intern" />
                <x-jet-input-error class="mt-2"
                    for="intern" />
            </div>

            {{-- supervisor_name --}}
            <x-form-field name="supervisor_name"
                type="text"
                label="Supervisor Name">
                {{ $therapist->supervisor_name }}
            </x-form-field>

            {{-- street_address --}}
            <x-form-field name="street_address"
                type="text"
                label="Street Address">
                {{ $therapist->street_address }}
            </x-form-field>

            {{-- county_town --}}
            <x-form-field name="county_town"
                type="text"
                label="County/Town">
                {{ $therapist->county_town }}
            </x-form-field>

            {{-- state --}}
            <x-form-field name="state"
                type="text"
                label="State">
                {{ $therapist->state }}
            </x-form-field>

            {{-- zip_code --}}
            <x-form-field name="zip_code"
                type="text"
                label="Zip Code">
                {{ $therapist->zip_code }}
            </x-form-field>

            {{-- country --}}
            <x-form-field name="country"
                type="text"
                label="Country">
                {{ $therapist->country }}
            </x-form-field>

            {{-- time_zone --}}
            <x-form-field name="time_zone"
                type="text"
                label="Time Zone">
                {{ $therapist->time_zone }}
            </x-form-field>

            {{-- account_name --}}
            <x-form-field name="account_name"
                type="text"
                label="Account Name">
                {{ $therapist->account_name }}

            </x-form-field>

            {{-- account_number --}}
            <x-form-field name="account_number"
                type="text"
                label="Account Number">
                {{ $therapist->account_number }}
            </x-form-field>

            {{-- routing_number --}}
            <x-form-field name="routing_number"
                type="text"
                label="Routing Number">
                {{ $therapist->routing_number }}
            </x-form-field>

            {{-- iban_swift_code --}}
            <x-form-field name="iban_swift_code"
                type="text"
                label="IBAN/Swift Code">
                {{ $therapist->iban_swift_code }}
            </x-form-field>

            {{-- client_spaces --}}
            <x-form-field name="client_spaces"
                type="text"
                label="Client Spaces">
                {{ $therapist->client_spaces }}
            </x-form-field>

            {{-- full --}}
            {{-- <x-form-field name="full"
                type="text"
                label="Full">
                {{ $therapist->full }}
            </x-form-field> --}}

            {{-- out_of_state_coaching --}}
            <x-form-field name="out_of_state_coaching"
                type="text"
                label="Out of State Coaching">
                {{ $therapist->out_of_state_coaching }}
            </x-form-field>

            {{-- promotional_content --}}
            <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="contact_for_promotionals"
                    value="{{ __('Contact for promotionals') }}" />
                <input class="rounded"
                    id="contact_for_promotionals"
                    type="checkbox"
                    wire:model.defer="state.contact_for_promotionals"
                    autocomplete="contact_for_promotionals" />
                <x-jet-input-error class="mt-2"
                    for="contact_for_promotionals" />
            </div>

            {{-- active_status --}}
            {{-- boolean --}}
            <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="active_status"
                    value="{{ __('Active Status') }}" />
                <input class="rounded"
                    id="active_status"
                    type="checkbox"
                    wire:model.defer="state.active_status"
                    autocomplete="active_status" />
                <x-jet-input-error class="mt-2"
                    for="active_status" />
            </div>

            {{-- contract_signed --}}
            {{-- boolean --}}
            <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="contract_signed"
                    value="{{ __('Contract Signed') }}" />
                <input class="rounded"
                    id="contract_signed"
                    type="checkbox"
                    wire:model.defer="state.contract_signed"
                    autocomplete="contract_signed" />
                <x-jet-input-error class="mt-2"
                    for="contract_signed" />
            </div>

            {{-- all_documents --}}
            {{-- boolean --}}
            <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="all_documents"
                    value="{{ __('All Documents') }}" />
                <input class="rounded"
                    id="all_documents"
                    type="checkbox"
                    wire:model.defer="state.all_documents"
                    autocomplete="all_documents" />
                <x-jet-input-error class="mt-2"
                    for="all_documents" />
            </div>

            {{-- website --}}
            {{-- boolean --}}
            <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="website"
                    value="{{ __('Website') }}" />
                <input class="rounded"
                    id="website"
                    type="checkbox"
                    wire:model.defer="state.website"
                    autocomplete="website" />
                <x-jet-input-error class="mt-2"
                    for="website" />
            </div>

            {{-- quickbooks --}}
            {{-- boolean --}}
            <div class="col-span-6 mt-4 mb-4 sm:col-span-4">
                <x-jet-label for="quickbooks"
                    value="{{ __('Quickbooks') }}" />
                <input class="rounded"
                    id="quickbooks"
                    type="checkbox"
                    wire:model.defer="state.quickbooks"
                    autocomplete="quickbooks" />
                <x-jet-input-error class="mt-2"
                    for="quickbooks" />
            </div>

            {{-- session_cost --}}
            <x-form-field name="session_cost"
                type="text"
                label="Session Cost">
                {{ $therapist->session_cost }}
            </x-form-field>

            {{-- client_extensions --}}
            {{-- <x-form-field name="client_extensions"
                type="text"
                label="Client Extensions">
                {{ $therapist->client_extensions }}
            </x-form-field> --}}

            {{-- notes --}}
            {{-- make a text area for the notes!! --}}

            <div class="w-full">
                <x-jet-label for="notes"
                    value="{{ __('Notes') }}" />
                <textarea class="rounded w-full bg-gray-100 border border-blue-200"
                    id="notes"
                    cols="30"
                    width: 100%;
                    type="text"
                    wire:model.defer="state.notes"
                    autocomplete="notes"></textarea>
                <x-jet-input-error class="mt-2"
                    for="notes" />
            </div>

            {{-- covid_fundraise --}}
            {{-- boolean --}}
            {{-- <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="covid_fundraise"
                    value="{{ __('Covid Fundraise') }}" />
                <input class="rounded"
                    id="covid_fundraise"
                    type="checkbox"
                    wire:model.defer="state.covid_fundraise"
                    autocomplete="covid_fundraise" />
                <x-jet-input-error class="mt-2"
                    for="covid_fundraise" />
            </div> --}}

            <button class="button"
                type="submit">Submit</button>
        </form>
    </x-main-container>
</x-app-layout>

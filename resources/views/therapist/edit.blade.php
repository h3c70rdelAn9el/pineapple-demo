            <div>
                <x-jet-label for="invoice_payee" value="{{ __('Invoice Payee (Name to appear on invoices)') }}" />
                <x-jet-input id="invoice_payee" class="block w-full mt-1" type="text" name="invoice_payee"
                    :value="old('invoice_payee', $therapist->invoice_payee ?? $therapist->name)" :placeholder="$therapist->invoice_payee ?? $therapist->name" autofocus />
                <x-jet-input-error for="invoice_payee" class="mt-2" />
            </div>
@php
    $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));
    $timeZones = json_decode($timeZonesJson, true);
    $countriesJson = file_get_contents(resource_path('json/countries.json'));
    $clientCountries = json_decode($countriesJson, true);
    $currenciesJson = file_get_contents(resource_path('json/currencies.json'));
    $currencies = json_decode($currenciesJson, true);
@endphp
<x-app-layout>
    <x-main-container>
        <h2 class="text-lg font-bold text-center">
            Therapist: {{ $therapist->name }}
        </h2>
        {{-- <form class="w-1/2 mx-auto" action="{{ route('clients.update', $client->id) }}" method="POST"> --}}

        {{-- <form action="{{ route('therapist.update', ['id' => $therapist->id]) }}" method="POST" class="w-1/2 mx-auto"> --}}
        <form class="form" action="{{ route('therapist.update', $therapist->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" class="block w-full mt-1" type="text" name="title" :value="old('title', $therapist->title)"
                    :placeholder="$therapist->title" autofocus />
                <x-jet-input-error for="title" class="mt-2" />
            </div>
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name', $therapist->name)"
                    :placeholder="$therapist->name" autofocus />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            {{-- <x-form-field id="preferred_name"
                name="preferred_name"
                type="text"
                label="Preferred Name"
                :value="$therapist->preferred_name" /> --}}
            {{--
            <x-form-field
                id="preferred_name"
                name="preferred_name"
                type="text"
                label="Preferred Name"
                    :value="old('preferred_name', $therapist->preferred_name)"

                :placeholder="$therapist->preferred_name"
                >
                {{ $therapist->preferred_name }}
            </x-form-field> --}}
            <div>
                <x-jet-label for="preferred_name" value="{{ __('Preferred Name') }}" />
                <x-jet-input id="preferred_name" class="block w-full mt-1" type="text" name="preferred_name"
                    :value="old('preferred_name', $therapist->preferred_name)" :placeholder="$therapist->preferred_name" autofocus />
                <x-jet-input-error for="preferred_name" class="mt-2" />
            </div>

            {{-- email --}}
            {{-- <x-form-field id="email"
                name="email"
                type="text"
                label="Email">
                {{ $therapist->email }}
            </x-form-field> --}}
            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block w-full mt-1" type="text" name="email" :value="old('email', $therapist->email)"
                    :placeholder="$therapist->email" autofocus />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
            {{-- gender --}}
            {{-- <div class="col-span-6 mt-0 sm:col-span-4">
                <x-multi-select id="gender"
                    name="gender"
                    value="{{ $therapist->gender }}"
                    label="Gender:   (previous selection: {{ $therapist->gender }}) "
                    placeholder="{{ $therapist->gender }}"
                    :options="['Male', 'Female', 'Non-binary', 'Prefer Not To Say']"></x-multi-select>
            </div> --}}
            <div class="relative w-full mt-6 mb-4"
                x-data='{
                    showGender: false,
                    selectedOptions: [],
                    toggleSelectedOption(option) {
                        if (this.selectedOptions.includes(option)) {
                            this.selectedOptions = this.selectedOptions.filter(item => item !== option);
                        } else {
                            this.selectedOptions.push(option);
                        }
                    }
                }'
                x-init="alpine.watch('showOptions', value => { if (!value) showOptions = false; })">
                <x-form_label>
                    Gender(s): (previous selection: {{ str_replace(['[', ']', '"'], '', $therapist->gender) }})
                </x-form_label>
                <div class="rounded-md" @click.away="showGender = false">
                    <div class="flex justify-between w-full p-3 bg-gray-100 border border-blue-300 rounded-md">
                        <button class="-m-0.5 flex w-full justify-between text-gray-700" type="button"
                            @click="showGender = !showGender">
                            <span class="ml-0"
                                x-text="selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Select Options'"></span>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="w-full pt-1 -mt-1 text-gray-600 bg-gray-100 border-b border-l border-r border-blue-300 rounded-t-none rounded-b-md md:flex md:flex-wrap"
                        x-show="showGender" x-transition.scale.origin.top x-transition.duration.300ms
                        x-transition.ease-in-out x-cloak>
                        @foreach ($genders as $gender)
                            <div class="flex flex-row m-3">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    name="gender[]" type="checkbox" value="{{ $gender }}">
                                <label class="" for="{{ $gender }}">{{ $gender }}</label>
                            </div>
                        @endforeach
                        <div class="select-input-div">
                            <input class="select-input" id="otherGenderCheckbox" name="gender[]" type="checkbox"
                                value="Other">
                            <label class="ml-2" for="otherGender">Other</label>
                        </div>

                        <div class="flex flex-row m-3">
                            <input
                                class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                id="otherGenderInput" name="otherGender" type="text" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- intern --}}
            <div class="col-span-6 mt-4 mb-4 sm:col-span-4">
                <x-jet-label for="intern" value="{{ __('Intern') }}" />
                <div class="flex items-center mt-1">
                    <label for="intern_yes" class="mr-4">
                        <input id="intern_yes" type="radio" name="intern" value="1"
                            {{ $therapist->intern == 1 ? 'checked' : '' }} />
                        <span class="ml-2 text-sm text-gray-600">Yes</span>
                    </label>

                    <label for="intern_no">
                        <input id="intern_no" type="radio" name="intern" value="0"
                            {{ $therapist->intern == 0 ? 'checked' : '' }} />
                        <span class="ml-2 text-sm text-gray-600">No</span>
                    </label>
                </div>
                <x-jet-input-error class="mt-2" for="intern" />
            </div>


            {{-- supervisor_name --}}
            {{-- <x-form-field id="supervisor_name"
                name="supervisor_name"
                type="text"
                label="Supervisor Name">
                {{ $therapist->supervisor_name }}
            </x-form-field> --}}
            <div>
                <x-jet-label for="supervisor_name" value="{{ __('Supervisor Name') }}" />
                <x-jet-input id="supervisor_name" class="block w-full mt-1" type="text" name="supervisor_name"
                    :value="old('supervisor_name', $therapist->supervisor_name)" :placeholder="$therapist->supervisor_name" autofocus />
                <x-jet-input-error for="supervisor_name" class="mt-2" />
            </div>

            {{-- street_address --}}

            <div>
                <x-jet-label for="street_address" value="{{ __('Street Address') }}" />
                <x-jet-input id="street_address" class="block w-full mt-1" type="text" name="street_address"
                    :value="old('street_address', $therapist->street_address)" :placeholder="$therapist->street_address" autofocus />
                <x-jet-input-error for="street_address" class="mt-2" />
            </div>


            <div>
                <x-jet-label for="county_town" value="{{ __('County/Town') }}" />
                <x-jet-input id="county_town" class="block w-full mt-1" type="text" name="county_town"
                    :value="old('county_town', $therapist->county_town)" :placeholder="$therapist->county_town" autofocus />
                <x-jet-input-error for="county_town" class="mt-2" />
            </div>

            <div class="relative w-full mt-6 mb-4">
                <x-form_label for="country">
                    Country: (previous selection: {{ $therapist->country }})
                </x-form_label>
                <select class="w-full p-2 mt-2 bg-gray-100 border-blue-200 rounded-md peer ring-0" id=""
                    name="country">
                    <option value="" disabled selected hidden>Previous: {{ $therapist->country }}
                    </option>
                    @foreach ($clientCountries as $country)
                        <option value="{{ $country }}" @if ($country == $therapist->country) selected @endif>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-jet-label for="zip_code_postal_code" value="{{ __('Zip Code') }}" />
                <x-jet-input id="zip_code_postal_code" class="block w-full mt-1" type="text"
                    name="zip_code_postal_code" :value="old('zip_code_postal_code', $therapist->zip_code_postal_code)" :placeholder="$therapist->zip_code_postal_code" autofocus />
                <x-jet-input-error for="zip_code_postal_code" class="mt-2" />
            </div>

            <div class="relative w-full mt-6 mb-4">
                <x-form_label for="time_zone">
                    Time Zone:
                </x-form_label>
                <select class="w-full p-2 mt-2 bg-gray-100 border-blue-200 rounded-md peer ring-0" id="time_zone"
                    name="time_zone">
                    <option value="" disabled selected hidden>Previous: {{ $therapist->time_zone }}
                    </option>
                    @foreach ($timeZones as $timeZone)
                        <option value="{{ $timeZone }}" @if ($timeZone == $therapist->time_zone) selected @endif>
                            {{ $timeZone }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div>
                <x-jet-label for="account_name" value="{{ __('Account Name') }}" />
                <x-jet-input id="account_name" class="block w-full mt-1" type="text" name="account_name"
                    :value="old('account_name', $therapist->account_name)" :placeholder="$therapist->account_name" autofocus />
                <x-jet-input-error for="account_name" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="account_number" value="{{ __('Account Number') }}" />
                <x-jet-input id="account_number" class="block w-full mt-1" type="text" name="account_number"
                    :value="old('account_number', $therapist->account_number)" :placeholder="$therapist->account_number" autofocus />
                <x-jet-input-error for="account_number" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="routing_number" value="{{ __('Routing Number') }}" />
                <x-jet-input id="routing_number" class="block w-full mt-1" type="text" name="routing_number"
                    :value="old('routing_number', $therapist->routing_number)" :placeholder="$therapist->routing_number" autofocus />
                <x-jet-input-error for="routing_number" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="iban_swift_code" value="{{ __('IBAN/Swift Code') }}" />
                <x-jet-input id="iban_swift_code" class="block w-full mt-1" type="text" name="iban_swift_code"
                    :value="old('iban_swift_code', $therapist->iban_swift_code)" :placeholder="$therapist->iban_swift_code" autofocus />
                <x-jet-input-error for="iban_swift_code" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="number_of_potential_clients" value="{{ __('Number of potential clients') }}" />
                <x-jet-input id="number_of_potential_clients" class="block w-full mt-1" type="number"
                    name="number_of_potential_clients" :value="old('number_of_potential_clients', $therapist->number_of_potential_clients)" :placeholder="$therapist->number_of_potential_clients" autofocus />
                <x-jet-input-error for="number_of_potential_clients" class="mt-2" />
            </div>

            <div>
                <x-jet-label value="Client Extensions" />
                <x-jet-input class="block p-2 mt-1 border border-blue-200" id="client_extensions"
                    name="client_extensions" type="number" value="{{ $therapist->client_extensions }}"
                    wire:model.defer="state.client_extensions" />
                <x-jet-input-error class="mt-2" for="client_extensions" />
            </div>


            <div>
                <x-jet-label for="out_of_state_coaching" value="{{ __('Out of State Coaching') }}" />
                <div class="flex items-center mt-2">
                    <label for="out_of_state_coaching_yes" class="mr-4">
                        <input id="out_of_state_coaching_yes" type="radio" name="out_of_state_coaching"
                            value="1" {{ $therapist->out_of_state_coaching == 1 ? 'checked' : '' }} autofocus />
                        <span class="ml-2 text-sm text-gray-600">Yes</span>
                    </label>

                    <label for="out_of_state_coaching_no">
                        <input id="out_of_state_coaching_no" type="radio" name="out_of_state_coaching"
                            value="0" {{ $therapist->out_of_state_coaching == 0 ? 'checked' : '' }} />
                        <span class="ml-2 text-sm text-gray-600">No</span>
                    </label>
                </div>
                <x-jet-input-error for="out_of_state_coaching" class="mt-2" />

                {{-- promotional_content --}}
                <div class="col-span-6 mt-2 mt-4 sm:col-span-4">
                    <x-jet-label for="contact_for_promotionals" value="{{ __('Contact for Promotionals') }}" />
                    <div class="flex items-center mt-2">
                        <label for="contact_for_promotionals_yes" class="mr-4">
                            <input id="contact_for_promotionals_yes" type="radio" name="contact_for_promotionals"
                                value="1" {{ $therapist->contact_for_promotionals == 1 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">Yes</span>
                        </label>

                        <label for="contact_for_promotionals_no">
                            <input id="contact_for_promotionals_no" type="radio" name="contact_for_promotionals"
                                value="0" {{ $therapist->contact_for_promotionals == 0 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">No</span>
                        </label>
                    </div>

                    <x-jet-input-error for="contact_for_promotionals" class="mt-2" />
                </div>

                {{-- active_status --}}
                <div class="col-span-6 mt-4 sm:col-span-4">
                    <x-jet-label for="active_status" value="{{ __('Active Status') }}" />

                    <div class="flex items-center mt-2">
                        <label for="active_status_yes" class="mr-4">
                            <input id="active_status_yes" type="radio" name="active_status" value="1"
                                {{ $therapist->active_status == 1 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">Yes</span>
                        </label>

                        <label for="active_status_no">
                            <input id="active_status_no" type="radio" name="active_status" value="0"
                                {{ $therapist->active_status == 0 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">No</span>
                        </label>
                    </div>

                    <x-jet-input-error for="active_status" class="mt-2" />
                </div>

                {{-- contract_signed --}}
                <div class="col-span-6 mt-4 sm:col-span-4">
                    <x-jet-label for="contract_signed" value="{{ __('Contract Signed') }}" />

                    <div class="flex items-center mt-2">
                        <label for="contract_signed_yes" class="mr-4">
                            <input id="contract_signed_yes" type="radio" name="contract_signed" value="1"
                                {{ $therapist->contract_signed == 1 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">Yes</span>
                        </label>

                        <label for="contract_signed_no">
                            <input id="contract_signed_no" type="radio" name="contract_signed" value="0"
                                {{ $therapist->contract_signed == 0 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">No</span>
                        </label>
                    </div>

                    <x-jet-input-error for="contract_signed" class="mt-2" />
                </div>

                {{-- all_documents --}}
                <div class="col-span-6 mt-4 sm:col-span-4">
                    <x-jet-label for="all_documents" value="{{ __('All Documents') }}" />

                    <div class="flex items-center mt-2">
                        <label for="all_documents_yes" class="mr-4">
                            <input id="all_documents_yes" type="radio" name="all_documents" value="1"
                                {{ $therapist->all_documents == 1 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">Yes</span>
                        </label>

                        <label for="all_documents_no">
                            <input id="all_documents_no" type="radio" name="all_documents" value="0"
                                {{ $therapist->all_documents == 0 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">No</span>
                        </label>
                    </div>

                    <x-jet-input-error for="all_documents" class="mt-2" />
                </div>

                <div class="col-span-6 mt-4 sm:col-span-4">
                    <x-jet-label for="website" value="{{ __('Website') }}" />
                    <div class="flex items-center mt-2">
                        <label for="website_yes" class="mr-4">
                            <input id="website_yes" type="radio" name="website" value="1"
                                {{ $therapist->website == 1 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">Yes</span>
                        </label>

                        <label for="website_no">
                            <input id="website_no" type="radio" name="website" value="0"
                                {{ $therapist->website == 0 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">No</span>
                        </label>
                    </div>
                    <x-jet-input-error for="website" class="mt-2" />
                </div>

                {{-- quickbooks --}}
                <div class="col-span-6 mt-4 mb-4 sm:col-span-4">
                    <x-jet-label for="quickbooks" value="{{ __('Quickbooks') }}" />
                    <div class="flex items-center mt-2">
                        <label for="quickbooks_yes" class="mr-4">
                            <input id="quickbooks_yes" type="radio" name="quickbooks" value="1"
                                {{ $therapist->quickbooks == 1 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">Yes</span>
                        </label>

                        <label for="quickbooks_no">
                            <input id="quickbooks_no" type="radio" name="quickbooks" value="0"
                                {{ $therapist->quickbooks == 0 ? 'checked' : '' }} />
                            <span class="ml-2 text-sm text-gray-600">No</span>
                        </label>
                    </div>
                    <x-jet-input-error for="quickbooks" class="mt-2" />
                </div>

                <div class="flex flex-row w-full gap-2">
                    <div class="flex flex-col w-/12">
                        <x-jet-label for="session_cost" value="{{ __('Session Cost') }}" />
                        <x-jet-input id="session_cost" class="block w-full mt-1" type="number" step="1.00" max="500" name="session_cost"
                            :value="old('session_cost', $therapist->session_cost)" :placeholder="$therapist->session_cost" autofocus />
                        <x-jet-input-error for="session_cost" class="mt-2" />
                    </div>

                    {{-- add the currency --}}
                    <div class="flex flex-col w-1/2">
                        <x-jet-label value="Currency" />
                        <select class="block w-full mt-1 bg-gray-100 border border-blue-300 rounded-md" id="currency"
                            name="currency">
                            <option value="">Select currency &nbsp &nbsp
                                &nbsp(selected:{{ $therapist->currency }})
                            </option>
                            @foreach ($currencies as $currency => $currencyCode)
                                <option value="{{ $currencyCode }}"
                                    {{ $therapist->currency == $currencyCode ? 'selected' : '' }}>
                                    {{ $currency }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- notes --}}
                <div class="w-full">
                    <x-jet-label for="notes" value="{{ __('Notes') }}" />
                    <textarea class="w-full bg-gray-100 border border-blue-200 rounded" id="notes" type="text" cols="30"
                        width: 100%; wire:model.defer="state.notes" autocomplete="notes"></textarea>
                    <x-jet-input-error class="mt-2" for="notes" />
                </div>


                <button class="button" type="submit">Submit</button>
        </form>

        <div class="w-2/3 mx-auto my-4 border border-b border-gray-300">

        </div>

        <div class="flex mt-2">
            <button class="mx-auto button-secondary">
                <a href="{{ route('therapist.forms', ['therapist' => $therapist]) }}">
                    View Forms
                </a>
            </button>
        </div>
    </x-main-container>
</x-app-layout>

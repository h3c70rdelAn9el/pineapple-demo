@php
    // TODO:  IS THIS OKAY?
    // $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));
    // $timeZones = json_decode($timeZonesJson, true);
    // $statesJson = file_get_contents(resource_path('json/states.json'));
    // $states = json_decode($statesJson, true);
    $countriesJson = file_get_contents(resource_path('json/countries.json'));
    $clientCountries = json_decode($countriesJson, true);
@endphp

<x-app-layout>
    <x-main-container>
        <h2 class="mt-2 text-center text-lg font-normal">Edit client: {{ $client->preferred_name }}</h2>
        <div class="mx-auto w-1/2 border-b border-gray-400 bg-gray-400">
        </div>
        <form class="mx-auto w-1/2"
            action="{{ route('clients.update', $client->id) }}"
            method="POST">
            @csrf
            @method('POST')
            <input name="_method"
                type="hidden"
                value="POST">

            <input name="user_id"
                type="hidden"
                value="{{ $client->user_id }}">

            {{-- client_code --}}
            {{-- <x-form-field name="client_code"
                type="text"
                label="Client Code">
                {{ $client->client_code }}
            </x-form-field> --}}
            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="client_code"
                    value="{{ __('Client Code') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100"
                    id="client_code"
                    name="client_code"
                    type="text"
                    value="{{ old('client_code', $client->client_code) }}"
                    placeholder="{{ old('client_code', $client->client_code) }}"
                    autocomplete="client_code" />
                <x-jet-input-error class="mt-2"
                    for="client_code" />
            </div>

            {{-- <x-form-field name="preferred_name"
                type="text"
                value="{{ old('preferred_name', $client->preferred_name) }}"
                label="Preferred Name">
                {{ old('preferred_name', $client->preferred_name) }}
            </x-form-field> --}}
            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="preferred_name"
                    value="{{ __('Preferred Name') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100"
                    id="preferred_name"
                    name="preferred_name"
                    type="text"
                    value="{{ old('preferred_name', $client->preferred_name) }}"
                    placeholder="{{ old('preferred_name', $client->preferred_name) }}"
                    autocomplete="preferred_name" />
                <x-jet-input-error class="mt-2"
                    for="preferred_name" />
            </div>

            {{-- max_sessions --}}
            <label for="max_sessions">Maximum Therapy Sessions:</label>
            <input class="mx-2 w-16 rounded-md border-blue-200 bg-gray-100 p-1 text-center ring-0"
                id="max_sessions"
                name="max_sessions"
                type="number"
                value="{{ $client->max_sessions }}">

            {{-- legal_name --}}
            {{-- <x-form-field name="legal_name"
                type="text"
                label="Legal Name">
                {{ $client->legal_name }}
            </x-form-field> --}}
            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="legal_name"
                    value="{{ __('Legal Name') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100"
                    id="legal_name"
                    name="legal_name"
                    type="text"
                    value="{{ old('legal_name', $client->legal_name) }}"
                    placeholder="{{ old('legal_name', $client->legal_name) }}"
                    autocomplete="legal_name" />
                <x-jet-input-error class="mt-2"
                    for="legal_name" />
            </div>

            {{-- Status --}}
            <x-form_label for="status">
                Status
            </x-form_label>
            <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 ring-0"
                id="status"
                name="status"
                type="text">
                <option value=""
                    disabled
                    selected
                    hidden>Previous: {{ $client->status == 0 ? 'Active' : 'Inactive' }}</option>
                <option value="0">Active</option>
                <option value="1">Inactive</option>
            </select>

            {{-- email --}}
            {{-- <x-form-field name="email"
                type="text"
                label="Email">
                {{ $client->email }}
            </x-form-field> --}}
            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="email"
                    value="{{ __('Email') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100"
                    id="email"
                    name="email"
                    type="text"
                    value="{{ old('email', $client->email) }}"
                    placeholder="{{ old('email', $client->email) }}"
                    autocomplete="email" />
                <x-jet-input-error class="mt-2"
                    for="email" />
            </div>

            {{-- phone --}}
            {{-- <x-form-field name="phone"
                type="text"
                label="Phone">
                {{ $client->phone }}
            </x-form-field> --}}
            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="phone"
                    value="{{ __('Phone') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100"
                    id="phone"
                    name="phone"
                    type="text"
                    value="{{ old('phone', $client->phone) }}"
                    placeholder="{{ old('phone', $client->phone) }}"
                    autocomplete="phone" />
                <x-jet-input-error class="mt-2"
                    for="phone" />
            </div>

            <div class="relative mb-4 mt-6 w-full"
                x-data='{
                    showOptions: false,
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
                    Preferred Contact Method
                </x-form_label>
                <div class="rounded-md"
                    @click.away="showOptions = false">
                    <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3">
                        <button class="-m-0.5 flex w-full justify-between text-gray-700"
                            type="button"
                            @click="showOptions = !showOptions">
                            <span class="ml-0"
                                x-text="selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Select Options'"></span>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="-mt-1 w-full rounded-b-md rounded-t-none border-b border-l border-r border-blue-300 bg-gray-100 pt-1 text-gray-600 md:flex md:flex-wrap"
                        x-show="showOptions"
                        x-transition.scale.origin.top
                        x-transition.duration.300ms
                        x-transition.ease-in-out
                        x-cloak>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="telephone-call"
                                name="contact_method[]"
                                type="checkbox"
                                value="Telephone Call">
                            <label class="ml-2"
                                for="telephone-call">Telephone Call</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="text-message"
                                name="contact_method[]"
                                type="checkbox"
                                value="Text Message">
                            <label class="ml-2"
                                for="text-message">Text Message</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="email"
                                name="contact_method[]"
                                type="checkbox"
                                value="Email">
                            <label class="ml-2"
                                for="email">Email</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-4 rounded-lg border-2 border-blue-300 bg-blue-100 p-2">
                <p>Optional Fields</p>

                <div class="relative mb-4 mt-6 w-full"
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
                        Gender(s): (previous selection: {{ $client->gender }})
                    </x-form_label>
                    <div class="rounded-md"
                        @click.away="showGender = false">
                        <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3">
                            <button class="-m-0.5 flex w-full justify-between text-gray-700"
                                type="button"
                                @click="showGender = !showGender">
                                <span class="ml-0"
                                    x-text="selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Select Options'"></span>
                                <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="-mt-1 w-full rounded-b-md rounded-t-none border-b border-l border-r border-blue-300 bg-gray-100 pt-1 text-gray-600 md:flex md:flex-wrap"
                            x-show="showGender"
                            x-transition.scale.origin.top
                            x-transition.duration.300ms
                            x-transition.ease-in-out
                            x-cloak>
                            @foreach ($genders as $gender)
                                <div class="m-3 flex flex-row">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        name="gender[]"
                                        type="checkbox"
                                        value="{{ $gender }}">
                                    <label class=""
                                        for="{{ $gender }}">{{ $gender }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Pronouns --}}
                <div class="col-span-6 mt-0 sm:col-span-4">
                    <div class="my-4 flex flex-col"
                        x-data="{ openPronouns: false, selectedPronouns: [] }">
                        <x-form_label for="pronouns">
                            Pronoun(s): (previous selection: {{ $client->pronouns }})
                        </x-form_label>
                        <button
                            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                            type="button"
                            @click="openPronouns = !openPronouns">
                            <span class="ml-0"
                                x-text="selectedPronouns.length > 0 ? selectedPronouns.join(', ') : 'Select Options'"></span>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                            x-show="openPronouns"
                            x-transition.scale.origin.top
                            x-transition:enter.duration.300ms
                            x-transition:enter.ease-in-out
                            x-transition:leave.duration.300ms
                            x-transition:ease-in-out
                            x-cloak>
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="she-her"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="She">
                                <label class="ml-2"
                                    for="she-her">She</label>
                            </div>
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="he-him"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="He">
                                <label class="ml-2"
                                    for="he-him">He</label>
                            </div>
                            {{-- him --}}
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="him"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Him">
                                <label class="ml-2">Him</label>
                            </div>
                            {{-- her --}}
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="her"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Her">
                                <label class="ml-2"
                                    for="her">Her</label>
                            </div>
                            {{-- his --}}
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="his"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="His">
                                <label class="ml-2"
                                    for="his">His</label>
                            </div>

                            {{-- her --}}
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="hers"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Hers">
                                <label class="ml-2"
                                    for="hers">Hers</label>
                            </div>

                            {{-- ze --}}
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="ze"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Ze">
                                <label class="ml-2"
                                    for="ze">Ze</label>
                            </div>

                            {{-- zir --}}
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="zir"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Zir">
                                <label class="ml-2"
                                    for="zir">Zir</label>
                            </div>

                            <div class="select-input-div">
                                <input class="select-input"
                                    id="they"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="They">
                                <label class="ml-2"
                                    for="they-them">They</label>
                            </div>
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="them"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Them">
                                <label class="ml-2"
                                    for="ze-zir">Them</label>
                            </div>
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="other-pronouns"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Other">
                                <label class="ml-2"
                                    for="other-pronouns">Other</label>
                            </div>

                            {{-- prefer not to say --}}
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="prefer-not-to-say-pronouns"
                                    name="pronouns[]"
                                    type="checkbox"
                                    value="Prefer Not To Say">
                                <label class="ml-2"
                                    for="prefer-not-to-say-pronouns">Prefer Not To Say</label>
                            </div>

                            <!-- Add similar blocks for other pronoun options -->
                        </div>
                    </div>
                </div>

                {{-- sexual_orientation --}}
                <div class="col-span-6 mt-0 sm:col-span-4">
                    <div class="my-4 flex flex-col"
                        x-data="{ openSexualOrientation: false, selectedSexualOrientation: [] }">
                        <x-form_label for="sexual_orientation">
                            Sexual Orientation: (previous selection: {{ $client->sexual_orientation }})
                        </x-form_label>
                        <button
                            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                            type="button"
                            @click="openSexualOrientation = !openSexualOrientation">
                            <span class="ml-0"
                                x-text="selectedSexualOrientation.length > 0 ? selectedSexualOrientation.join(', ') : 'Select Options'"></span>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                            x-show="openSexualOrientation"
                            x-transition.scale.origin.top
                            x-transition:enter.duration.300ms
                            x-transition:enter.ease-in-out
                            x-transition:leave.duration.300ms
                            x-transition:ease-in-out
                            x-cloak>
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="heterosexual"
                                    name="sexual_orientation[]"
                                    type="checkbox"
                                    value="Heterosexual">
                                <label class="ml-2"
                                    for="heterosexual">Heterosexual</label>
                            </div>
                            {{-- add the above for bisexual, queer, prefer not to say, other --}}

                            <div class="select-input-div">
                                <input class="select-input"
                                    id="bisexual"
                                    name="sexual_orientation[]"
                                    type="checkbox"
                                    value="Bisexual">
                                <label class="ml-2"
                                    for="bisexual">Bisexual</label>
                            </div>

                            <div class="select-input-div">
                                <input class="select-input"
                                    id="queer"
                                    name="sexual_orientation[]"
                                    type="checkbox"
                                    value="Queer">
                                <label class="ml-2"
                                    for="queer">Queer</label>
                            </div>

                            <div class="select-input-div">
                                <input class="select-input"
                                    id="prefer-not-to-say-orientation"
                                    name="sexual_orientation[]"
                                    type="checkbox"
                                    value="Prefer Not To Say">
                                <label class="ml-2"
                                    for="prefer-not-to-say-orientation">Prefer Not To Say</label>
                            </div>

                            <div class="select-input-div">
                                <input class="select-input"
                                    id="other-orientation"
                                    name="sexual_orientation[]"
                                    type="checkbox"
                                    value="Other">
                                <label class="ml-2"
                                    for="other-orientation">Other</label>
                            </div>
{{--
                               "He",
            "She",
            "They",
            "Ze",
            "Per",
            "Him",
            "Her",
            "Them",
            "Zir",
            "Prefer Not To Say",
            "Other" --}}

                            <!-- Add similar blocks for other sexual orientation options -->
                        </div>
                    </div>
                </div>

                {{-- Ethnic groups --}}
                <div class="my-4 flex flex-col"
                    x-data="{ openEthnicGroup: false, selectedEthnicGroups: [] }">
                    <x-jet-label>Ethnic Group</x-jet-label>
                    <button
                        class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                        type="button"
                        @click="openEthnicGroup = !openEthnicGroup">
                        <span class="ml-0"
                            x-text="selectedEthnicGroups.length > 0 ? selectedEthnicGroups.join(', ') : 'Select Options'"></span>
                        <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                        x-show="openEthnicGroup"
                        x-transition.scale.origin.top
                        x-transition:enter.duration.300ms
                        x-transition:enter.ease-in-out
                        x-transition:leave.duration.300ms
                        x-transition:ease-in-out
                        x-cloak>

                        <div class="select-input-div">
                            <input class="select-input"
                                id="american-indian"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="American Indian or Alaska Native">
                            <label class="ml-2"
                                for="american-indian">American Indian or Alaska Native</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="asian"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="Asian">
                            <label class="ml-2"
                                for="asian">Asian</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="black"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="Black or African American">
                            <label class="ml-2"
                                for="black">Black or African American</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="hispanic"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="Hispanic or Latino">
                            <label class="ml-2"
                                for="hispanic">Hispanic or Latino</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="pacific-islander"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="Native Hawaiian or Other Pacific Islander">
                            <label class="ml-2"
                                for="pacific-islander">Native Hawaiian or Other Pacific Islander</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="white"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="White">
                            <label class="ml-2"
                                for="white">White</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="prefer-not-to-say-ethnic"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="prefer not to say">
                            <label class="ml-2"
                                for="prefer-not-to-say-ethnic">Prefer Not To Say</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input"
                                id="other-ethnic"
                                name="ethnic_group[]"
                                type="checkbox"
                                value="Other">
                            <label class="ml-2"
                                for="other-ethnic">Other</label>
                        </div>

                    </div>
                </div>

                {{-- home_address_state --}}
                {{-- <x-single-select id="home_address_state"
                    name="home_address_state"
                    value="{{ $client->home_address_state }}"
                    label="State:   (previous selection: {{ $client->home_address_state }}) "
                    placeholder="{{ $client->home_address_state }}"
                    :options="$states"></x-single-select> --}}
                <div class="relative mb-4 mt-6 w-full">
                    <x-form_label for="home_address_state">
                        State: (previous selection: {{ $client->home_address_state }})
                    </x-form_label>
                    <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 ring-0"
                        id="home_address_state"
                        name="home_address_state">
                        <option value=""
                            disabled
                            selected
                            hidden>Previous: {{ $client->home_address_state }}</option>
                        @foreach ($states as $state)
                            <option value="{{ $state }}"
                                @if ($state == $client->home_address_state) selected @endif>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- home_address_country --}}
                {{-- <x-single-select id="home_address_country"
                    name="home_address_country"
                    value="{{ $client->home_address_country }}"
                    label="Country: (previous selection: {{ $client->home_address_country }})"
                    placeholder="{{ $client->home_address_country }}"
                    :options="$clientCountries"></x-single-select> --}}
                <div class="relative mb-4 mt-6 w-full">
                    <x-form_label for="home_address_country">
                        Country: (previous selection: {{ $client->home_address_country }})
                    </x-form_label>
                    <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 ring-0"
                        id=""
                        name="">
                        <option value=""
                            disabled
                            selected
                            hidden>Previous: {{ $client->home_address_country }}</option>
                        @foreach ($clientCountries as $country)
                            <option value="{{ $country }}"
                                @if ($country == $client->home_address_country) selected @endif>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>

            {{-- previous therapy --}}
            <div class="col-span-6 my-4 sm:col-span-4">
                <x-jet-label for="Previous Therapy from Pineapple"
                    value="Previous Therapy from Pineapple:  previous: {{ $client->previous_therapy == 0 ? 'No' : 'Yes' }}" />
                <input class="rounded"
                    id="previous_therapy"
                    type="checkbox"
                    wire:model.defer="state.previous_therapy"
                    autocomplete="previous_therapy" />
                <x-jet-input-error class="mt-2"
                    for="previous_therapy" />
            </div>

            {{-- Possible Support Needed --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <div class="relative mb-4 mt-6 w-full"
                    x-data="{ showDropdown: false }">
                    <x-form_label for="possible_support_needed">
                        <p>Possible Support Needed <span class="ml-2 text-xs">Previous selection:
                                {{ $client->possible_support_needed }}</span></p>
                    </x-form_label>
                    <div class="rounded-md"
                        @click.away="showDropdown = false">
                        <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-1.5">
                            <button class="flex w-full flex-row justify-between"
                                type="button"
                                @click="showDropdown = !showDropdown">
                                <p class="ml-1 p-1">Select Options</p>
                                <svg class="mt-1 h-[18px] w-[18px] text-gray-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="rounded-md bg-gray-50 md:flex md:flex-wrap"
                            x-show="showDropdown"
                            x-transition.scale.origin.top
                            x-cloak>
                            @foreach ($categories as $category)
                                <label class="items-center p-2">
                                    <input class="mb-0.5 rounded-md transition-all duration-300 hover:bg-blue-300"
                                        name="possible_support_needed[]"
                                        type="checkbox"
                                        value="{{ $category }}"
                                        @if (is_array(old('possible_support_needed')) && in_array($category, old('possible_support_needed'))) checked @endif>
                                    {{ $category }}
                                </label><br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- client_contribution --}}
            {{-- <x-form-field name="client_contribution"
                type="text"
                label="Client Contribution">
                {{ $client->client_contribution }}
            </x-form-field> --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-jet-label for="client_contribution"
                    value="Client Contribution:  previous: {{ $client->client_contribution }}" />
                <input class="rounded"
                    id="client_contribution"
                    type="checkbox"
                    wire:model.defer="state.client_contribution"
                    autocomplete="client_contribution" />
                <x-jet-input-error class="mt-2"
                    for="client_contribution" />
            </div>

            {{-- Therapist --}}
            {{-- <x-form_label for="therapist">
                Therapist
            </x-form_label> --}}

            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-jet-label for="therapist"
                    value="Therapist:  previous: {{ $therapist->name }}" />
                <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 capitalize ring-0"
                    id="user_id"
                    name="user_id">
                    <option value=""
                        disabled
                        selected
                        hidden>Previous: {{ $therapist->name }}</option>

                    @php
                        $groupedTherapists = $therapists->groupBy('state')->sortKeys();
                    @endphp

                    @foreach ($groupedTherapists as $state => $therapistsInState)
                        @php
                            $activeTherapistsInState = $therapistsInState->filter(function ($therapist) {
                                return $therapist->active_status == 0;
                            });
                        @endphp

                        @if ($activeTherapistsInState->isNotEmpty())
                            <optgroup label="{{ $state }}">
                                @foreach ($activeTherapistsInState as $therapist)
                                    <option value="{{ $therapist->id }}">
                                        {{ $therapist->name }}
                                        @if (!empty($therapist->state))
                                            (State: {{ $therapist->state }})
                                        @else
                                            (No state available)
                                        @endif
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- additional_notes --}}
            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="notes"
                    value="{{ __('Notes') }}" />
                <textarea class="w-full rounded border border-blue-200 bg-gray-100"
                    id="notes"
                    type="text"
                    cols="30"
                    width:
                    100%;
                    wire:model.defer="state.notes"
                    placeholder="Enter notes here..."
                    autocomplete="notes"></textarea>
                <x-jet-input-error class="mt-2"
                    for="notes" />
            </div>

            <x-jet-button class="ml-4"
                type="submit">
                {{ __('Update') }}
            </x-jet-button>
        </form>
    </x-main-container>
</x-app-layout>

<script src="{{ asset('js/intlTelInput.js') }}"></script>
<script src="{{ asset('js/utils.js') }}"></script>

<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        // initialCountry: "us",
        separateDialCode: true,
        utilsScript: "{{ asset('js/utils.js') }}",
    });
</script>

<script>
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        separateDialCode: true,
        utilsScript: "{{ asset('js/utils.js') }}",
    });

    var selectedCountryCode = iti.getSelectedCountryData().iso2;

    // Get the country data used by intlTelInput
    const countryData = window.intlTelInputGlobals.getCountryData();
</script>

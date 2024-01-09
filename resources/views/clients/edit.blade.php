@php
    // TODO:  IS THIS OKAY?
    // $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));
    // $timeZones = json_decode($timeZonesJson, true);
    // $statesJson = file_get_contents(resource_path('json/states.json'));
    // $states = json_decode($statesJson, true);
    $countriesJson = file_get_contents(resource_path('json/countries.json'));
    $clientCountries = json_decode($countriesJson, true);
    $sexualOrientations = ['Heterosexual/Straight', 'Gay/Lesbian', 'Bisexual', 'Don\'t Know', 'Prefer Not to Say'];
    $pronouns = ['He/Him/His', 'She/Her/Hers', 'They/Them/Theirs', 'Per/Per/Pers', 'Ze/Hir/Hirs', 'Prefer Not to Say', 'Other'];
    $contactMethods = ['Telephone Call', 'Text Message', 'Email'];
    $ethnicGroups = ['American Indian or Alaska Native', 'Asian', 'Black or African American', 'Hispanic or Latino', 'Native Hawaiian or Other Pacific Islander', 'White', 'Prefer Not to Say'];
    $selectedEthnicGroups = $client->ethnic_group ? json_decode($client->ethnic_group) : [];
    $selectedPossibleSupportNeeded = $client->possible_support_needed ? json_decode($client->possible_support_needed) : [];
    $selectedPronouns = $client->pronouns ? json_decode($client->pronouns) : [];
    $selectedSexualOrientation = $client->sexual_orientation ? json_decode($client->sexual_orientation) : [];
    $selectedOptions = $client->options ? json_decode($client->options) : [];
@endphp


<x-app-layout>
    <x-main-container
        x-data="{
            submitForm() {
                document.getElementById('client-edit-form').submit();
            }
        }"
    >

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="mt-2 text-center text-lg font-normal">Edit client: {{ $client->preferred_name }}</h2>
        <div class="mx-auto w-1/2 border-b border-gray-400 bg-gray-400">
        </div>
        <form class="form" action="{{ route('clients.update', $client->id) }}" method="POST" id="client-edit-form"
            @submit.prevent="submitForm">
            @csrf
            @method('POST')

            {{-- <input name="_method" type="hidden" value="POST"> --}}

            <input name="user_id" type="hidden" value="{{ $client->user_id }}">

            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="client_code" value="{{ __('Client Code') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100" id="client_code" name="client_code"
                    type="text" value="{{ old('client_code', $client->client_code) }}"
                    placeholder="{{ old('client_code', $client->client_code) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="client_code" />
            </div>

            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="preferred_name" value="{{ __('Preferred Name') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100" id="preferred_name"
                    name="preferred_name" type="text" value="{{ old('preferred_name', $client->preferred_name) }}"
                    placeholder="{{ old('preferred_name', $client->preferred_name) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="preferred_name" />
            </div>

            {{-- max_sessions --}}
            <label for="max_sessions">Maximum Therapy Sessions:</label>
            <input class="mx-2 w-16 rounded-md border-blue-200 bg-gray-100 p-1 text-center ring-0" id="max_sessions"
                name="max_sessions" type="number" value="{{ $client->max_sessions }}">

            {{-- legal_name --}}
            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="legal_name" value="{{ __('Legal Name') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100" id="legal_name" name="legal_name"
                    type="text" value="{{ old('legal_name', $client->legal_name) }}" {{-- value="{{ $client->legal_name }}" --}}
                    placeholder="{{ old('legal_name', $client->legal_name) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="legal_name" />
            </div>

            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100" id="email" name="email"
                    type="text" value="{{ old('email', $client->email) }}"
                    placeholder="{{ old('email', $client->email) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="email" />
            </div>

            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="phone" value="{{ __('Phone') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100" id="phone" name="phone"
                    type="text" value="{{ old('phone', $client->phone) }}"
                    placeholder="{{ old('phone', $client->phone) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="phone" />
            </div>



            <div class="relative mb-4 mt-6 w-full"
                x-data='{
                    showOptions: false,
                    selectedContactMethods: [],
                    toggleSelectedContactMethod(option) {
                        if (this.selectedContactMethods.includes(option)) {
                            this.selectedContactMethods = this.selectedContactMethods.filter(item => item !== option);
                        } else {
                            this.selectedContactMethods.push(option);
                        }
                    }
                }'
                x-init="alpine.watch('selectedContactMethods', value => { if (!value) selectedContactMethods = false; })">

                <x-form_label>
                    Contact Method(s): (previous selection:
                    {{ str_replace(['[', ']', '"'], '', $client->contact_method) }})
                </x-form_label>
                <div class="rounded-md" @click.away="showContactMethods = false">
                    <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3">
                        <button class="-m-0.5 flex w-full justify-between text-gray-700" type="button"
                            @click="showContactMethods = !showContactMethods">
                            Select Options:
                            <span class="ml-0"
                                x-text="selectedContactMethods.length > 0 ? selectedContactMethods.join(', ') : 'Select Options'">
                            </span>
                            <p></p>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="-mt-1 w-full rounded-b-md rounded-t-none border-b border-l border-r border-blue-300 bg-gray-100 pt-1 text-gray-600 md:flex md:flex-wrap"
                        x-show="showContactMethods" x-transition.scale.origin.top x-transition.duration.300ms
                        x-transition.ease-in-out x-cloak>
                        @foreach ($contactMethods as $method)
                            <div class="select-input-div">
                                <input class="select-input" id="{{ $method }}" name="contact_method[]"
                                    type="checkbox" value="{{ $method }}"
                                    :checked="selectedContactMethods.includes('{{ $method }}')"
                                    @click="toggleSelectedContactMethod('{{ $method }}')">
                                <label class="ml-2" for="{{ $method }}">{{ $method }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>



            <div class="my-4 rounded-lg border-2 border-blue-300 bg-blue-100 p-2">
                <p>Optional Fields</p>

                <div class="relative mb-4 mt-6 w-full"
                    x-data='{
                        showGender: false,
                        selectedOptions: @json($client->gender ?? []),
                        otherGender: @json(str_contains($client->gender ?? '', 'Other') ? 'Other' : ''),

                        toggleSelectedOption(option) {
                            if (option === "Other") {
                                this.toggleOtherCheckbox();
                            } else {
                                if (this.selectedOptions.includes(option)) {
                                    this.selectedOptions = this.selectedOptions.filter(item => item !== option);
                                } else {
                                    this.selectedOptions.push(option);
                                }
                            }
                        },

                        toggleOtherCheckbox() {
                            if (this.selectedOptions.includes("Other")) {
                                this.selectedOptions = this.selectedOptions.filter(item => item !== "Other");
                                this.otherGender = "";
                            } else {
                                this.selectedOptions.push("Other");
                                this.otherGender = "Other";
                            }
                        }
                    }'>
                    <x-form_label>
                        Gender(s): (previous selection: {{ str_replace(['[', ']', '"'], '', $client->gender) }})
                    </x-form_label>
                    <div class="rounded-md" @click.away="showGender = false">
                        <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3">
                            <button class="-m-0.5 flex w-full justify-between text-gray-700" type="button"
                                @click="showGender = !showGender">
                                <span class="ml-0"
                                    x-text="selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Select Options'"></span>
                                <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="-mt-1 w-full rounded-b-md rounded-t-none border-b border-l border-r border-blue-300 bg-gray-100 pt-1 text-gray-600 md:flex md:flex-wrap"
                            x-show="showGender" x-transition.scale.origin.top x-transition.duration.300ms
                            x-transition.ease-in-out x-cloak>
                            @foreach ($genders as $gender)
                                <div class="m-3 flex flex-row">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        name="gender[]" type="checkbox" value="{{ $gender }}"
                                        :checked="{{ in_array($gender, $selectedOptions) ? 'true' : 'false' }}"
                                        @click="toggleSelectedOption('{{ $gender }}')">
                                    <label class="" for="{{ $gender }}">{{ $gender }}</label>
                                </div>
                            @endforeach
                            <div class="select-input-div" x-data="{
                                otherGender: '',
                                showOtherInput: false
                            }">
                                <input class="select-input" id="otherGenderCheckbox" type="checkbox" value="Other"
                                    {{-- @click="toggleSelectedOption('Other')" @click="toggleOtherCheckbox()" --}} x-on:click="otherGender = ''"
                                    :checked="selectedOptions.includes('Other')">
                                <label class="ml-2" for="otherGender">Other</label>
                            </div>

                            <div class="m-3 flex flex-row">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherGenderInput" name="gender[]" type="text" style="display: none;"
                                    x-model="otherGender" x-show="showOtherInput">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-6 mt-0 sm:col-span-4">
                    <div class="my-4 flex flex-col"
                        x-data='
                        {
                            openPronouns: false,
                            {{-- selectedPronouns: @json($client->pronouns ?? []), --}}
                            selectedPronouns: @json(is_array($client->pronouns) ? $client->pronouns : []),
                            toggleSelectedPronoun(option) {
                                if (this.selectedPronouns.includes(option)) {
                                    this.selectedPronouns = this.selectedPronouns.filter(item => item !== option);
                                } else {
                                    this.selectedPronouns.push(option);
                                }
                            }
                        }'
                        x-init="alpine.watch('showOptions', value => { if (!value) showOptions = false; })">
                        <x-form_label>
                            Pronoun(s): (previous selection:
                            {{ str_replace(['[', ']', '"', '\\'], '', $client->pronouns) }})
                        </x-form_label>
                        <button
                            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                            type="button" @click="openPronouns = !openPronouns">
                            <span class="ml-0"
                                x-text="selectedPronouns.length > 0 ? selectedPronouns.join(', ') : 'Select Options:'"></span>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                            x-show="openPronouns" x-transition.scale.origin.top x-transition:enter.duration.300ms
                            x-transition:enter.ease-in-out x-transition:leave.duration.300ms x-transition:ease-in-out
                            x-cloak>
                            {{-- <div class="select-input-div">
                                <input class="select-input" id="they/them/theirs" name="pronouns[]" type="checkbox"
                                    value="They/Them/Theirs">
                                <label class="ml-2" for="they-them">They/Them/Theirs</label>
                            </div>
                            <div class="select-input-div">
                                <input class="select-input" id="she/her/hers" name="pronouns[]" type="checkbox"
                                    value="she/her/hers">
                                <label class="ml-2" for="she-her">she/her/hers</label>
                            </div>
                            <div class="select-input-div">
                                <input class="select-input" id="per/per/pers" name="pronouns[]" type="checkbox"
                                    value="per/per/pers">
                                <label class="ml-2">per/per/pers</label>
                            </div>
                            <div class="select-input-div">
                                <input class="select-input" id="he/him/his" name="pronouns[]" type="checkbox"
                                    value="he/him/his">
                                <label class="ml-2" for="he-him">he/him/his</label>
                            </div>

                            <div class="select-input-div">
                                <input class="select-input" id="ze/hir/hirs" name="pronouns[]" type="checkbox"
                                    value="ze/hir/hirs">
                                <label class="ml-2" for="her">ze/hir/hirs</label>
                            </div>

                            <div class="select-input-div">
                                <input class="select-input" id="prefer-not-to-say-pronouns" name="pronouns[]"
                                    type="checkbox" value="Prefer Not To Say">
                                <label class="ml-2" for="prefer-not-to-say-pronouns">Prefer Not To Say</label>
                            </div>
                            <div class="select-input-div">
                                <input class="select-input" id="otherPronounCheckbox" name="pronouns[]"
                                    type="checkbox" value="Other">
                                <label class="ml-2" for="otherPronoun">Other</label>
                            </div> --}}
                            @foreach ($pronouns as $pronoun)
                                <div class="select-input-div">
                                    <input class="select-input" id="{{ $pronoun }}" name="pronouns[]"
                                        type="checkbox" value="{{ $pronoun }}"
                                        @if (in_array($pronoun, $selectedPronouns ?? [])) checked @endif
                                        @click="toggleSelectedPronoun('{{ $pronoun }}')">
                                    <label class="ml-2" for="{{ $pronoun }}">{{ $pronoun }}</label>
                                </div>
                            @endforeach


                            <div class="m-3 flex flex-row">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherPronounInput" name="pronouns[]" type="checkbox" value="Other"
                                    :checked="selectedPronouns.includes('Other')"
                                    @click="toggleSelectedPronoun('Other')">
                                <label class="ml-2" for="otherPronoun">Other</label>
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue
                                    -500"
                                    id="otherPronounInput" name="otherPronoun" type="text"
                                    style="display: none;">
                                <label class="ml-2" for="otherPronoun">Other</label>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="relative mb-4 mt-6 w-full"
                    x-data='{
                        showSexualOrientation: false,
                        selectedSexualOrientation: @json($client->sexual_orientation ?? []),
                        otherSexualOrientation: @json(str_contains($client->sexual_orientation ?? '', 'Other') ? 'Other' : ''),

                        toggleSelectedSexualOrientation(option) {
                            if (option === "Other") {
                                this.toggleOtherSexualOrientationCheckbox();
                            } else {
                                if (this.selectedSexualOrientation.includes(option)) {
                                    this.selectedSexualOrientation = this.selectedSexualOrientation.filter(item => item !== option);
                                } else {
                                    this.selectedSexualOrientation.push(option);
                                }
                            }
                        },

                        toggleOtherSexualOrientationCheckbox() {
                            if (this.selectedSexualOrientation.includes("Other")) {
                                this.selectedSexualOrientation = this.selectedSexualOrientation.filter(item => item !== "Other");
                                this.otherSexualOrientation = "";
                            } else {
                                this.selectedSexualOrientation.push("Other");
                                this.otherSexualOrientation = "Other";
                            }
                        }
                    }'>
                    <x-form_label>
                        Sexual Orientation(s): (previous selection:
                        {{ str_replace(['[', ']', '"', '\\'], '', $client->sexual_orientation) }})
                    </x-form_label>
                    <div class="rounded-md" @click.away="showSexualOrientation = false">
                        <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3">
                            <button class="-m-0.5 flex w-full justify-between text-gray-700" type="button"
                                @click="showSexualOrientation = !showSexualOrientation">
                                <span class="ml-0"
                                    x-text="selectedSexualOrientation.length > 0 ? selectedSexualOrientation.join(', ') : 'Select Options'"></span>
                                <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="-mt-1 w-full rounded-b-md rounded-t-none border-b border-l border-r border-blue-300 bg-gray-100 pt-1 text-gray-600 md:flex md:flex-wrap"
                            x-show="showSexualOrientation" x-transition.scale.origin.top x-transition.duration.300ms
                            x-transition.ease-in-out x-cloak>
                            @foreach ($sexualOrientations as $orientation)
                                <div class="m-3 flex flex-row">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        id="{{ $orientation }}" name="sexual_orientation[]" type="checkbox"
                                        value="{{ $orientation }}"
                                        :checked="selectedSexualOrientation.includes('{{ $orientation }}')"
                                        @click="toggleSelectedSexualOrientation('{{ $orientation }}')">
                                    <label class="" for="{{ $orientation }}">{{ $orientation }}</label>
                                </div>
                            @endforeach

                            <div class="select-input-div" x-data="{
                                otherSexualOrientation: '',
                                showOtherSexualOrientationInput: false,
                                toggleOtherSexualOrientationCheckbox() {
                                    this.showOtherSexualOrientationInput = !this.showOtherSexualOrientationInput;
                                }
                            }">
                                <input class="select-input" id="otherSexualOrientationCheckbox" type="checkbox"
                                    value="Other" x-on:click="toggleOtherSexualOrientationCheckbox()"
                                    :checked="selectedSexualOrientation.includes('Other')">
                                <label class="ml-2" for="otherSexualOrientationCheckbox">Other</label>

                                <div class="m-3 flex flex-row">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        id="otherSexualOrientationInput" name="sexual_orientation[]" type="text"
                                        x-model="otherSexualOrientation" x-show="showOtherSexualOrientationInput">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="my-4 flex flex-col" x-data="{ openEthnicGroup: false, selectedEthnicGroups: [] }">
                    <x-form_label>
                        Ethnic Group(s): (previous selection:
                        {{ str_replace(['[', ']', '"'], '', $client->ethnic_group) }})
                    </x-form_label>
                    <button
                        class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                        type="button" @click="openEthnicGroup = !openEthnicGroup">
                        <span class="ml-0"
                            x-text="selectedEthnicGroups.length > 0 ? selectedEthnicGroups.join(', ') : 'Select Options'"></span>
                        <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                        x-show="openEthnicGroup" x-transition.scale.origin.top x-transition:enter.duration.300ms
                        x-transition:enter.ease-in-out x-transition:leave.duration.300ms x-transition:ease-in-out
                        x-cloak>
                        @foreach ($ethnicGroups as $group)
                            <div class="select-input-div">
                                <input class="select-input" id="{{ $group }}" name="ethnic_group[]"
                                    type="checkbox" value="{{ $group }}"
                                    @if (in_array($group, $selectedEthnicGroups ?? [])) checked @endif
                                    @click="toggleSelectedEthnicGroup('{{ $group }}')">
                                <label class="ml-2" for="{{ $group }}">{{ $group }}</label>
                            </div>
                        @endforeach


                        <div x-data="{ showOtherEthnicGroupInput: false, otherEthnicGroupInput: '' }">
                            <div class="select-input-div">
                                <input class="select-input" id="otherEthnicGroupCheckbox" type="checkbox"
                                    value="Other" x-model="selectedEthnicGroups"
                                    @click="showOtherEthnicGroupInput = !showOtherEthnicGroupInput">
                                <label class="ml-2" for="otherEthnicGroup">Other</label>
                            </div>

                            <div class="m-3 flex flex-row">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherEthnicGroupInput" name="ethnic_group[]" type="text"
                                    x-model="otherEthnicGroupInput" x-show="showOtherEthnicGroupInput">
                            </div>
                        </div>


                    </div>
                </div>

                <div class="relative mb-4 mt-6 w-full">
                    <x-form_label for="home_address_state">
                        State: (previous selection: {{ $client->home_address_state }})
                    </x-form_label>
                    <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 ring-0"
                        id="home_address_state" name="home_address_state">
                        <option value="" disabled selected hidden>Previous: {{ $client->home_address_state }}
                        </option>
                        @foreach ($states as $state)
                            <option value="{{ $state }}" @if ($state == $client->home_address_state) selected @endif>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="relative mb-4 mt-6 w-full">
                    <x-form_label for="home_address_country">
                        Country: (previous selection: {{ $client->home_address_country }})
                    </x-form_label>
                    <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 ring-0" id=""
                        name="">
                        <option value="" disabled selected hidden>Previous: {{ $client->home_address_country }}
                        </option>
                        @foreach ($clientCountries as $country)
                            <option value="{{ $country }}" @if ($country == $client->home_address_country) selected @endif>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- previous therapy --}}
            {{-- <div class="col-span-6 my-4 sm:col-span-4">
                <x-jet-label for="Previous Therapy from Pineapple"
                    value="Previous Therapy from Pineapple:  previous: {{ $client->previous_therapy == 0 ? 'No' : 'Yes' }}" />
                <input class="rounded" id="previous_therapy" type="checkbox"
                    wire:model.defer="state.previous_therapy" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="previous_therapy" />
            </div> --}}
            <div class="mb-2 mt-4 w-full">
                <x-form_label for="previous_therapy">
                    Previous Therapy
                </x-form_label>

                <div class="flex items-center mt-2">
                    <input type="radio" id="previous_therapy_no" name="previous_therapy" value="0"
                        {{ old('previous_therapy', $client->previous_therapy) == '0' ? 'checked' : '' }}>
                    <label for="previous_therapy_no" class="ml-2">No</label>

                    <input type="radio" id="previous_therapy_yes" name="previous_therapy" value="1"
                        {{ old('previous_therapy', $client->previous_therapy) == '1' ? 'checked' : '' }}>
                    <label for="previous_therapy_yes" class="ml-2">Yes</label>
                </div>

                <x-jet-input-error class="mt-2" for="previous_therapy" />
            </div>

            {{-- Possible Support Needed --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <div class="relative mb-4 mt-6 w-full" x-data="{ showDropdown: false, selectedPossibleSupportNeeded: [] }">
                    <x-form_label>
                        Possible Support Needed: (previous selection:
                        {{ str_replace(['[', ']', '"', '\\'], '', $client->possible_support_needed) }})
                    </x-form_label>
                    <div class="rounded-md" @click.away="showDropdown = false">
                        <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-1.5">
                            <button class="flex w-full flex-row justify-between" type="button"
                                @click="showDropdown = !showDropdown">
                                <p class="ml-1 p-1">Select Options</p>
                                <svg class="mt-1 h-[18px] w-[18px] text-gray-700" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="rounded-md bg-gray-50 md:flex md:flex-wrap" x-show="showDropdown"
                            x-transition.scale.origin.top x-cloak>
                            <div class="items-center p-2 flex flex-wrap">
                                @foreach ($categories as $category)
                                    <div class="m-2 mr-0.5 mt-1 rounded-full p-2">
                                        <input
                                            class="m-2 mr-0.5 mt-1 rounded-full p-2 transition duration-200 ease-in-out hover:cursor-pointer hover:bg-blue-400"
                                            name="possible_support_needed[]" type="checkbox"
                                            value="{{ $category }}"
                                            @if (in_array($category, $selectedPossibleSupportNeeded ?? [])) checked @endif
                                            @click="toggleSelectedPossibleSupportNeeded('{{ $category }}')">
                                        <label class=""
                                            for="possible_support_needed">{{ $category }}</label>
                                    </div>
                                @endforeach

                                <div class="select-input-div m-2 mr-0.5 mt-0.5 rounded-full p-2 ">
                                    <input
                                        class="m-2 mr-0.5 mt-1 rounded-full p-2 transition duration-200 ease-in-out hover:cursor-pointer hover:bg-blue-400"
                                        id="otherPossibleSupportCheckbox" name="possible_support_needed[]"
                                        type="checkbox" value="Other">
                                    <label class="mb-0.5 ml-0.5" for="otherPossibleSupport">Other</label>
                                </div>

                                <div class="m-3 flex flex-row">
                                    <input class="mr-0.5 mt-1 rounded-full " id="otherPossibleSupportInput"
                                        name="otherPossibleSupport" type="text" style="display: none;">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-jet-label for="client_contribution" class="w-full"
                    value="Client Contribution:  previous: {{ $client->client_contribution }}" />
                <x-jet-input class="rounded-md w-full mt-2 bg-gray-100" id="client_contribution" type="number"
                    value="{{ $client->client_contribution }}" name="client_contribution" min="0"
                    step="1.00" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="client_contribution" />
            </div>

            <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="therapist" value="Therapist:  previous: {{ $therapist->name }}" />
                <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 capitalize ring-0"
                    id="user_id" name="user_id">
                    <option value="" disabled selected hidden>Previous: {{ $therapist->name }}</option>

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

            {{-- Status --}}
            <div class="mb-2 mt-4 w-full">
                <x-form_label for="status">
                    Status
                </x-form_label>

                <div class="flex items-center mt-2">
                    <input type="radio" id="status_active" name="status" value="0"
                        {{ old('status', $client->status) == '0' ? 'checked' : '' }}>
                    <label for="status_active" class="ml-2">Active</label>

                    <input type="radio" id="status_inactive" name="status" value="1"
                        {{ old('status', $client->status) == '1' ? 'checked' : '' }}>
                    <label for="status_inactive" class="ml-2">Inactive</label>
                </div>

                <x-jet-input-error class="mt-2" for="status" />
            </div>

            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="notes" value="{{ __('Notes') }}" />
                <textarea class="w-full rounded border border-blue-200 bg-gray-100" id="notes" cols="30" width: 100%;"
                    placeholder="Enter notes here..." autocomplete="off" name="additional_notes" rows="5"
                    value="{{ old('notes', $client->notes) }}">{{ $client->additional_notes }}</textarea>
                <x-jet-input-error class="mt-2" for="notes" />
            </div>
            <x-jet-button class="ml-4" type="submit">
                {{ __('Update') }}
            </x-jet-button>

        </form>
        <div x-data="{ open: false }" class="form">
            <div class="mt-4">
                <x-jet-button class="ml-4 bg-red-500 hover:bg-red-700" @click="open = true">
                    {{ __('Delete') }}
                </x-jet-button>
            </div>

            <div class="fixed z-10 inset-0 overflow-y-auto" x-show="open" x-cloak>
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="open = false">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <div class="flex flex-row justify-between items-center">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                            Are you sure?
                                        </h3>
                                        <button type="button"
                                            class="mt-3  inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm w-fit"
                                            @click="open = false">
                                            Cancel
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Do you really want to delete this client? This action cannot be undone.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('clients.delete', $client->id) }}" method="POST"
                            class="mx-auto w-1/2 flex my-4">
                            @csrf
                            @method('DELETE')
                            <x-jet-button class="mx-auto bg-red-500 hover:bg-red-700" type="submit">
                                {{ __('Delete') }}
                            </x-jet-button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </x-main-container>
</x-app-layout>

<script src="{{ asset('js/intlTelInput.js') }}"></script>
<script src="{{ asset('js/utils.js') }}"></script>

<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
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

<script>
    document.getElementById('otherGenderCheckbox').addEventListener('change', function() {
        var otherGenderInput = document.getElementById('otherGenderInput');
        if (this.checked) {
            otherGenderInput.style.display = 'block';
        } else {
            otherGenderInput.style.display = 'none';
        }
    });

    document.getElementById('otherPronounCheckbox').addEventListener('change', function() {
        var otherPronounInput = document.getElementById('otherPronounInput');
        if (this.checked) {
            otherPronounInput.style.display = 'block';
        } else {
            otherPronounInput.style.display = 'none';
        }
    });

    document.getElementById('otherSexualOrientationCheckbox').addEventListener('change', function() {
        var otherSexualOrientationInput = document.getElementById('otherSexualOrientationInput');
        if (this.checked) {
            otherSexualOrientationInput.style.display = 'block';
        } else {
            otherSexualOrientationInput.style.display = 'none';
        }
    });

    // document.getElementById('otherEthnicGroupCheckbox').addEventListener('change', function() {
    //     console.log('works')
    //     var otherEthnicGroupInput = document.getElementById('otherEthnicGroupInput');
    //     if (this.checked) {
    //         otherEthnicGroupInput.style.display = 'block';
    //     } else {
    //         otherEthnicGroupInput.style.display = 'none';
    //     }
    // });

    document.getElementById('otherPossibleSupportCheckbox').addEventListener('change', function() {
        var otherPossibleSupportInput = document.getElementById('otherPossibleSupportInput');
        if (this.checked) {
            otherPossibleSupportInput.style.display = 'block';
        } else {
            otherPossibleSupportInput.style.display = 'none';
        }
    });
</script>


{{-- <script>
    window.showOtherEthnicGroupInput = {{ in_array('Other', $selectedEthnicGroups) ? 'true' : 'false' }};
</script> --}}

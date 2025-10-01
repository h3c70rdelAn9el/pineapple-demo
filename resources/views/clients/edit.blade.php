@php
    // TODO:  IS THIS OKAY?
    // $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));
    // $timeZones = json_decode($timeZonesJson, true);
    // $statesJson = file_get_contents(resource_path('json/states.json'));
    // $states = json_decode($statesJson, true);
    $countriesJson = file_get_contents(resource_path('json/countries.json'));
    $clientCountries = json_decode($countriesJson, true);
    $sexualOrientations = ['Heterosexual/Straight', 'Gay/Lesbian', 'Bisexual', 'Don\\\'t Know', 'Prefer Not to Say', 'Queer', 'Pansexual'];
    $pronouns = ['He/Him/His', 'She/Her/Hers', 'They/Them/Theirs', 'Per/Per/Pers', 'Ze/Hir/Hirs', 'Prefer Not to Say'];
    $contactMethods = ['Telephone Call', 'Text Message', 'Email'];
    $ethnicGroups = ['American Indian or Alaska Native', 'Asian', 'Black or African American', 'Hispanic or Latino', 'Native Hawaiian or Other Pacific Islander', 'White', 'Prefer Not to Say'];
    $selectedContactMethods = $client->contact_method ? array_map('trim', explode(',', $client->contact_method)) : [];
    $selectedGenders = $client->gender ? array_map('trim', explode(',', $client->gender)) : [];
    $selectedGenders = array_map('strtolower', $selectedGenders);
    $selectedEthnicGroups = $client->ethnic_group ? array_map('trim', explode(',', $client->ethnic_group)) : [];
    $selectedPossibleSupportNeeded = $client->possible_support_needed ? array_map('trim', explode(',', $client->possible_support_needed)) : [];
    $selectedPronouns = $client->pronouns ? array_map('trim', explode(',', $client->pronouns)) : [];

    $selectedSexualOrientation = $client->sexual_orientation ? array_map('trim', explode(',', $client->sexual_orientation)) : [];
    $selectedSexualOrientation = array_map('strtolower', $selectedSexualOrientation);
    $selectedOptions = $client->options ? json_decode($client->options) : [];

@endphp


<x-app-layout>
    <x-main-container x-data="{
        submitForm() {
            document.getElementById('client-edit-form').submit();
        }
    }">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="mt-2 text-lg font-normal text-center">Edit client: {{ $client->preferred_name }}</h2>
        <div class="w-1/2 mx-auto bg-gray-400 border-b border-gray-400">
        </div>
        <form class="form" action="{{ route('clients.update', $client->id) }}" method="POST" id="client-edit-form"
            @submit.prevent="submitForm">
            @csrf
            @method('POST')

            {{-- <input name="_method" type="hidden" value="POST"> --}}

            <input name="user_id" type="hidden" value="{{ $client->user_id }}">

            <div class="w-full mt-4 mb-2">
                <x-jet-label for="client_code" value="{{ __('Client Code') }}" />
                <input class="w-full bg-gray-100 border border-blue-200 rounded" id="client_code" name="client_code"
                    type="text" value="{{ old('client_code', $client->client_code) }}"
                    placeholder="{{ old('client_code', $client->client_code) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="client_code" />
            </div>

            <div class="w-full mt-4 mb-2">
                <x-jet-label for="preferred_name" value="{{ __('Preferred Name') }}" />
                <input class="w-full bg-gray-100 border border-blue-200 rounded" id="preferred_name"
                    name="preferred_name" type="text" value="{{ old('preferred_name', $client->preferred_name) }}"
                    placeholder="{{ old('preferred_name', $client->preferred_name) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="preferred_name" />
            </div>

            {{-- max_sessions --}}
            <label for="max_sessions">Maximum Therapy Sessions:</label>
            <input class="w-16 p-1 mx-2 text-center bg-gray-100 border-blue-200 rounded-md ring-0" id="max_sessions"
                name="max_sessions" type="number" value="{{ $client->max_sessions }}">

            <div class="flex flex-row mt-4">
                <label for="special_sessions">Special Sessions:</label>
                <input type="radio" name="special_sessions" id="special_sessions_yes" value="1"
                    {{ $client->special_sessions == 1 ? 'checked' : '' }}>
                <label for="special_sessions_yes">Yes</label>
                <input type="radio" name="special_sessions" id="special_sessions_no" value="0"
                    {{ $client->special_sessions == 0 ? 'checked' : '' }}>
                <label for="special_sessions_no">No</label>
                <x-jet-input-error class="mt-2" for="special_sessions" />
            </div>

            {{-- legal_name --}}
            <div class="w-full mt-4 mb-2">
                <x-jet-label for="legal_name" value="{{ __('Legal Name') }}" />
                <input class="w-full bg-gray-100 border border-blue-200 rounded" id="legal_name" name="legal_name"
                    type="text" value="{{ old('legal_name', $client->legal_name) }}" {{-- value="{{ $client->legal_name }}" --}}
                    placeholder="{{ old('legal_name', $client->legal_name) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="legal_name" />
            </div>

            <div class="w-full mt-4 mb-2">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <input class="w-full bg-gray-100 border border-blue-200 rounded" id="email" name="email"
                    type="text" value="{{ old('email', $client->email) }}"
                    placeholder="{{ old('email', $client->email) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="email" />
            </div>

            <div class="w-full mt-4 mb-2">
                <x-jet-label for="phone" value="{{ __('Phone') }}" />
                <input class="w-full bg-gray-100 border border-blue-200 rounded" id="phone" name="phone"
                    type="text" value="{{ old('phone', $client->phone) }}"
                    placeholder="{{ old('phone', $client->phone) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="phone" />
            </div>

            <div class="w-full mt-4 mb-2">
                <x-jet-label for="category" value="{{ __('Category') }}" />
                <select class="w-full bg-gray-100 border border-blue-200 rounded" id="category" name="category">
                    @foreach (App\Models\Client::$categories as $category)
                        <option value="{{ $category }}" {{ old('category', $client->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <x-jet-input-error class="mt-2" for="category" />
            </div>

            {{-- has_been_contacted --}}
            <div class="w-full mt-4 mb-2">
                <div class="flex items-center">
                    <input class="mr-2 rounded" id="has_been_contacted" name="has_been_contacted" type="checkbox" 
                           value="1" {{ old('has_been_contacted', $client->has_been_contacted) ? 'checked' : '' }}>
                    <x-jet-label for="has_been_contacted" value="{{ __('Client has been contacted') }}" />
                </div>
                <x-jet-input-error class="mt-2" for="has_been_contacted" />
            </div>

            <div class="relative w-full mt-6 mb-4"
                x-data='{
                    showContactMethods: false,
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
                    {{-- str_replace(['[', ']', '"'], '', $client->contact_method) --}})
                    {{ $client->contact_method }}
                </x-form_label>
                <div class="rounded-md" @click.away="showContactMethods = false">
                    <div class="flex justify-between w-full p-3 bg-gray-100 border border-blue-300 rounded-md">
                        <button class="-m-0.5 flex w-full justify-between text-gray-700" type="button"
                            @click="showContactMethods = !showContactMethods">
                            Select Options:
                            <span class="ml-0"
                                x-text="selectedContactMethods.length > 0 ? selectedContactMethods.join(', ') : ''">
                            </span>
                            <p></p>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="w-full pt-1 -mt-1 text-gray-600 bg-gray-100 border-b border-l border-r border-blue-300 rounded-t-none rounded-b-md md:flex md:flex-wrap"
                        x-show="showContactMethods" x-transition.scale.origin.top x-transition.duration.300ms
                        x-transition.ease-in-out x-cloak>
                        @foreach ($contactMethods as $method)
                            <div class="select-input-div">
                                <input class="select-input" id="{{ $method }}" name="contact_method[]"
                                    type="checkbox" value="{{ $method }}"
                                    @if (in_array($method, $selectedContactMethods)) checked @endif
                                    @click="toggleSelectedContactMethod('{{ $method }}')">
                                <label class="ml-2" for="{{ $method }}">{{ $method }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>



            <div class="p-2 my-4 bg-blue-100 border-2 border-blue-300 rounded-lg">
                <p>Optional Fields</p>

                <div class="relative w-full mt-6 mb-4"
                    x-data='{
                        showGender: false,
                        selectedOptions: [],
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
                        Gender(s): (previous selection: {{ $client->gender }})
                    </x-form_label>
                    <div class="rounded-md" @click.away="showGender = false">
                        <div class="flex justify-between w-full p-3 bg-gray-100 border border-blue-300 rounded-md">
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
                        <div class="w-full pt-1 -mt-1 text-gray-600 bg-gray-100 border-b border-l border-r border-blue-300 rounded-t-none rounded-b-md md:flex md:flex-wrap"
                            x-show="showGender" x-transition.scale.origin.top x-transition.duration.300ms
                            x-transition.ease-in-out x-cloak>

                            @foreach ($genders as $gender)
                                <div class="flex flex-row m-3">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        name="gender[]" type="checkbox" value="{{ $gender }}"
                                        @if (in_array(strtolower($gender), $selectedGenders)) checked @endif
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

                            <div class="flex flex-row m-3">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherGenderInput" name="gender[]" type="text" style="display: none;"
                                    x-model="otherGender" x-show="showOtherInput">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-6 mt-0 sm:col-span-4">
                    <div class="flex flex-col my-4"
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

                            @foreach ($pronouns as $pronoun)
                                <div class="select-input-div">
                                    <input class="select-input" id="{{ $pronoun }}" name="pronouns[]"
                                        type="checkbox" value="{{ $pronoun }}"
                                        @if (in_array($pronoun, $selectedPronouns ?? [])) checked @endif
                                        @click="toggleSelectedPronoun('{{ $pronoun }}')">
                                    <label class="ml-2" for="{{ $pronoun }}">{{ $pronoun }}</label>
                                </div>
                            @endforeach


                            <div class="flex flex-row m-3" x-data="{ otherPronoun: '', showOtherPronounInput: false }">

                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherPronounCheckbox" type="checkbox" value="Other"
                                    :checked="selectedPronouns.includes('Other')"
                                    x-on:click="showOtherPronounInput = !showOtherPronounInput; otherPronoun = ''">

                                <label class="ml-2" for="otherPronounCheckbox">Other</label>

                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherPronounInput" name="pronouns[]" type="text" x-model="otherPronoun"
                                    x-show="showOtherPronounInput">

                            </div>

                        </div>
                    </div>
                </div>



                <div class="relative w-full mt-6 mb-4"
                    x-data='{
                        showSexualOrientation: false,
                        selectedSexualOrientation: [],
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
                        <div class="flex justify-between w-full p-3 bg-gray-100 border border-blue-300 rounded-md">
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
                        <div class="w-full pt-1 -mt-1 text-gray-600 bg-gray-100 border-b border-l border-r border-blue-300 rounded-t-none rounded-b-md md:flex md:flex-wrap"
                            x-show="showSexualOrientation" x-transition.scale.origin.top x-transition.duration.300ms
                            x-transition.ease-in-out x-cloak>
                            @foreach ($sexualOrientations as $orientation)
                                <div class="flex flex-row m-3">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        id="{{ $orientation }}" name="sexual_orientation[]" type="checkbox"
                                        value="{{ $orientation }}" @if (in_array(strtolower($orientation), $selectedSexualOrientation ?? [])) checked @endif
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

                                <div class="flex flex-row m-3">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        id="otherSexualOrientationInput" name="sexual_orientation[]" type="text"
                                        x-model="otherSexualOrientation" x-show="showOtherSexualOrientationInput">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="flex flex-col my-4" x-data="{ openEthnicGroup: false, selectedEthnicGroups: [] }">
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

                            <div class="flex flex-row m-3">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherEthnicGroupInput" name="ethnic_group[]" type="text"
                                    x-model="otherEthnicGroupInput" x-show="showOtherEthnicGroupInput">
                            </div>
                        </div>


                    </div>
                </div>

                <div class="relative w-full mt-6 mb-4">
                    <x-form_label for="home_address_state">
                        State: (previous selection: {{ $client->home_address_state }})
                    </x-form_label>
                    <select class="w-full p-2 mt-2 bg-gray-100 border-blue-200 rounded-md peer ring-0"
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

                <div class="relative w-full mt-6 mb-4">
                    <x-form_label for="home_address_country">
                        Country: (previous selection: {{ $client->home_address_country }})
                    </x-form_label>
                    <select class="w-full p-2 mt-2 bg-gray-100 border-blue-200 rounded-md peer ring-0" id=""
                        name="home_address_country">
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
            <div class="w-full mt-4 mb-2">
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
                <div class="relative w-full mt-6 mb-4" x-data="{ showDropdown: false, selectedPossibleSupportNeeded: [] }">
                    <x-form_label>
                        Possible Support Needed: (previous selection:
                        {{ str_replace(['[', ']', '"', '\\'], '', $client->possible_support_needed) }})
                    </x-form_label>
                    <div class="rounded-md" @click.away="showDropdown = false">
                        <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-1.5">
                            <button class="flex flex-row justify-between w-full" type="button"
                                @click="showDropdown = !showDropdown">
                                <p class="p-1 ml-1">Select Options</p>
                                <svg class="mt-1 h-[18px] w-[18px] text-gray-700" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="rounded-md bg-gray-50 md:flex md:flex-wrap" x-show="showDropdown"
                            x-transition.scale.origin.top x-cloak>
                            
                            <div class="flex flex-wrap items-center p-2">
                                @foreach ($support_types as $st)
                                    <div class="m-2 mr-0.5 mt-1 rounded-full p-2">
                                        <input
                                            class="m-2 mr-0.5 mt-1 rounded-full p-2 transition duration-200 ease-in-out hover:cursor-pointer hover:bg-blue-400"
                                            name="possible_support_needed[]" type="checkbox"
                                            value="{{ $st }}"
                                            @if (in_array($st, $selectedPossibleSupportNeeded ?? [])) checked @endif
                                            @click="toggleSelectedPossibleSupportNeeded('{{ $st }}')">
                                        <label class=""
                                            for="possible_support_needed">{{ $st }}</label>
                                    </div>
                                @endforeach

                                <div class="select-input-div m-2 mr-0.5 mt-0.5 rounded-full p-2 ">
                                    <input
                                        class="m-2 mr-0.5 mt-1 rounded-full p-2 transition duration-200 ease-in-out hover:cursor-pointer hover:bg-blue-400"
                                        id="otherPossibleSupportCheckbox" name="possible_support_needed[]"
                                        type="checkbox" value="Other">
                                    <label class="mb-0.5 ml-0.5" for="otherPossibleSupport">Other</label>
                                </div>

                                <div class="flex flex-row m-3">
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
                <x-jet-input class="w-full mt-2 bg-gray-100 rounded-md" id="client_contribution" type="number"
                    value="{{ $client->client_contribution }}" name="client_contribution" min="0"
                    step="1.00" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="client_contribution" />
            </div>

            {{-- Cost Per Session field - only show if client has a category --}}
            @if($client->category)
            <div class="col-span-6 mt-0 sm:col-span-4" id="cost_per_session_field_edit">
                <x-jet-label for="cost_per_session" class="w-full"
                    value="Cost Per Session Override:  previous: {{ $client->cost_per_session ?? 'Using therapist default' }}" />
                <x-jet-input class="w-full mt-2 bg-gray-100 rounded-md" id="cost_per_session" type="number"
                    value="{{ $client->cost_per_session }}" name="cost_per_session" min="0"
                    step="1.00" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="cost_per_session" />
                <p class="text-sm text-gray-600 mt-1">Leave blank to use the therapist's default cost per session</p>
            </div>
            @endif

            <div class="col-span-6 mt-4 sm:col-span-4">
                <x-jet-label for="therapist" value="Therapist:  previous: {{ $therapist->name }}" />
                <select class="w-full p-2 mt-2 capitalize bg-gray-100 border-blue-200 rounded-md peer ring-0"
                    id="user_id" name="user_id">
                    <option value="" disabled selected hidden>Previous: {{ $therapist->name }}</option>
                    <option value="no_therapist">No Therapist Assigned</option>

                    @php
                        $groupedTherapists = $therapists->groupBy('state')->sortKeys();
                    @endphp

                    @foreach ($groupedTherapists as $state => $therapistsInState)

                        @php
                            $activeTherapistsInState = $therapistsInState->filter(function ($therapist) {
                                //return $therapist->active_status == 0;
                                return true;
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
            <div class="w-full mt-4 mb-2">
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

            <div class="mt-4">
                <x-jet-label for="waitlist" value="{{ __('Waitlist') }}" />
                <div class="flex items-center mt-2">
                    <label for="waitlist_yes" class="mr-4">
                        <input id="waitlist_yes" type="radio" name="waitlist" value="1"
                            {{ $client->waitlist == 1 ? 'checked' : '' }} autofocus />
                        <span class="ml-2 text-sm text-gray-600">Yes</span>
                    </label>

                    <label for="waitlist_no">
                        <input id="waitlist_no" type="radio" name="waitlist" value="0"
                            {{ $client->waitlist == 0 ? 'checked' : '' }} />
                        <span class="ml-2 text-sm text-gray-600">No</span>
                    </label>
                </div>
                <x-jet-input-error for="waitlist" class="mt-2" />
            </div>

            <div class="w-full mt-4 mb-2">
                <x-jet-label for="notes" value="{{ __('Notes') }}" />
                <textarea class="w-full bg-gray-100 border border-blue-200 rounded" id="notes" cols="30" width: 100%;"
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

            <div class="fixed inset-0 z-10 overflow-y-auto" x-show="open" x-cloak>
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="open = false">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div
                        class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <div class="flex flex-row items-center justify-between">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                                            Are you sure?
                                        </h3>
                                        <button type="button"
                                            class="inline-flex justify-center px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm w-fit"
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
                            class="flex w-1/2 mx-auto my-4">
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
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Select a therapist",
            allowClear: true
        });
    });
</script>
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

    // Show/hide cost per session field when category is changed in edit form
    @if(!$client->category)
    document.getElementById('category').addEventListener('change', function() {
        var costPerSessionField = document.getElementById('cost_per_session_field_edit');
        if (!costPerSessionField) {
            // If field doesn't exist, we need to create it dynamically
            var clientContributionDiv = document.querySelector('input[name="client_contribution"]').closest('.col-span-6');
            if (this.value && this.value.trim() !== '') {
                var newFieldHtml = `
                    <div class="col-span-6 mt-0 sm:col-span-4" id="cost_per_session_field_edit">
                        <label for="cost_per_session" class="block text-sm font-medium text-gray-700">
                            Cost Per Session Override
                        </label>
                        <input class="w-full mt-2 bg-gray-100 rounded-md" id="cost_per_session" type="number"
                            name="cost_per_session" min="0" step="1.00" autocomplete="off" />
                        <p class="text-sm text-gray-600 mt-1">Leave blank to use the therapist's default cost per session</p>
                    </div>
                `;
                clientContributionDiv.insertAdjacentHTML('afterend', newFieldHtml);
            }
        } else {
            if (this.value && this.value.trim() !== '') {
                costPerSessionField.style.display = 'block';
            } else {
                costPerSessionField.style.display = 'none';
            }
        }
    });
    @endif
</script>


{{-- <script>
    window.showOtherEthnicGroupInput = {{ in_array('Other', $selectedEthnicGroups) ? 'true' : 'false' }};
</script> --}}

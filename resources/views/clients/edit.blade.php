@php
    // TODO:  IS THIS OKAY?
    // $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));
    // $timeZones = json_decode($timeZonesJson, true);
    // $statesJson = file_get_contents(resource_path('json/states.json'));
    // $states = json_decode($statesJson, true);
    $countriesJson = file_get_contents(resource_path('json/countries.json'));
    $clientCountries = json_decode($countriesJson, true);
    $sexualOrientations = ['Heterosexual/Straigh', 'Gay/Lesbian', 'Bisexual', 'Don\'t Know', 'Prefer Not to Say', 'Other'];
    $pronouns = ['He/Him/His', 'She/Her/Hers', 'They/Them/Theirs', 'Per/Per/Pers', 'Ze/Hir/Hirs', 'Prefer Not to Say', 'Other'];
    $contactMethods = ['Telephone Call', 'Text Message', 'Email'];
    $ethnicGroups = ['American Indian or Alaska Native', 'Asian', 'Black or African American', 'Hispanic or Latino', 'Native Hawaiian or Other Pacific Islander', 'White', 'Prefer Not to Say', 'Other'];
    $selectedEthnicGroups = $client->ethnic_group ? json_decode($client->ethnic_group) : [];
@endphp

<x-app-layout>
    <x-main-container>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
        <form class="mx-auto w-1/2" action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('POST')
            {{-- <input name="_method" type="hidden" value="POST"> --}}

            <input name="user_id" type="hidden" value="{{ $client->user_id }}">

            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="client_code" value="{{ __('Client Code') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100" id="client_code" name="client_code"
                    type="text" value="{{ old('client_code', $client->client_code) }}"
                    placeholder="{{ old('client_code', $client->client_code) }}" autocomplete="off" />
                    placeholder="{{ old('client_code', $client->client_code) }}" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="client_code" />
            </div>

            <div class="mb-2 mt-4 w-full">
                <x-jet-label for="preferred_name" value="{{ __('Preferred Name') }}" />
                <input class="w-full rounded border border-blue-200 bg-gray-100" id="preferred_name"
                    name="preferred_name" type="text" value="{{ old('preferred_name', $client->preferred_name) }}"
                    placeholder="{{ old('preferred_name', $client->preferred_name) }}" autocomplete="off" />
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
                            <span class="ml-0"
                                x-text="selectedContactMethods.length > 0 ? selectedContactMethods.join(', ') : 'Select Options'"></span>
                                x-text="selectedContactMethods.length > 0 ? selectedContactMethods.join(', ') : 'Select Options'"></span>
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
                        <div class="select-input-div" x-data="{ selectedContactMethods: @json($client->contact_method ?? []) }">
                            <input class="select-input" id="telephone-call" name="contact_method[]" type="checkbox"
                                value="Telephone Call">
                            <label class="ml-2" for="telephone-call">Telephone Call</label>
                        </div>
                        <div class="select-input-div">
                            <input class="select-input" id="otherContactMethodCheckbox" name="contact_method[]"
                                type="checkbox" value="Other" :checked="selectedContactMethods.includes('Other')"
                                @click="toggleSelectedContactMethod('Other')">
                            <label class="ml-2" for="otherContactMethod">Other</label>
                        </div>

                        <div class="m-3 flex flex-row">
                            <input
                                class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                id="otherContactMethodInput" name="otherContactMethod" type="text"
                                style="display: none;">
                        </div>
                    </div>
                </div>

            </div>



            <div class="my-4 rounded-lg border-2 border-blue-300 bg-blue-100 p-2">
                <p>Optional Fields</p>

                <div class="relative mb-4 mt-6 w-full"
                    x-data='{
                        showGender: false,
                        {{-- selectedOptions: [], --}}
                        selectedOptions: @json($client->gender ?? []),

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
                                        :checked="selectedOptions.includes('{{ $gender }}')"
                                        @click="toggleSelectedOption('{{ $gender }}')">
                                    <label class="" for="{{ $gender }}">{{ $gender }}</label>
                                </div>
                            @endforeach
                            <div class="select-input-div">
                                <input class="select-input" id="otherGenderCheckbox" name="gender[]" type="checkbox"
                                    value="Other" :checked="selectedOptions.includes('Other')"
                                    @click="toggleSelectedOption('Other')">
                                <label class="ml-2" for="otherGender">Other</label>
                            </div>

                            <div class="m-3 flex flex-row">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherGenderInput" name="otherGender" type="text" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-6 mt-0 sm:col-span-4">
                    <div class="my-4 flex flex-col"
                        x-data='
                        {
                            openPronouns: false,
                            selectedPronouns: @json($client->pronouns ?? []),
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
                            Pronoun(s): (previous selection: {{ str_replace(['[', ']', '"'], '', $client->pronouns) }})
                        </x-form_label>
                        <button
                            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                            type="button" @click="openPronouns = !openPronouns">
                            <span class="ml-0"
                                x-text="selectedPronouns.length > 0 ? selectedPronouns.join(', ') : 'Select Options'"></span>
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
                                        :checked="selectedPronouns.includes('{{ $pronoun }}')"
                                        @click="toggleSelectedPronouns('{{ $pronoun }}')">
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
                        toggleSelectedSexualOrientation(option) {
                            if (this.selectedSexualOrientation.includes(option)) {
                                this.selectedSexualOrientation = this.selectedSexualOrientation.filter(item => item !== option);
                            } else {
                                this.selectedSexualOrientation.push(option);
                            }
                        }
                    }'
                    x-init="alpine.watch('showOptions', value => { if (!value) showSexualOrientation = false; })">
                    <x-form_label>
                        Sexual Orientation(s): (previous selection:
                        {{ str_replace(['[', ']', '"'], '', $client->sexual_orientation) }})
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
                            <div class="select-input-div">
                                <input class="select-input" id="otherSexualOrientationCheckbox"
                                    name="sexual_orientation[]" type="checkbox" value="Other"
                                    :checked="selectedSexualOrientation.includes('Other')"
                                    @click="toggleSelectedSexualOrientation('Other')">
                                <label class="ml-2" for="otherSexualOrientation">Other</label>
                            </div>
                            <div class="m-3 flex flex-row">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherSexualOrientationInput" name="otherSexualOrientation" type="text"
                                    style="display: none;">
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-span-6 mt-0 sm:col-span-4">
                    <div class="my-4 flex flex-col" x-data="{ openSexualOrientation: false, selectedSexualOrientation: @json($client->sexual_orientation ?? []) }">
                        <x-form_label>
                            Sexual Orientation(s): (previous selection:
                            {{ str_replace(['[', ']', '"'], '', $client->sexual_orientation) }})
                        </x-form_label>
                        <button
                            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                            type="button" @click="openSexualOrientation = !openSexualOrientation">
                            <span class="ml-0"
                                x-text="selectedSexualOrientation.length > 0 ? selectedSexualOrientation.join(', ') : 'Select Options'"></span>
                            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                            x-show="openSexualOrientation" x-transition.scale.origin.top
                            x-transition:enter.duration.300ms x-transition:enter.ease-in-out
                            x-transition:leave.duration.300ms x-transition:ease-in-out x-cloak>
                            @foreach ($sexualOrientations as $orientation)
                                <div class="select-input-div">
                                    <input class="select-input" id="{{ $orientation }}" name="sexual_orientation[]"
                                        type="checkbox" value="{{ $orientation }}"
                                        :checked="selectedSexualOrientation.includes('{{ $orientation }}')"
                                        @click="toggleSelectedSexualOrientation('{{ $orientation }}')">
                                    <label class="ml-2" for="{{ $orientation }}">{{ $orientation }}</label>
                                </div>
                            @endforeach
                            <div class="select-input-div">
                                <input class="select-input" id="otherSexualOrientationCheckbox"
                                    name="sexual_orientation[]" type="checkbox" value="Other"
                                    :checked="selectedSexualOrientation.includes('Other')"
                                    @click="toggleSelectedSexualOrientation('Other')">
                                <label class="ml-2" for="otherSexualOrientation">Other</label>
                            </div>
                            <div class="m-3 flex flex-row">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherSexualOrientationInput" name="otherSexualOrientation" type="text"
                                    style="display: none;">
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


                                    @if (in_array($group, $selectedEthnicGroups)) checked @endif
                                    @click="toggleSelectedEthnicGroup('{{ $group }}')">
                                <label class="ml-2" for="{{ $group }}">{{ $group }}</label>
                            </div>
                        @endforeach
                        {{--
                        @php
                            $selectedEthnicGroups = json_decode($client->ethnic_group);

                            foreach ($ethnicGroups as $ethnicGroup) {
                                echo '<div class="select-input-div">';
                                echo '<input class="select-input" id="' .
                                    $ethnicGroup .
                                    '" name="ethnic_group[]" type="checkbox" value="' .
                                    $ethnicGroup .
                                    '" :checked="selectedEthnicGroups.includes(\'' .
                                    $ethnicGroup .
                                    '\')" @click="toggleSelectedEthnic
                                    Group(\'' .
                                    $ethnicGroup .
                                    '\')">';
                                echo '<label class="ml-2" for="' . $ethnicGroup . '">' . $ethnicGroup . '</label>';
                                echo '</div>';
                            }
                            echo '<div class="select-input-div">';
                            echo '<input class="select-input" id="otherEthnicGroupCheckbox" name="ethnic_group[]" type="checkbox" value="
                                Other" :checked="selectedEthnicGroups.includes(\'Other\')" @click="toggleSelectedEthnicGroup(\'Other\')">';
                            echo '<label class="ml-2" for="otherEthnicGroup">Other</label>';
                            echo '</div>';
                            echo '<div class="m-3 flex flex-row">';
                            echo '<input class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg
                                    -blue-500" id="otherEthnicGroupInput" name="otherEthnicGroup" type="text" style="display:
                                    none;">';
                            echo '</div>';

                        @endphp
--}}
                        <div class="select-input-div">
                            <input class="select-input" id="otherEthnicGroupCheckbox" name="ethnic_group[]"
                                type="checkbox" value="Other" :checked="selectedEthnicGroups.includes('Other')"
                                @click="toggleSelectedEthnicGroup('Other')">
                            <label class="ml-2" for="otherEthnicGroup">Other</label>
                        </div>

                        <div class="m-3 flex flex-row">
                            <input
                                class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                id="otherEthnicGroupInput" name="otherEthnicGroup" type="text"
                                style="display: none;">
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
                    <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 ring-0"
                        id="home_address_country" name="home_address_country">
                    <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 ring-0"
                        id="home_address_country" name="home_address_country">
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
                <div class="relative mb-4 mt-6 w-full" x-data="{ showDropdown: false }">
                    <x-form_label>
                        Possible Support Needed: (previous selection:
                        {{ str_replace(['[', ']', '"'], '', $client->possible_support_needed) }})
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
                                            @if (is_array(old('possible_support_needed')) && in_array($category, old('possible_support_needed'))) checked @endif>
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
                            {{-- @endforeach --}}
                            {{-- @foreach ($categories as $category)
                                <div class="m-3 flex flex-row">
                                    <input
                                        class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                        name="possible_support_needed[]"
                                        type="checkbox"
                                        value="{{ $category }}">
                                    <label class=""
                                        for="{{ $category }}">{{ $category }}</label>
                                </div>
                            @endforeach
                            <div class="select-input-div">
                                <input class="select-input"
                                    id="otherPossibleSupportCheckbox"
                                    name="possible_support_needed[]"
                                    type="checkbox"
                                    value="Other">
                                <label class="ml-2"
                                    for="otherPossibleSupport">Other</label>
                            </div>

                            <div class="m-3 flex flex-row">
                                <input
                                    class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                                    id="otherPossibleSupportInput"
                                    name="otherPossibleSupport"
                                    type="text"
                                    style="display: none;">
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-jet-label for="client_contribution"
                    value="Client Contribution:  previous: {{ $client->client_contribution }}" />
                <input class="rounded" id="client_contribution" type="number"
                    value="{{ $client->client_contribution }}" name="client_contribution" min="0"
                    step="1.00" autocomplete="off" />
                    value="{{ $client->client_contribution }}" name="client_contribution" min="0"
                    step="1.00" autocomplete="off" />
                <x-jet-input-error class="mt-2" for="client_contribution" />
            </div>

            <div class="col-span-6 mt-0 sm:col-span-4">
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
        <div x-data="{ open: false }">
            <div class="w-1/2 mt-2 mx-auto">
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

    document.getElementById('otherEthnicGroupCheckbox').addEventListener('change', function() {
        var otherEthnicGroupInput = document.getElementById('otherEthnicGroupInput');
        if (this.checked) {
            otherEthnicGroupInput.style.display = 'block';
        } else {
            otherEthnicGroupInput.style.display = 'none';
        }
    });

    document.getElementById('otherPossibleSupportCheckbox').addEventListener('change', function() {
        var otherPossibleSupportInput = document.getElementById('otherPossibleSupportInput');
        if (this.checked) {
            otherPossibleSupportInput.style.display = 'block';
        } else {
            otherPossibleSupportInput.style.display = 'none';
        }
    });
</script>

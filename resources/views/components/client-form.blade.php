{{-- ! commented code out are fields they wanted ommitted. I kept them in place incase someone decides to put them back --}}
{{-- give the merror message  --}}
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

<form class="z-50 mx-auto mb-4 mt-2 h-full w-5/6 rounded-md border border-blue-600 bg-blue-200 p-4 shadow-lg md:w-2/3"
    style="z-index: 99999;" action="{{ route('client.store') }}" method="POST">
    @csrf
    <x-form_label for="client_code">
        Client Code
    </x-form_label>
    <x-form_input id="client_code" name="client_code" type="text" required placeholder="Client code" />
    @if ($errors->has('client_code'))
        <span class="error">{{ $errors->first('client_code') }}</span>
    @endif

    {{-- Legal Name --}}
    <x-form_label for="legal_name">
        Legal Name
    </x-form_label>
    <x-form_input id="legal_name" name="legal_name" type="text" required placeholder="Legal name" />
    {{-- </x-form_input_div> --}}

    {{-- Preferred Name --}}
    <x-form_label for="preferred_name">
        Preferred Name
    </x-form_label>
    <x-form_input id="preferred_name" name="preferred_name" type="text" required placeholder="Preferred name" />

    {{-- Status --}}
    <x-form_label for="status">
        Status
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0" id="status" name="status"
        type="text">
        <option value="" disabled selected hidden>Select Status</option>
        <option value="0">Active</option>
        <option value="1">Inactive</option>
    </select>

    {{-- email --}}
    <x-form_label for="email">
        Email
    </x-form_label>
    <x-form_input id="email" name="email" type="text" required placeholder="email@example.com" />

    {{-- phone --}}
    <x-form_label for="phone">
        Phone
    </x-form_label>
    <x-form_input id="phone" name="phone" type="tel" required />

    {{-- contact_method --}}
    <div class="my-4 flex flex-col" x-data="{ openContact: false }">
        <x-jet-label>Contact Method:</x-jet-label>
        <button
            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3 text-gray-700 focus:border-blue-500"
            type="button" @click="openContact = !openContact">
            <span> (Select multiple if applicable)</span>
            <span class="ml-0"
                x-text="selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Select Options'"></span>
            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>

        </button>
        <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
            x-show="openContact" x-transition.scale.origin.top x-transition:enter.duration.300ms
            x-transition:enter.ease-in-out x-transition:leave.duration.300ms x-transition:ease-in-out x-cloak>
            <div class="select-input-div">
                <input class="select-input" id="telephone" name="contact_method[]" type="checkbox" value="telephone">
                <label class="ml-2" for="telephone">Telephone</label>
            </div>
            <div class="select-input-div">
                <input class="select-input" id="text" name="contact_method[]" type="checkbox" value="text">
                <label class="ml-2" for="text">Text</label>
            </div>
            <div class="select-input-div">
                <input class="select-input" id="email" name="contact_method[]" type="checkbox" value="email">
                <label class="ml-2" for="email">Email</label>
            </div>
        </div>
    </div>

    <div class="my-4 rounded-lg border-2 border-blue-300 bg-blue-100 p-2">
        <h3>Optional Fields</h3>
        {{-- Gender --}}
        <div class="my-4 flex flex-col" x-data="{ openGender: false }">
            <x-jet-label>Gender</x-jet-label>
            <button
                class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3 text-gray-700 focus:border-blue-500"
                type="button" @click="openGender = !openGender">
                <span> (Select multiple if applicable)</span>
                <span class="ml-0"
                    x-text="selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Select Options'"></span>
                <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>

            </button>
            <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                x-show="openGender" x-transition.scale.origin.top x-transition:enter.duration.300ms
                x-transition:enter.ease-in-out x-transition:leave.duration.300ms x-transition:ease-in-out x-cloak>
                <div class="select-input-div">
                    <input class="select-input" id="male" name="gender[]" type="checkbox" value="male">
                    <label class="ml-2" for="male">Male</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="female" name="gender[]" type="checkbox" value="female">
                    <label class="ml-2" for="female">Female</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="transgender" name="gender[]" type="checkbox"
                        value="transgender">
                    <label class="ml-2" for="transgender">Transgender</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="cisgender" name="gender[]" type="checkbox" value="cisgender">
                    <label class="ml-2" for="cisgender">Cisgender</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="bigender" name="gender[]" type="checkbox" value="bigender">
                    <label class="ml-2" for="bigender">Bigender</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="non-binary" name="gender[]" type="checkbox" value="non-binary">
                    <label class="ml-2" for="non-binary">Non-Binary</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="prefer-not-to-say" name="gender[]" type="checkbox"
                        value="prefer-not-to-say">
                    <label class="ml-2" for="prefer-not-to-say">Prefer Not To Say</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="otherGenderCheckbox" name="gender[]" type="checkbox"
                        value="Other">
                    <label class="ml-2" for="otherGender">Other</label>
                </div>

                <div class="m-3 flex flex-row">
                    <input class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                        id="otherGenderInput" name="otherGender" type="text" style="display: none;">
                </div>
            </div>
        </div>

        {{-- Pronouns --}}
        <div class="col-span-6 mt-0 sm:col-span-4">
            <div class="my-4 flex flex-col" x-data="{ openPronouns: false, selectedPronouns: [] }">
                <x-form_label>
                    Pronoun(s):
                </x-form_label>
                <button
                    class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                    type="button" @click="openPronouns = !openPronouns">
                    <span class="ml-0"
                        x-text="selectedPronouns.length > 0 ? selectedPronouns.join(', ') : 'Select Options'"></span>
                    <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                    x-show="openPronouns" x-transition.scale.origin.top x-transition:enter.duration.300ms
                    x-transition:enter.ease-in-out x-transition:leave.duration.300ms x-transition:ease-in-out x-cloak>
                    <div class="select-input-div">
                        <input class="select-input" id="they/them/theirs" name="pronouns[]" type="checkbox"
                            value="They/Them/Theirs">
                        <label class="ml-2" for="they-them">They/Them/Theirs</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input" id="she-her" name="pronouns[]" type="checkbox"
                            value="she/her/hers">
                        <label class="ml-2" for="she-her">she/her/hers</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input" id="him" name="pronouns[]" type="checkbox"
                            value="per/per/pers">
                        <label class="ml-2">per/per/pers</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input" id="he-him" name="pronouns[]" type="checkbox"
                            value="he/him/his">
                        <label class="ml-2" for="he-him">he/him/his</label>
                    </div>

                    <div class="select-input-div">
                        <input class="select-input" id="her" name="pronouns[]" type="checkbox"
                            value="ze/hir/hirs">
                        <label class="ml-2" for="her">ze/hir/hirs</label>
                    </div>

                    <div class="select-input-div">
                        <input class="select-input" id="prefer-not-to-say-pronouns" name="pronouns[]"
                            type="checkbox" value="Prefer Not To Say">
                        <label class="ml-2" for="prefer-not-to-say-pronouns">Prefer Not To Say</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input" id="otherPronounCheckbox" name="pronouns[]" type="checkbox"
                            value="Other">
                        <label class="ml-2" for="otherPronoun">Other</label>
                    </div>

                    <div class="m-3 flex flex-row">
                        <input class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                            id="otherPronounInput" name="otherPronoun" type="text" style="display: none;">
                    </div>
                </div>
            </div>
        </div>

        {{-- Sexual Orientation --}}
        <div class="col-span-6 mt-0 sm:col-span-4">
            <div class="my-4 flex flex-col" x-data="{ openSexualOrientation: false, selectedSexualOrientation: [] }">
                <x-form_label>
                    Sexual Orientation(s):
                </x-form_label>
                <button
                    class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                    type="button" @click="openSexualOrientation = !openSexualOrientation">
                    <span class="ml-0"
                        x-text="selectedSexualOrientation.length > 0 ? selectedSexualOrientation.join(', ') : 'Select Options'"></span>
                    <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                    x-show="openSexualOrientation" x-transition.scale.origin.top x-transition:enter.duration.300ms
                    x-transition:enter.ease-in-out x-transition:leave.duration.300ms x-transition:ease-in-out x-cloak>
                    <div class="select-input-div">
                        <input class="select-input" id="bisexual" name="sexual_orientation[]" type="checkbox"
                            value="Bisexual">
                        <label class="ml-2" for="bisexual">Bisexual</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input" id="heterosexual" name="sexual_orientation[]" type="checkbox"
                            value="Heterosexual/Straight">
                        <label class="ml-2" for="heterosexual">Heterosexual/Straight</label>
                    </div>
                    {{-- homosexual --}}
                    <div class="select-input-div">
                        <input class="select-input" id="homosexual" name="sexual_orientation[]" type="checkbox"
                            value="Gay/Lesbian">
                        <label class="ml-2" for="homosexual">Gay/Lesbian</label>
                    </div>



                    {{-- don't know --}}
                    <div class="select-input-div">
                        <input class="select-input" id="questioning" name="sexual_orientation[]" type="checkbox"
                            value="Don't Know">
                        <label class="ml-2" for="questioning">Don't Know</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input" id="prefer-not-to-say-orientation" name="sexual_orientation[]"
                            type="checkbox" value="Prefer Not To Say">
                        <label class="ml-2" for="prefer-not-to-say-orientation">Prefer Not To Say</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input" id="otherSexualOrientationCheckbox" name="sexual_orientation[]"
                            type="checkbox" value="Other">
                        <label class="ml-2" for="otherSexualOrientation">Other</label>
                    </div>

                    <div class="m-3 flex flex-row">
                        <input class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                            id="otherSexualOrientationInput" name="otherSexualOrientation" type="text"
                            style="display: none;">
                    </div>
                </div>
            </div>
        </div>

        <div class="my-4 flex flex-col" x-data="{ openEthnicGroup: false, selectedEthnicGroups: [] }">
            <x-form_label>
                Ethnic Group(s):
            </x-form_label>
            <button
                class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-2 text-gray-700 focus:border-blue-500"
                type="button" @click="openEthnicGroup = !openEthnicGroup">
                <span class="ml-0"
                    x-text="selectedEthnicGroups.length > 0 ? selectedEthnicGroups.join(', ') : 'Select Options'"></span>
                <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
                x-show="openEthnicGroup" x-transition.scale.origin.top x-transition:enter.duration.300ms
                x-transition:enter.ease-in-out x-transition:leave.duration.300ms x-transition:ease-in-out x-cloak>

                <div class="select-input-div">
                    <input class="select-input" id="american-indian" name="ethnic_group[]" type="checkbox"
                        value="American Indian or Alaska Native">
                    <label class="ml-2" for="american-indian">American Indian or Alaska Native</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="asian" name="ethnic_group[]" type="checkbox"
                        value="Asian">
                    <label class="ml-2" for="asian">Asian</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="black" name="ethnic_group[]" type="checkbox"
                        value="Black or African American">
                    <label class="ml-2" for="black">Black or African American</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="hispanic" name="ethnic_group[]" type="checkbox"
                        value="Hispanic or Latino">
                    <label class="ml-2" for="hispanic">Hispanic or Latino</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="pacific-islander" name="ethnic_group[]" type="checkbox"
                        value="Native Hawaiian or Other Pacific Islander">
                    <label class="ml-2" for="pacific-islander">Native Hawaiian or Other Pacific Islander</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="white" name="ethnic_group[]" type="checkbox"
                        value="White">
                    <label class="ml-2" for="white">White</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="prefer-not-to-say-ethnic" name="ethnic_group[]" type="checkbox"
                        value="prefer not to say">
                    <label class="ml-2" for="prefer-not-to-say-ethnic">Prefer Not To Say</label>
                </div>
                <div class="select-input-div">
                    <input class="select-input" id="otherEthnicGroupCheckbox" name="ethnic_group[]" type="checkbox"
                        value="Other">
                    <label class="ml-2" for="otherEthnicGroup">Other</label>
                </div>

                <div class="m-3 flex flex-row">
                    <input class="mr-0.5 mt-1 rounded-full transition duration-200 ease-in-out hover:bg-blue-500"
                        id="otherEthnicGroupInput" name="otherEthnicGroup" type="text" style="display: none;">
                </div>
            </div>
        </div>

        {{-- home_address_state --}}
        <x-form_label for="home_address_state">
            State (optional)
        </x-form_label>
        <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0" id="home_address_state"
            name="home_address_state" type="text">
            <option value="" disabled selected hidden>Select State</option>
            <option value="">N/A</option>

            @foreach ($states as $state)
                <option value="{{ $state }}">{{ $state }}</option>
            @endforeach
        </select>

        {{-- home_address_country --}}
        <x-form_label for="country">
            Country
        </x-form_label>
        <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0" id="home_address_country"
            name="home_address_country" type="text">
            <option value="" disabled selected hidden>Select Country</option>
            @if (isset($countries) && is_array($countries))
                @foreach ($countries as $country)
                    <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                @endforeach
            @endif
        </select>
    </div>

    {{-- Previous therapy --}}
    <x-form_label for="previous_therapy">Previous Therapy from Pineapple</x-form_label>
    <select class="form-select p-3" id="previous_therapy" name="previous_therapy" type="text">
        <option value="" disabled selected hidden>Select One</option>
        <option>Yes</option>
        <option>No</option>
    </select>

    {{-- possible_support_needed --}}
    {{-- <div class="col-span-6 mt-0 sm:col-span-4">
        <div class="relative mb-4 mt-6 w-full"
            x-data="{ showDropdown: false }">
            <x-form_label for="possible_support_needed">
                <p>Possible Support Needed: <span class="ml-2 text-xs"></p>
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
    </div> --}}
    <div class="col-span-6 mt-0 sm:col-span-4">
        <div class="relative mb-4 mt-6 w-full" x-data="{ showDropdown: false }">
            <x-form_label>
                Possible Support Needed:
            </x-form_label>
            <div class="rounded-md" @click.away="showDropdown = false">
                <div class="flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-1.5">
                    <button class="flex w-full flex-row justify-between" type="button"
                        @click="showDropdown = !showDropdown">
                        <p class="ml-1 p-1">Select Options</p>
                        <svg class="mt-1 h-[18px] w-[18px] text-gray-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
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
                                    name="possible_support_needed[]" type="checkbox" value="{{ $category }}"
                                    @if (is_array(old('possible_support_needed')) && in_array($category, old('possible_support_needed'))) checked @endif>
                                <label class="" for="possible_support_needed">{{ $category }}</label>
                            </div>
                        @endforeach

                        <div class="select-input-div m-2 mr-0.5 mt-0.5 rounded-full p-2 ">
                            <input
                                class="m-2 mr-0.5 mt-1 rounded-full p-2 transition duration-200 ease-in-out hover:cursor-pointer hover:bg-blue-400"
                                id="otherPossibleSupportCheckbox" name="possible_support_needed[]" type="checkbox"
                                value="Other">
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
                                        name="possible_support_needed[]"$client->waitlist = $request->input('waitlist', 0);

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

    {{-- client_contribution --}}
    <x-form_label for="client_contribution">
        Client Contribution
    </x-form_label>
    <x-form_input id="client_contribution" name="client_contribution" type="number" required placeholder="xxx"
        inputmode="numeric" pattern="[0-9]*" />

    <x-form_label for="max_sessions">Maximum Therapy Sessions:</x-form_label>
    <input class="mx-2 w-16 rounded-md border-blue-200 bg-gray-100 p-1 text-center ring-0" id="max_sessions"
        name="max_sessions" type="number" value="16">

    {{-- additional_notes --}}
    <x-form_label for="additional_notes">
        Additional Notes
    </x-form_label>
    {{-- <x-form_input id="additional_notes"
        name="additional_notes"
        type="text" /> --}}
    <textarea class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0" id="additional_notes"
        name="addtional_notes" cols="30" rows="3"></textarea>

    {{-- Therapist --}}
    <x-form_label for="therapist">
        Therapist
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 capitalize ring-0" id="user_id"
        name="user_id" required>
        <option value="" disabled selected hidden>Therapist</option>

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

    <div class="mt-4">
        <x-jet-label for="waitlist" value="{{ __('Waitlist') }}" />
        <div class="flex items-center mt-2">
            <label for="waitlist_yes" class="mr-4">
                <input id="waitlist_yes" type="radio" name="waitlist" value="1"
                    {{ $therapist->waitlist == 1 ? 'checked' : '' }} autofocus />
                <span class="ml-2 text-sm text-gray-600">Yes</span>
            </label>

            <label for="waitlist_no">
                <input id="waitlist_no" type="radio" name="waitlist" value="0"
                    {{ $therapist->waitlist == 0 ? 'checked' : '' }} />
                <span class="ml-2 text-sm text-gray-600">No</span>
            </label>
        </div>
        <x-jet-input-error for="waitlist" class="mt-2" />
    </div>



    <div class="mt-2 flex">
        <button class="button-secondary mx-auto">Add</button>
    </div>
</form>

<script src="{{ asset('js/intlTelInput.js') }}"></script>
<script src="{{ asset('js/utils.js') }}"></script>

<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        initialCountry: "us",
        separateDialCode: true,
        utilsScript: "{{ asset('js/utils.js') }}",
    });
</script>

<style>
    select-input {}

    select {
        color: #4a5568;
    }

    option:not(:first-of-type) {
        color: black;
    }
</style>

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

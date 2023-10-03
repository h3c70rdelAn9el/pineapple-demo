{{-- ! commented code out are fields they wanted ommitted. I kept them in place incase someone decides to put them back --}}
<form class="z-50 mx-auto mb-4 mt-2 h-full w-5/6 rounded-md border border-blue-600 bg-blue-200 p-4 shadow-lg md:w-2/3"
    style="z-index: 99999;"
    action="{{ route('client.store') }}"
    method="POST">
    @csrf
    {{-- <x-form_input_div> --}}
    <x-form_label for="client_code">
        Client Code
    </x-form_label>
    <x-form_input id="client_code"
        name="client_code"
        type="text"
        required
        placeholder="Client code" />
    {{-- </x-form_input_div> --}}

    {{-- Legal Name --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="legal_name">
        Legal Name
    </x-form_label>
    <x-form_input id="legal_name"
        name="legal_name"
        type="text"
        required
        placeholder="Legal name" />
    {{-- </x-form_input_div> --}}

    {{-- Preferred Name --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="preferred_name">
        Preferred Name
    </x-form_label>
    <x-form_input id="preferred_name"
        name="preferred_name"
        type="text"
        required
        placeholder="Preferred name" />
    {{-- </x-form_input_div> --}}

    {{-- Gender --}}
    {{-- <x-multi-select id="gender"
        name="$gender"
        label="Gender"
        value="gender"
        :options="$genders"


        ></x-multi-select> --}}

    <div class="my-4 flex flex-col"
        x-data="{ openGender: false }">
        <x-jet-label>Gender</x-jet-label>
        <button
            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3 text-gray-700 focus:border-blue-500"
            type="button"
            @click="openGender = !openGender">
            <span> (Select multiple if applicable)</span>
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
        <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
            x-show="openGender"
            x-transition.scale.origin.top
            x-transition:enter.duration.300ms
            x-transition:enter.ease-in-out
            x-transition:leave.duration.300ms
            x-transition:ease-in-out
            x-cloak>
            <div class="select-input-div">
                <input class="select-input"
                    id="male"
                    name="gender[]"
                    type="checkbox"
                    value="male">
                <label class="ml-2"
                    for="male">Male</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="female"
                    name="gender[]"
                    type="checkbox"
                    value="female">
                <label class="ml-2"
                    for="female">Female</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="transgender"
                    name="gender[]"
                    type="checkbox"
                    value="transgender">
                <label class="ml-2"
                    for="transgender">Transgender</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="cisgender"
                    name="gender[]"
                    type="checkbox"
                    value="cisgender">
                <label class="ml-2"
                    for="cisgender">Cisgender</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="bigender"
                    name="gender[]"
                    type="checkbox"
                    value="bigender">
                <label class="ml-2"
                    for="bigender">Bigender</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="non-binary"
                    name="gender[]"
                    type="checkbox"
                    value="non-binary">
                <label class="ml-2"
                    for="non-binary">Non-Binary</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="other"
                    name="gender[]"
                    type="checkbox"
                    value="other">
                <label class="ml-2"
                    for="other">Other</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="prefer-not-to-say"
                    name="gender[]"
                    type="checkbox"
                    value="prefer-not-to-say">
                <label class="ml-2"
                    for="prefer-not-to-say">Prefer Not To Say</label>
            </div>

            {{-- i need the above for Trnasgender, Cisgender, Bigender, Non-Binary, Other, Prefer Not To Say --}}

            {{-- TODO: MAKE THIS WORK: --}}
            {{-- @foreach ($genders as $gender)
                <div class="p-1">
                    <input type="checkbox"
                    class="rounded  ml-5 hover:bg-blue-400 hover:cursor-pointer"
                        :id="$gender"
                        :name="$gender[]"
                        :value="$gender"
                        x-on:click="('{{ $gender }}')">
                    <label class="ml-[2px] mt-1"
                        for="$gender">{{ $gender }}
                    </label>
                </div>
            @endforeach --}}
        </div>
    </div>

    {{-- Pronouns --}}
    {{-- <x-multi-select id="pronouns"
        name="pronouns"
        label="Pronouns"
        :options="$pronouns"></x-multi-select> --}}

    {{-- make a mulitple selecte field --}}
    <x-form_label for="pronouns">
        Pronouns
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0"
        id="pronouns"
        name="pronouns"
        type="text"
        required>
        <option value=""
            disabled
            selected
            hidden>Select Pronouns</option>
        <option>She/Her/Hers</option>
        <option>He/Him/His</option>
        <option>They/Them/Theirs</option>
        <option>Other</option>
    </select>

    {{-- Sexual Orientation --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="sexual_orientation">
        Sexual Orientation
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0 capitalize"
        id="sexual_orientation"
        name="sexual_orientation"
        type="text"
        required>
        <option class="text-gray-600"
            value=""
            disabled
            selected
            hidden>Select Orientation</option>
        <option>bisexual</option>
        <option>gay/lesbian</option>
        <option>hetrosexaul/straight</option>
        <option>don't know</option>
        <option>prefer not to say</option>
        <option>Other</option>
    </select>
    {{-- </x-form_input_div> --}}

    {{-- ethnic_group --}}
    {{-- <x-multi-select id="ethnic_group"
        name="Ethnic Group"
        label="Ethnic Group"
        :options="$ethnicGroups" /> --}}

    <div class="my-4 flex flex-col"
        x-data="{ openEthnicGroup: false, selectedEthnicGroups: [] }">
        <x-jet-label>Ethnic Group</x-jet-label>
        <button
            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3 text-gray-700 focus:border-blue-500"
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
    {{-- <x-form_input_div> --}}
    <x-form_label for="home_address_state">
        State (optional)
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0"
        id="home_address_state"
        name="home_address_state"
        type="text">
        <option value=""
            disabled
            selected
            hidden>Select State</option>
        {{-- @foreach ($states as $state)
                <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
            @endforeach --}}
        @foreach ($states as $state)
            <option value="{{ $state }}">{{ $state }}</option>
        @endforeach
    </select>
    {{-- </x-form_input_div> --}}

    {{-- home_address_zip --}}
    {{-- <x-form_input_div>
        <x-form_label for="home_address_zip">
            Zip Code
        </x-form_label>
        <x-form_input id="home_address_zip" type="text" name="home_address_zip" required placeholder="Zip Code" />
    </x-form_input_div> --}}

    {{-- home_address_country --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="country">
        Country
    </x-form_label>
    {{-- <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
            id="home_address_country"
            name="home_address_country"
            type="text"
            required>
            <option value=""
                disabled
                selected
                hidden>Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country }}">{{ $country }}</option>
            @endforeach
        </select> --}}
    {{-- <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
        id="home_address_country"
        name="home_address_country"
        type="text"
        required>
        <option value=""
            disabled
            selected
            hidden>Select Country</option>
        @if (isset($countries) && is_array($countries))
            @foreach ($countries as $country)
                <option value="{{ $country }}">{{ $country }}</option>
            @endforeach
        @endif
    </select> --}}
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0"
        id="home_address_country"
        name="home_address_country"
        type="text"
        required>
        <option value=""
            disabled
            selected
            hidden>Select Country</option>
        @if (isset($countries) && is_array($countries))
            @foreach ($countries as $country)
                <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
            @endforeach
        @endif
    </select>

    {{-- </x-form_input_div> --}}

    {{-- email --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="email">
        Email
    </x-form_label>
    <x-form_input id="email"
        name="email"
        type="text"
        required
        placeholder="email@example.com" />
    {{-- </x-form_input_div> --}}

    {{-- phone --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="phone">
        Phone
    </x-form_label>
    <x-form_input id="phone"
        name="phone"
        type="tel"
        required />
    {{-- </x-form_input_div> --}}

    {{-- contact_method --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="contact_method">
        Contact Method
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0"
        id="contact_method"
        name="contact_method"
        type="text"
        required>
        <option value=""
            disabled
            selected
            hidden>Select Contact Method</option>
        <option>Telephone Call</option>
        <option>Text Message</option>
        <option>Email</option>
    </select>
    {{-- </x-form_input_div> --}}

    {{-- <x-form_input_div>
        <x-form_label for="health_coverage_provider">
            Health Coverage Provider
        </x-form_label>
        <x-form_input id="health_coverage_provider" type="text" name="health_coverage_provider" required
                      placeholder="Health Coverage Provider" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="health_coverage_number">
            Health Coverage Number
        </x-form_label>
        <x-form_input id="health_coverage_number" type="text" name="health_coverage_number" required
                      placeholder="Health Coverage Number" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="health_coverage_expiration">
            Health Coverage Expiration
        </x-form_label>
        <input type="date" required id="health_cover_expiration" name="health_coverage_expiration">
    </x-form_input_div> --}}

    {{-- Previous therapy --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="previous_therapy">Previous Therapy from Pineapple</x-form_label>
    <select class="form-select p-3"
        id="previous_therapy"
        name="previous_therapy"
        type="text">
        <option value=""
            disabled
            selected
            hidden>Select One</option>
        <option>Yes</option>
        <option>No</option>
    </select>
    {{-- </x-form_input_div> --}}

    {{-- possible_support_needed --}}
    <x-multi-select id="possible_support_needed"
        name="Possible Support Needed"
        label="Possible Support Needed"
        :options="$categories" />

    {{-- client_contribution --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="client_contribution">
        Client Contribution
    </x-form_label>
    <x-form_input id="client_contribution"
        name="client_contribution"
        type="number"
        required
        placeholder="xxx"
        inputmode="numeric"
        pattern="[0-9]*" />
    {{-- </x-form_input_div> --}}

    {{-- preferred_language --}}
    {{-- <x-form_input_div>
        <x-form_label for="preferred_language">
            Preferred Language
        </x-form_label>
        <select id="preferred_language" type="text" name="preferred_language"
                class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" required>
            <option value="" disabled selected hidden>Please Select:</option>
            <option>English</option>
            <option>Spanish</option>
            <option>French</option>
            <option>German</option>
            <option>Italian</option>
            <option>Portuguese</option>
            <option>Chinese</option>
            <option>Japanese</option>
            <option>Arabic</option>
            <option>Other</option>
        </select>
    </x-form_input_div> --}}

    {{-- therapist --}}
    {{-- <x-form_input_div> --}}
    <x-form_label for="therapist">
        Therapist
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0 capitalize"
        id="user_id"
        name="user_id"
        required>
        <option value=""
            disabled
            selected
            hidden>Therapist</option>
        @foreach ($activeTherapists as $row)
            <option value="{{ $row->id }}">
                {{ $row->name }}
            </option>
        @endforeach
    </select>
    {{-- </x-form_input_div> --}}

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

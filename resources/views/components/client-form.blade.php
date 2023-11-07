{{-- ! commented code out are fields they wanted ommitted. I kept them in place incase someone decides to put them back --}}
<form class="z-50 mx-auto mb-4 mt-2 h-full w-5/6 rounded-md border border-blue-600 bg-blue-200 p-4 shadow-lg md:w-2/3"
    style="z-index: 99999;"
    action="{{ route('client.store') }}"
    method="POST">
    @csrf
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
    <x-form_label for="preferred_name">
        Preferred Name
    </x-form_label>
    <x-form_input id="preferred_name"
        name="preferred_name"
        type="text"
        required
        placeholder="Preferred name" />

        {{-- Status --}}
        <x-form_label for="status">
            Status
        </x-form_label>
        {{-- make a boolean --}}
        <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0"
            id="status"
            name="status"
            type="text">
            <option value=""
                disabled
                selected
                hidden>Select Status</option>
            <option value="0">Active</option>
            <option value="1">Inactive</option>
        </select>


    {{-- Gender --}}
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
        type="text">
        <option value=""
            disabled
            selected
            hidden>Select Pronouns</option>
        <option value="She/Her/Her/Hers/Herself">She/Her/Her/Hers/Herself
        </option>
        <option value="He/Him/His/His/Himself">He/Him/His/His/Himself</option>
        <option value="They/Them/Their/Theirs/Themselves">They/Them/Their/Theirs/Themselves</option>
        <option value="Ze/Hir/Hir/Hirs/Hirself">Ze/Hir/Hir/Hirs/Hirself</option>
        <option value="Ey/Em/Eir/Eirs/Eirself">Ey/Em/Eir/Eirs/Eirself
        </option value="Per/Per/Pers/Perself/Perse">
        <option>Per/Per/Pers/Perself/Perse
        </option>
        <option value="Ve/Ver/Vis/Verself/Veself">Ve/Ver/Vis/Verself/Veself
        </option>
        <option value="Xe/Xem/Xyr/Xyrs/Xemself">Xe/Xem/Xyr/Xyrs/Xemself
        </option>
        <option value="Zie/Zim/Zir/Zirs/Zirself">Zie/Zim/Zir/Zirs/Zirself
        </option>
        <option value="Other">Other</option>
        <option value="Prefer Not To Say">Prefer Not to Say</option>
    </select>

    {{-- Sexual Orientation --}}
    <x-form_label for="sexual_orientation">
        Sexual Orientation
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 capitalize ring-0"
        id="sexual_orientation"
        name="sexual_orientation"
        type="text">
        <option class="text-gray-600"
            value=""
            disabled
            selected
            hidden>Select Orientation</option>
        <option>bisexual</option>
        <option>gay/lesbian</option>
        <option>heterosexaul/straight</option>
        <option>don't know</option>
        <option>prefer not to say</option>
        <option>Other</option>
    </select>


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
        @foreach ($states as $state)
            <option value="{{ $state }}">{{ $state }}</option>
        @endforeach
    </select>

    {{-- home_address_country --}}
    <x-form_label for="country">
        Country
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 ring-0"
        id="home_address_country"
        name="home_address_country"
        type="text">
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

    {{-- email --}}
    <x-form_label for="email">
        Email
    </x-form_label>
    <x-form_input id="email"
        name="email"
        type="text"
        required
        placeholder="email@example.com" />

    {{-- phone --}}
    <x-form_label for="phone">
        Phone
    </x-form_label>
    <x-form_input id="phone"
        name="phone"
        type="tel"
        required />

    {{-- contact_method --}}
    <div class="my-4 flex flex-col"
        x-data="{ openContact: false }">
        <x-jet-label>Contact Method:</x-jet-label>
        <button
            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3 text-gray-700 focus:border-blue-500"
            type="button"
            @click="openContact = !openContact">
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
            x-show="openContact"
            x-transition.scale.origin.top
            x-transition:enter.duration.300ms
            x-transition:enter.ease-in-out
            x-transition:leave.duration.300ms
            x-transition:ease-in-out
            x-cloak>
            <div class="select-input-div">
                <input class="select-input"
                    id="telephone"
                    name="contact_method[]"
                    type="checkbox"
                    value="telephone">
                <label class="ml-2"
                    for="telephone">Telephone</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="text"
                    name="contact_method[]"
                    type="checkbox"
                    value="text">
                <label class="ml-2"
                    for="text">Text</label>
            </div>
            <div class="select-input-div">
                <input class="select-input"
                    id="email"
                    name="contact_method[]"
                    type="checkbox"
                    value="email">
                <label class="ml-2"
                    for="email">Email</label>
            </div>
        </div>
    </div>

    {{-- Previous therapy --}}
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

    {{-- possible_support_needed --}}
    <x-multi-select id="possible_support_needed"
        name="Possible Support Needed"
        label="Possible Support Needed"
        :options="$categories" />

    {{-- client_contribution --}}
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

    {{-- additional_notes --}}
    <x-form_label for="additional_notes">
        Additional Notes
    </x-form_label>
    <x-form_input id="additional_notes"
        name="additional_notes"
        type="text" />

    {{-- Therapist --}}
    <x-form_label for="therapist">
        Therapist
    </x-form_label>
    <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 p-3 capitalize ring-0"
        id="user_id"
        name="user_id"
        required>
        <option value=""
            disabled
            selected
            hidden>Therapist</option>

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

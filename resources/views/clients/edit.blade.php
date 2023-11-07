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
            @method('PUT')
            <input name="_method"
                type="hidden"
                value="PUT">

            <input name="user_id"
                type="hidden"
                value="{{ $client->user_id }}">

            {{-- client_code --}}
            <x-form-field name="client_code"
                type="text"
                label="Client Code">
                {{ $client->client_code }}
            </x-form-field>

            {{-- preferred_name --}}
            <x-form-field name="preferred_name"
                type="text"
                label="Preferred Name">
                {{ $client->preferred_name }}
            </x-form-field>

            {{-- legal_name --}}
            <x-form-field name="legal_name"
                type="text"
                label="Legal Name">
                {{ $client->legal_name }}
            </x-form-field>

            {{-- Status --}}
            <x-form_label for="status">
                Status
            </x-form_label>
            {{-- make a boolean --}}
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

            {{-- gender --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-multi-select id="gender"
                    name="gender"
                    value="{{ $client->gender }}"
                    label="Gender:   (previous selection: {{ $client->gender }}) "
                    placeholder="{{ $client->gender }}"
                    :options="['Male', 'Female', 'Non-binary', 'Prefer Not To Say']"></x-multi-select>
            </div>

            {{-- Pronouns --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-multi-select id="pronouns"
                    name="pronouns"
                    value="{{ $client->pronouns }}"
                    label="Pronoun(s):   (previous selection: {{ $client->pronouns }}) "
                    placeholder="{{ $client->pronouns }}"
                    :options="[
                        'She/Her/Her/Hers/Herself',
                        'He/Him/His/His/Himself',
                        'They/Them/Their/Theirs/Themselves',
                        'Ze/Hir/Hir/Hirs/Hirself',
                        'Ey/Em/Eir/Eirs/Eirself',
                        'Per/Per/Pers/Perself/Perse',
                        'Xe/Xem/Xyr/Xyrs/Xemself',
                        'Zie/Zim/Zir/Zirs/Zirself',
                        'He/She/His/Hers/Himself/Herself',
                        'Prefer Not To Say',
                        'Other',
                    ]"></x-multi-select>
            </div>

            {{-- sexual_orientation --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-multi-select id="sexual_orientation"
                    name="sexual_orientation"
                    value="{{ $client->sexual_orientation }}"
                    label="Sexual Orientation:   (previous selection: {{ $client->sexual_orientation }}) "
                    placeholder="{{ $client->sexual_orientation }}"
                    :options="[
                        'Heterosexual',
                        'Bisexual',
                        'Homosexual',
                        'Asexual',
                        'Pansexual',
                        'Demisexual',
                        'Queer',
                        'Questioning',
                        'Prefer Not To Say',
                        'Other',
                    ]"></x-multi-select>
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

            {{-- email --}}
            <x-form-field name="email"
                type="text"
                label="Email">
                {{ $client->email }}
            </x-form-field>

            {{-- phone --}}
            {{-- TODO: BRING IN THE PHONE INPUT --}}
            <x-form-field name="phone"
                type="text"
                label="Phone">
                {{ $client->phone }}
            </x-form-field>

            {{-- home_address_state --}}
            <x-single-select id="home_address_state"
                name="home_address_state"
                value="{{ $client->home_address_state }}"
                label="State:   (previous selection: {{ $client->home_address_state }}) "
                placeholder="{{ $client->home_address_state }}"
                :options="$states"></x-single-select>

            {{-- home_address_country --}}
            <x-single-select id="home_address_country"
                name="home_address_country"
                value="{{ $client->home_address_country }}"
                label="Country: (previous selection: {{ $client->home_address_country }})"
                placeholder="{{ $client->home_address_country }}"
                :options="$clientCountries"></x-single-select>

            {{-- contact_method --}}
            <x-multi-select id="contact_method"
                name="contact_method"
                value="{{ $client->contact_method }}"
                label="Contact Method (previous selection: {{ $client->contact_method }})"
                placeholder="{{ $client->contact_method }}"
                :options="['Telephone Call', 'Text Message', 'Email']"></x-multi-select>

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
            <x-form-field name="client_contribution"
                type="text"
                label="Client Contribution">
                {{ $client->client_contribution }}
            </x-form-field>

            {{-- Therapist --}}
            <x-form_label for="therapist">
                Therapist
            </x-form_label>
            <select class="peer mt-2 w-full rounded-md border-blue-200 bg-gray-100 p-2 capitalize ring-0"
                id="user_id"
                name="user_id"
                required>
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

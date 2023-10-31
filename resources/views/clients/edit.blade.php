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
                    label="Gender:   (previous selection: {{ $client->sexual_orientation }}) "
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

            {{-- ethnic_groups --}}
            <div class="col-span-6 mt-0 sm:col-span-4">
                <x-multi-select id="ethnic_group"
                    name="ethnic_group"
                    value="{{ $client->ethnic_group }}"
                    label="Ethnic Group(s):   (previous selection: {{ $client->ethnic_group }}) "
                    placeholder="{{ $client->ethnic_group }}"
                    :options="[
                        'she/her/hers',
                        'he/him/his',
                        'they/them/theirs',
                        'per/per/pers',
                        'ze/hir/hirs',
                        'prefer not to say',
                        'Other',
                    ]"></x-multi-select>
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
            <x-single-select id="contact_method"
                name="contact_method"
                value="{{ $client->contact_method }}"
                label="Contact Method:   (previous selection: {{ $client->contact_method }}) "
                placeholder="{{ $client->contact_method }}"
                :options="['Telephone Call', 'Text Message', 'Email']"></x-single-select>

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

            {{-- additional_notes --}}
            <div class="w-full">
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

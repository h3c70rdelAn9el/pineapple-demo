@php
    // TODO:  IS THIS OKAY?
    $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));
    $timeZones = json_decode($timeZonesJson, true);
    $statesJson = file_get_contents(resource_path('json/states.json'));
    $states = json_decode($statesJson, true);
    $countriesJson = file_get_contents(resource_path('json/countries.json'));
    $countries = json_decode($countriesJson, true);
@endphp

<div>
    <form method="POST"
        action="{{ route('profile.update') }}"
        x-on:submit.prevent="submitForm">
        @csrf
        @method('put')
        <!-- Profile Photo -->
        {{-- @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="col-span-6 sm:col-span-4"
                x-data="{ photoName: null, photoPreview: null }">
                <!-- Profile Photo File Input -->
                <input class="hidden"
                    type="file"
                    wire:model="photo"
                    x-ref="photo"
                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo"
                    value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2"
                    x-show="! photoPreview">
                    <img class="h-20 w-20 rounded-full object-cover"
                        src="{{ $this->user->profile_photo_url }}"
                        alt="{{ $this->user->name }}">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2"
                    style="display: none;"
                    x-show="photoPreview">
                    <span class="block h-20 w-20 rounded-full bg-cover bg-center bg-no-repeat"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mr-2 mt-2"
                    type="button"
                    x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button class="mt-2"
                        type="button"
                        wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error class="mt-2"
                    for="photo" />
            </div>
        @endif --}}

        <div>
            <x-jet-label value="Name" />
            <x-jet-input class="mt-1 block w-full"
                id="name"
                name="name"
                type="text"
                value="{{ $user->name }}"
                wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error class="mt-2"
                for="name" />
        </div>

        {{-- preferred_name --}}
        <div>
            <x-jet-label value="Preferred Name" />
            <x-jet-input class="mt-1 block w-full"
                id="preferred_name"
                name="preferred_name"
                type="text"
                value="{{ $user->preferred_name }}"
                wire:model.defer="state.preferred_name" />
            <x-jet-input-error class="mt-2"
                for="preferred_name" />
        </div>

        {{-- gender --}}

        <div x-data="{ isOpen: false, selectedGenders: @json($user->genders ?: []) }">
            <div class="relative">
                <x-jet-label value="Gender  (previous selection: {{ $user->gender }})" />
                {{-- <x-jet-label>
                    <span>Gender</span>
                    <span class="ml-2 text-xs">(previous selection: {{ $user->gender }})</span>
                </x-jet-label> --}}
                <div class="mt-1"
                    x-on:click="isOpen = !isOpen">
                    <div
                        class="flex flex-row justify-between rounded border border-blue-300 bg-gray-100 p-2 hover:cursor-pointer">
                        <span x-text="selectedGenders.length ? selectedGenders.join(', ') : 'Select gender(s)'"></span>
                        <svg class="inline-block h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <div x-show="isOpen"
                        {{-- make a transition to open  --}}
                        x-on:click.away="isOpen = false"
                        x-cloak>

                        <div class="absolute w-full rounded-md border border-gray-300 shadow-lg">

                            <select class="flex w-full flex-row bg-gray-200"
                                name="selectedGenders[]"
                                x-model="selectedGenders"
                                multiple>
                                <option class="gender-options transition duration-200"
                                    value="Male">Male</option>
                                <option class="gender-options"
                                    value="Female">Female</option>
                                <option class="gender-options transition duration-200"
                                    value="Transgender">Transgender</option>
                                <option class="gender-options transition duration-200"
                                    value="Genderfluid">Genderfluid</option>
                                <option class="gender-options transition duration-200"
                                    value="Genderqueer">Genderqueer</option>
                                <option class="gender-options transition duration-200"
                                    value="Agender">Agender</option>
                                <option class="gender-options transition duration-200"
                                    value="Cisgender">Cisgender</option>
                                <option class="gender-options transition duration-200"
                                    value="Bigender">Bigender</option>
                                <option class="gender-options transition duration-200"
                                    value="Non-binary">Non-Binary</option>
                                <option class="gender-options transition duration-200"
                                    value="Prefer Not To Say">Prefer Not To Say</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- email --}}
        <div>
            <x-jet-label value="email" />
            <x-jet-input class="mt-1 block w-full"
                id="email"
                name="email"
                type="email"
                value="{{ $user->email }}"
                wire:model.defer="state.email" />
            <x-jet-input-error class="mt-2"
                for="email" />
        </div>

        {{-- license --}}
        <div>
            <x-jet-label value="License" />
            <x-jet-input class="mt-1 block w-full"
                id="license"
                name="license"
                type="text"
                value="{{ $user->license }}"
                wire:model.defer="state.license" />
            <x-jet-input-error class="mt-2"
                for="license" />
        </div>

        {{-- certificate --}}

        {{-- expires_at --}}
        {{-- <div>
                <x-jet-label value="{{ $user->expires_at }}" />
                <x-jet-input class="mt-1 block w-full"
                    id="expires_at"
                    name="expires_at"
                    type="date"
                    value="{{ $user->expires_at }}"
                    wire:model.defer="state.expires_at" />
                <x-jet-input-error class="mt-2"
                    for="expires_at" />
            </div> --}}

        {{-- account_name --}}
        <div>
            <x-jet-label value="Account Name" />
            <x-jet-input class="mt-1 block w-full"
                id="account_name"
                name="account_name"
                type="text"
                value="{{ $user->account_name }}"
                wire:model.defer="state.account_name" />
            <x-jet-input-error class="mt-2"
                for="account_name" />
        </div>

        {{-- account_number --}}
        <div>
            <x-jet-label value="Account Number" />
            <x-jet-input class="mt-1 block w-full"
                id="account_number"
                name="account_number"
                type="text"
                value="{{ $user->account_number }}"
                wire:model.defer="state.account_number" />
            <x-jet-input-error class="mt-2"
                for="account_number" />
        </div>

        {{-- routing_number --}}
        <div>
            <x-jet-label value="Routing Number" />
            <x-jet-input class="mt-1 block w-full"
                id="routing_number"
                name="routing_number"
                type="text"
                value="{{ $user->routing_number }}"
                wire:model.defer="state.routing_number" />
            <x-jet-input-error class="mt-2"
                for="routing_number" />
        </div>

        {{-- on_vacation --}}
        {{-- <div>
                    <x-jet-label value="On vacation" />

                        <x-jet-input type="checkbox"
                            id="on_vacation"
                            name="on_vacation"
                            value="{{ $user->on_vacation }}"
                            wire:model.defer="state.on_vacation" />
                    <x-jet-input-error class="mt-2"
                        for="on_vacation" />
                </div> --}}

        {{-- clinical_license_verification_portal --}}
        <div>
            <x-jet-label value="Clinical License Verification Portal" />
            <x-jet-input class="mt-1 block w-full"
                id="clinical_license_verification_portal"
                name="clinical_license_verification_portal"
                type="text"
                value="{{ $user->clinical_license_verification_portal }}"
                wire:model.defer="state.clinical_license_verification_portal" />
            <x-jet-input-error class="mt-2"
                for="clinical_license_verification_portal" />
        </div>

        {{-- title --}}
        <div>
            <x-jet-label value="Title" />
            <x-jet-input class="mt-1 block w-full"
                id="title"
                name="title"
                type="text"
                value="{{ $user->title }}"
                wire:model.defer="state.title" />
            <x-jet-input-error class="mt-2"
                for="title" />
        </div>

        {{-- intern --}}
        <div>
            <x-jet-label value="Intern" />
            <x-jet-input id="intern"
                name="intern"
                type="checkbox"
                value="{{ $user->intern }}"
                wire:model.defer="state.intern" />
            <x-jet-input-error class="mt-2"
                for="intern" />
        </div>

        {{-- supervisor_name --}}
        <div>
            <x-jet-label value="Supervisor Name" />
            <x-jet-input class="mt-1 block w-full"
                id="supervisor_name"
                name="supervisor_name"
                type="text"
                value="{{ $user->supervisor_name }}"
                wire:model.defer="state.supervisor_name" />
            <x-jet-input-error class="mt-2"
                for="supervisor_name" />
        </div>

        {{-- street_address --}}
        <div>
            <x-jet-label value="Street Address" />
            <x-jet-input class="mt-1 block w-full"
                id="street_address"
                name="street_address"
                type="text"
                value="{{ $user->street_address }}"
                wire:model.defer="state.street_address" />
            <x-jet-input-error class="mt-2"
                for="street_address" />
        </div>

        {{-- zip_code_postal_code --}}
        <div>
            <x-jet-label value="Zip Code Postal Code" />
            <x-jet-input class="mt-1 block w-full"
                id="zip_code_postal_code"
                name="zip_code_postal_code"
                type="text"
                value="{{ $user->zip_code_postal_code }}"
                wire:model.defer="state.zip_code_postal_code" />
            <x-jet-input-error class="mt-2"
                for="zip_code_postal_code" />
        </div>

        {{-- iban_swift_code --}}
        <div>
            <x-jet-label value="IBAN Swift Code" />
            <x-jet-input class="mt-1 block w-full"
                id="iban_swift_code"
                name="iban_swift_code"
                type="text"
                value="{{ $user->iban_swift_code }}"
                wire:model.defer="state.iban_swift_code" />
            <x-jet-input-error class="mt-2"
                for="iban_swift_code" />
        </div>

        {{-- full --}}
        {{-- <div>
                    <x-jet-label value="Full" />
                    <x-jet-input
                        id="full"
                        name="full"
                        type="checkbox"
                        value="{{ $user->full }}"
                        wire:model.defer="state.full" />
                    <x-jet-input-error class="mt-2"
                        for="full" />
                </div> --}}

        {{-- contact_for_promotionals --}}
        <div>
            <x-jet-label value="Contact For Promotionals" />
            <x-jet-input id="contact_for_promotionals"
                name="contact_for_promotionals"
                type="checkbox"
                value="1"
                {{-- Assuming the value is boolean, set it to 1 for true --}}
                {{ $user->contact_for_promotionals ? 'checked' : '' }} />
            <x-jet-input-error class="mt-2"
                for="contact_for_promotionals" />
        </div>

        {{-- number_of_potential_clients --}}
        <div>
            <x-jet-label value="Number Of Potential Clients" />
            <x-jet-input class="mt-1 block w-full"
                id="number_of_potential_clients"
                name="number_of_potential_clients"
                type="numerical"
                value="{{ $user->number_of_potential_clients }}"
                wire:model.defer="state.number_of_potential_clients" />
            <x-jet-input-error class="mt-2"
                for="number_of_potential_clients" />
        </div>

        {{-- out_of_state_coaching --}}
        <div>
            <x-jet-label value="Out Of State Coaching" />
            <x-jet-input id="out_of_state_coaching"
                name="out_of_state_coaching"
                type="checkbox"
                value="{{ $user->out_of_state_coaching }}"
                wire:model.defer="state.out_of_state_coaching" />
            <x-jet-input-error class="mt-2"
                for="out_of_state_coaching" />
        </div>

        {{-- state --}}
        <div>
            <x-jet-label value="State" />
            <x-jet-input class="mt-1 block w-full"
                id="state"
                name="state"
                type="text"
                value="{{ $user->state }}"
                wire:model.defer="state.state" />
            <x-jet-input-error class="mt-2"
                for="state" />
        </div>

        {{-- country --}}
        <div>
            <x-jet-label value="Country" />
            <x-jet-input class="mt-1 block w-full"
                id="country"
                name="country"
                type="text"
                value="{{ $user->country }}"
                wire:model.defer="state.country" />
            <x-jet-input-error class="mt-2"
                for="country" />
        </div>

        {{-- county_town --}}
        <div>
            <x-jet-label value="County Town" />
            <x-jet-input class="mt-1 block w-full"
                id="county_town"
                name="county_town"
                type="text"
                value="{{ $user->county_town }}"
                wire:model.defer="state.county_town" />
            <x-jet-input-error class="mt-2"
                for="county_town" />
        </div>

        {{-- space for new clients --}}
        <div>
            <x-jet-label value="Space For New Clients" />
            <x-jet-input class="mt-1 block w-full"
                id="space_for_new_clients"
                name="space_for_new_clients"
                type="numeric"
                value="{{ $user->space_for_new_clients }}"
                wire:model.defer="state.space_for_new_clients" />
            <x-jet-input-error class="mt-2"
                for="space_for_new_clients" />
        </div>

        {{-- notes --}}
        <div>
            <x-jet-label value="Notes" />
            <textarea class="mt-1 block w-full text-gray-600"
                id="notes"
                name="notes"
                type="text">
                    {{ $user->notes }}
            </textarea>
        </div>


        <button
            class="m-2 w-40 rounded-md bg-blue-200 p-2 text-center shadow-md shadow-blue-100 transition-all duration-200 ease-in hover:bg-blue-400"
            type="submit"
            {{-- href="{{ route('therapist.update', ['id' => $this->id]) }}" --}}
            {{-- wire:loading.attr="disabled" --}}
            {{-- wire:target="photo" --}}>
            Save
        </button>
    </form>

</div>

<script>
    function saveSelectedGenders(selectedGenders) {
        // Perform actions with the selected genders, for example, send them to the server.
        console.log('Selected Genders:', selectedGenders);
        // You can send the selectedGenders array to your server using an API call here.
    }
</script>

<style>
    .gender-options:hover {
        background-color: #4299e1;
        /* what is tailwindcss blue-400 */
    }
</style>

{{-- <script>
    // Alpine.js code
    window.addEventListener('DOMContentLoaded', () => {
        Alpine.data('formController', () => ({
            selectedGenders: @json($user->genders ?: []), // Initialize selected genders from server data if available
            selectedGendersInput: [],

            saveSelectedGenders() {
                this.selectedGendersInput = this.selectedGenders;
            }
        }));
    });
</script> --}}

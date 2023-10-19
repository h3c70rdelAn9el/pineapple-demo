@php
    // TODO:  IS THIS OKAY?
    $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));
    $timeZones = json_decode($timeZonesJson, true);
    $statesJson = file_get_contents(resource_path('json/states.json'));
    $states = json_decode($statesJson, true);
    $countriesJson = file_get_contents(resource_path('json/countries.json'));
    $countries = json_decode($countriesJson, true);
@endphp

<x-jet-form-section submit="updateProfileInformation" wire:submit='submitForm'>
{{-- Todo:  add the submitForm? --}}
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
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
        @endif

        {{-- name --}}
        {{-- <x-user-text-input name="name"
            type="text"
            label="Name"
            model="state.name"
            autocomplete="name" /> --}}

                    <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>


        {{-- preferred name --}}
        {{-- <x-user-text-input name="preferred_name"
            type="text"
            label="Preferred Name"
            model="state.preferred_name"
            autocomplete="preferred_name" /> --}}

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="preferred_name" value="{{ __('preferred_name') }}" />
            <x-jet-input id="preferred_name" type="text" class="mt-1 block w-full" wire:model.defer="state.preferred_name" autocomplete="preferred_name" />
            <x-jet-input-error for="preferred_name" class="mt-2" />
        </div>
        {{-- gender --}}
        {{-- <div class="col-span-6 mt-0 sm:col-span-4">
            <x-multi-select id="gender"
                name="gender"
                value="{{ $this->user->gender }}"
                label="Gender"
                :options="['Male', 'Female', 'Non-binary', 'Prefer Not To Say']"
                wire:model="selectedOptions"
                ></x-multi-select>
        </div> --}}

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email"
                value="{{ __('Email') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="email"
                type="email"
                wire:model.defer="state.email" />
            <x-jet-input-error class="mt-2"
                for="email" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                    !$this->user->hasVerifiedEmail())
                <p class="mt-2 text-sm">
                    {{ __('Your email address is unverified.') }}

                    <button class="text-sm text-gray-600 underline hover:text-gray-900"
                        type="button"
                        wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 text-sm font-medium text-green-600"
                        v-show="verificationLinkSent">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        {{-- License --}}
        <x-user-text-input name="license"
            type="text"
            id="license"
            label="License"
            wire:model.defer="state.license"
            autocomplete="license" />

        {{-- Expires at --}}
        <x-user-text-input name="expires_at"
            type="date"
            id="expires_at"
            label="Expires at"
            wire:model.defer="state.expires_at"
            autocomplete="expires_at" />

        {{-- Bank Information --}}
        {{-- <div class="border border-purple-400">
            <h2 class="mb-1 mt-6 text-lg leading-tight text-gray-600">
                {{ __('Enter Payment Details') }}
            </h2>
    </div> --}}

        {{-- Intern --}}
        {{-- make a boolean input --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="intern"
                value="{{ __('Intern') }}" />
            <input class="rounded"
                id="intern"
                type="checkbox"
                wire:model.defer="state.intern"
                autocomplete="intern" />
            <x-jet-input-error class="mt-2"
                for="intern" />
        </div>

        {{-- supervisor name --}}
        <x-user-text-input name="supervisor_name"
            type="text"
            id="supervisor_name"
            label="Supervisor name"
            wire:model.defer="state.supervisor_name"
            autocomplete="supervisor_name" />

        {{-- street address --}}
        <x-user-text-input name="street_address"
            type="text"
            id="street_address"
            wire:model.defer="state.street_address"
            label="Street address"
            autocomplete="street_address" />

        {{-- county/town --}}
        <x-user-text-input name="county"
            type="text"
            id="county"
            wire:model.defer="state.county"
            label="County/Town"
            model="state.county"
            autocomplete="county" />



        {{-- States --}}
        <div class="relative col-span-6 mb-4 w-full sm:col-span-4">
            <x-form_label for="state">
                State (optional)
            </x-form_label>
            <select class="peer mt-2 w-full rounded-md border-b-2 border-blue-200 bg-gray-100 p-3 ring-0"
                id="state"
                wire:model.defer="state.state"
                name="state"
                type="text">
                <option value=""
                    disabled
                    selected
                    hidden>Select State</option>

                {{-- @foreach ($states as $state)
                <option value="{{ $state }}">{{ $state }}</option>
            @endforeach --}}
                <!-- States -->
                <option value="Alabama">Alabama</option>
                <option value="Alaska">Alaska</option>
                <option value="Arizona">Arizona</option>
                <option value="Arkansas">Arkansas</option>
                <option value="California">California</option>
                <option value="Colorado">Colorado</option>
                <option value="Connecticut">Connecticut</option>
                <option value="Delaware">Delaware</option>
                <option value="Florida">Florida</option>
                <option value="Georgia">Georgia</option>
                <option value="Hawaii">Hawaii</option>
                <option value="Idaho">Idaho</option>
                <option value="Illinois">Illinois</option>
                <option value="Indiana">Indiana</option>
                <option value="Iowa">Iowa</option>
                <option value="Kansas">Kansas</option>
                <option value="Kentucky">Kentucky</option>
                <option value="Louisiana">Louisiana</option>
                <option value="Maine">Maine</option>
                <option value="Maryland">Maryland</option>
                <option value="Massachusetts">Massachusetts</option>
                <option value="Michigan">Michigan</option>
                <option value="Minnesota">Minnesota</option>
                <option value="Mississippi">Mississippi</option>
                <option value="Missouri">Missouri</option>
                <option value="Montana">Montana</option>
                <option value="Nebraska">Nebraska</option>
                <option value="Nevada">Nevada</option>
                <option value="New Hampshire">New Hampshire</option>
                <option value="New Jersey">New Jersey</option>
                <option value="New Mexico">New Mexico</option>
                <option value="New York">New York</option>
                <option value="North Carolina">North Carolina</option>
                <option value="North Dakota">North Dakota</option>
                <option value="Ohio">Ohio</option>
                <option value="Oklahoma">Oklahoma</option>
                <option value="Oregon">Oregon</option>
                <option value="Pennsylvania">Pennsylvania</option>
                <option value="Rhode Island">Rhode Island</option>
                <option value="South Carolina">South Carolina</option>
                <option value="South Dakota">South Dakota</option>
                <option value="Tennessee">Tennessee</option>
                <option value="Texas">Texas</option>
                <option value="Utah">Utah</option>
                <option value="Vermont">Vermont</option>
                <option value="Virginia">Virginia</option>
                <option value="Washington">Washington</option>
                <option value="West Virginia">West Virginia</option>
                <option value="Wisconsin">Wisconsin</option>
                <option value="Wyoming">Wyoming</option>

                <!-- U.S. Territories and Others -->
                <option value="American Samoa">American Samoa</option>
                <option value="Guam">Guam</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="U.S. Virgin Islands">U.S. Virgin Islands</option>
                <option value="District Of Columbia">District Of Columbia</option>
                <option value="Federated States Of Micronesia">Federated States Of Micronesia</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Palau">Palau</option>

            </select>
        </div>





        {{-- zip code --}}
        <x-user-text-input name="zip_code_postal_code"
            type="text"
            id="zip_code_postal_code"
            label="Zip code/Postal code"
            wore:model.defer="state.zip_code_postal_code"

            autocomplete="zip_code_postal_code" />

        {{-- country --}}
        {{-- <div class="col-span-6 sm:col-span-4">
            <x-single-select id="country"
                name="country"
                label="Country"
                :options="$countries"
                :selected="$this->user->country"
                wire:model.defer="state.country"
                ></x-single-select>
        </div> --}}

        {{-- time_zone --}}
        {{-- <div class="col-span-6 sm:col-span-4">
            <x-single-select id="time_zone"
                name="time_zone"
                label="Time Zone"
                :options="$timeZones"
                :selected="$this->user->time_zone"
                wire:model.defer="state.time_zone"
                ></x-single-select>
        </div> --}}

        {{-- IBAN/Swift Code --}}
        {{-- <x-user-text-input name="iban_swift_code"
            type="text"
            label="IBAN/Swift Code"
            model="state.iban_swift_code"
            autocomplete="iban_swift_code" /> --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="iban_swift_code"
                value="{{ __('iban_swift_code') }}" />
            <input class="rounded"
                id="iban_swift_code"
                type="text"
                wire:model.defer="state.iban_swift_code"
                autocomplete="iban_swift_code" />
            <x-jet-input-error class="mt-2"
                for="iban_swift_code" />
        </div>

        {{-- Out of State coaching --}}
        {{-- <x-user-text-input name="out_of_state_coaching"
            type="text"
            label="Out of State coaching"
            model="state.out_of_state_coaching"
            autocomplete="out_of_state_coaching" /> --}}

        {{-- Out of state coaching --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="out_of_state_coaching"
                value="{{ __('out_of_state_coaching') }}" />
            <input class="rounded"
                id="out_of_state_coaching"
                type="checkbox"
                wire:model.defer="state.out_of_state_coaching"
                autocomplete="out_of_state_coaching" />
            <x-jet-input-error class="mt-2"
                for="out_of_state_coaching" />
        </div>


        {{-- contact_for_promotionals --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="contact_for_promotionals"
                value="{{ __('Contact for promotionals') }}" />
            <input class="rounded"
                id="contact_for_promotionals"
                type="checkbox"
                wire:model.defer="state.contact_for_promotionals"
                autocomplete="contact_for_promotionals" />
            <x-jet-input-error class="mt-2"
                for="contact_for_promotionals" />
        </div>

        {{-- on_vacation --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="on_vacation"
                value="{{ __('On Vacation') }}" />
            <input class="rounded"
                id="on_vacation"
                type="checkbox"
                wire:model.defer="state.on_vacation"
                autocomplete="on_vacation" />
            <x-jet-input-error class="mt-2"
                for="on_vacation" />
        </div>

        <div class="col-span-6 mt-4 sm:col-span-4">
            <p>Bank Information</p>
            <div class="mx-auto mt-2 w-2/3 border border-gray-300">
            </div>
        </div>

        {{-- Account name --}}
        <x-user-text-input name="account_name"
            type="text"
            id="account_name"
            label="Account name"
            wire:model.defer="state.account_name"
            autocomplete="account_name" />

        {{-- Account Number --}}
        <x-user-text-input name="account_number"
            type="text"
            id="account_number"
            label="Account Number"
            wire:model.state="state.account_number"
            autocomplete="account_number" />

        {{-- Routing Number --}}
        <x-user-text-input name="routing_number"
            type="text"
            label="Routing Number"
            model="state.routing_number"
            autocomplete="routing_number" />
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3"
            on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        {{-- <x-jet-button wire:loading.attr="disabled"
            wire:target="photo">
            {{ __('Save') }}
        </x-jet-button> --}}

        <a href="{{ route('therapist.update', ['id' => $this->id]) }}"
            type="submit"
            class="w-40 p-2 m-2 text-center transition-all duration-200 ease-in bg-blue-200 rounded-md shadow-md shadow-blue-100 hover:bg-blue-400"
            wire:loading.attr="disabled"
            wire:target="photo"
        >
            Save
        </a>

    </x-slot>
</x-jet-form-section>

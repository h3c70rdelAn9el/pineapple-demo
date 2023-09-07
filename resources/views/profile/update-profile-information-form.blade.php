@php
    // TODO:  IS THIS OKAY?
    $timeZonesJson = file_get_contents(resource_path('json/time_zones.json'));

    $timeZones = json_decode($timeZonesJson, true);
@endphp

<x-jet-form-section submit="updateProfileInformation">
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

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name"
                value="{{ __('Name') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="name"
                type="text"
                wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error class="mt-2"
                for="name" />
        </div>

        {{-- preferred name --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="preferred_name"
                value="{{ __('Preferred name') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="preferred_name"
                type="text"
                wire:model.defer="state.preferred_name"
                autocomplete="preferred_name" />
            <x-jet-input-error class="mt-2"
                for="preferred_name" />
        </div>

        {{-- gender --}}
        <div class="col-span-6 mt-0 sm:col-span-4">
            <x-multi-select id="gender"
                name="gender"
                value="{{ $this->user->gender }}"
                label="Gender"
                :options="['Male', 'Female', 'Non-binary', 'Prefer Not To Say']"></x-multi-select>
        </div>

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
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="license"
                value="{{ __('License') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="license"
                type="text"
                wire:model.defer="state.license"
                autocomplete="license" />
            <x-jet-input-error class="mt-2"
                for="license" />
        </div>

        {{-- Expires at --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="expires_at"
                value="{{ __('Expires at') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="expires_at"
                type="date"
                wire:model.defer="state.expires_at"
                autocomplete="expires_at" />
            <x-jet-input-error class="mt-2"
                for="expires_at" />
        </div>

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
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="supervisor_name"
                value="{{ __('Supervisor name') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="supervisor_name"
                type="text"
                wire:model.defer="state.supervisor_name"
                autocomplete="supervisor_name" />
            <x-jet-input-error class="mt-2"
                for="supervisor_name" />
        </div>

        {{-- street address --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="street_address"
                value="{{ __('Street address') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="street_address"
                type="text"
                wire:model.defer="state.street_address"
                autocomplete="street_address" />
            <x-jet-input-error class="mt-2"
                for="street_address" />
        </div>

        {{-- county/town --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="county_town"
                value="{{ __('County/Town') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="county_town"
                type="text"
                wire:model.defer="state.county_town"
                autocomplete="county_town" />
            <x-jet-input-error class="mt-2"
                for="county_town" />
        </div>

        {{-- state --}}
        {{-- TODO: add the state options --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="state"
                value="{{ __('State') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="state"
                type="text"
                wire:model.defer="state.state"
                autocomplete="state" />
            <x-jet-input-error class="mt-2"
                for="state" />
        </div>

        {{-- zip code --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="zip_code_postal_code"
                value="{{ __('Zip code/Postal code') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="zip_code_postal_code"
                type="text"
                wire:model.defer="state.zip_code_postal_code"
                autocomplete="zip_code_postal_code" />
            <x-jet-input-error class="mt-2"
                for="zip_code" />
        </div>

        {{-- country --}}
        {{-- TODO: ADD COUNTRY --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="country"
                value="{{ __('Country') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="country"
                type="text"
                wire:model.defer="state.country"
                autocomplete="country" />
            <x-jet-input-error class="mt-2"
                for="country" />
        </div>

        {{-- time_zone --}}
        {{-- TODO: ADD A DROPDOWN FOR TIMEZONES --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-single-select id="time_zone"
                name="time_zone"
                label="Time Zone"
                :options="$timeZones"></x-single-select>
        </div>

        {{-- IBAN/Swift Code --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="iban_swift_code"
                value="{{ __('IBAN/Swift Code') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="iban_swift_code"
                type="text"
                wire:model.defer="state.iban_swift_code"
                autocomplete="iban_swift_code" />
            <x-jet-input-error class="mt-2"
                for="iban_swift_code" />
        </div>

        {{-- Out of State coaching --}}
        {{-- amke a sleect input three options: yes/no/yes not usa --}}

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
        <div class="col-span-6 mt-1 sm:col-span-4">
            <x-jet-label for="account_name"
                value="{{ __('Account name') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="account_name"
                type="text"
                wire:model.defer="state.account_name"
                autocomplete="account_name" />
            <x-jet-input-error class="mt-2"
                for="account_name" />
        </div>

        {{-- Account Number --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="account_number"
                value="{{ __('Account Number') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="account_number"
                type="text"
                wire:model.defer="state.account_number"
                autocomplete="account_number" />
            <x-jet-input-error class="mt-2"
                for="account_number" />
        </div>

        {{-- Routing Number --}}
        <div class="col-span-6 mt-4 sm:col-span-4">
            <x-jet-label for="routing_number"
                value="{{ __('Routing Number') }}" />
            <x-jet-input class="mt-1 block w-full"
                id="routing_number"
                type="text"
                wire:model.defer="state.routing_number"
                autocomplete="routing_number" />
            <x-jet-input-error class="mt-2"
                for="routing_number" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3"
            on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled"
            wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

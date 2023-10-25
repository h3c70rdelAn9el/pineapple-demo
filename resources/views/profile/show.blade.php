@php
    $therapist = $user->therapist;
    $id = $user->id;
    $contact_for_promotionals = $user->contact_for_promotionals;
    // $user = $therapist;

    //
    // $therapist = Therapist::findOrFail($id);

@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @if (session('alert'))
        <div class="alert alert-{{ session('alert') }} alert-dismissible fade show"
            role="alert"
            x-data="{ show: true }"
            x-show="show">
            <div class="mx-auto flex w-1/2 justify-between rounded-md p-2 shadow-md">
                <p>{{ session('message') }}</p>
                <button>
                    <svg class="h-6 w-6 text-red-600 hover:text-red-800"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        @click="show = false">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div>
        <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
            {{-- @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form', ['user' => $user])
            <x-jet-section-border />
            @endif --}}

            {{-- @livewire('profile.update-profile-information.form', ['user' => $user]) --}}



            {{-- tried another form --}}
            {{-- <x-profile-update-form
                :user="$user"
                :therapist="$therapist"
                :id="$id"
            /> --}}

            <x-profile-update-form
                :user="$user"
                :therapist="$therapist"
                :id="$id"
            />



            <x-file-upload :user="$user" :therapist="$therapist" />

            <x-jet-section-border />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>
                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>

    </div>
</x-app-layout>

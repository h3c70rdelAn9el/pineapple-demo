<x-app-layout>
    <div x-data="{
        showAllTherapists: true,
        showInactiveTherapists: false,
        showIncompleteTherapists: false,
        showUnverifiedTherapists: false
    }">
        <div>
            <h2 class="text-center text-2xl">Therapists</h2>
        </div>
        <div class="container mx-auto mt-4 flex flex-row justify-between px-4 md:w-2/3 md:flex-row">
            <div class="mx-auto w-full">
                <button
                    x-on:click="showAllTherapists = true, showInactiveTherapists = false, showIncompleteTherapists = false"
                    class="mx-auto flex w-1/2 flex-row gap-2">
                    <div
                        class="flex w-full flex-row justify-between gap-2 text-blue-600 transition-all duration-200 ease-in-out hover:text-blue-800">
                        <p>All Therapists:</p>
                        <p>{{ $therapists->total() }}</p>
                    </div>
                </button>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showInactiveTherapists = true, showAllTherapists = false, showIncompleteTherapists = false"
                        class="mx-auto w-1/2">
                        <div
                            class="flex flex-row justify-between gap-2 text-slate-500 transition-all duration-200 ease-in-out hover:text-slate-700">
                            <p>Inactive Therapists:</p>
                            <p>{{ $inactiveTherapists->count() }}</p>
                        </div>
                    </button>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showIncompleteTherapists = true, showAllTherapists = false, showInactiveTherapists = false"
                        class="mx-auto w-1/2 justify-between">
                        <div
                            class="flex flex-row justify-between gap-2 text-red-500 transition-all duration-200 ease-in-out hover:text-orange-700">
                            <p>Incomplete Therapists:</p>
                            <p>{{ $incompleteTherapistsCount }}</p>
                        </div>
                    </button>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showUnverifiedTherapists = true, showAllTherapists = false, showInactiveTherapists = false"
                        class="mx-auto w-1/2 justify-between">
                        <div
                            class="flex flex-row justify-between gap-2 text-yellow-600 transition-all duration-200 ease-in-out hover:text-yellow-700">
                            <p>Unverified Therapists:</p>
                            <p>{{ $unverifiedTherapistCount }}</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-row justify-center">
            <x-container-content>
                <x-slot name="title"></x-slot>
                <x-slot name="count"></x-slot>

                <x-slot name="content">
                    <div class="flex w-full justify-center">
                        <div class="flex flex-wrap justify-center" x-show="showAllTherapists" x-cloak>
                            @foreach ($therapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div>
                                {{ $therapists->links() }}
                            </div>
                        </div>

                        <div class="flex w-full flex-wrap justify-center" x-show="showInactiveTherapists" x-cloak>
                            @foreach ($inactiveTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div>
                                {{ $inactiveTherapists->links() }}
                            </div>
                        </div>
                        <div class="flex w-full flex-wrap justify-center" x-show="showIncompleteTherapists" x-cloak>
                            @foreach ($incompleteTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                        </div>
                        <div class="flex w-full flex-wrap justify-center" x-show="showUnverifiedTherapists" x-cloak>
                            @foreach ($unverifiedTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                        </div>
                    </div>
                </x-slot>
            </x-container-content>
        </div>
    </div>
</x-app-layout>

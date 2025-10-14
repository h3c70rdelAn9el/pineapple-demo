<x-app-layout>
    <div x-data="{
        showAllTherapists: true,
        showInactiveTherapists: false,
        showIncompleteTherapists: false,
        showUnverifiedTherapists: false,
        showActiveTherapists: false,
        showCompleteTherapists: false
    }">
        <div>
            <h2 class="text-2xl text-center">Therapists</h2>
        </div>
        <div class="container flex flex-row justify-between px-4 mx-auto mt-4 md:w-2/3 md:flex-row">
            <div class="w-full mx-auto">
                <button
                    x-on:click="showAllTherapists = true, showInactiveTherapists = false, showIncompleteTherapists = false, showUnverifiedTherapists = false, showActiveTherapists = false, showCompleteTherapists = false"
                    class="flex flex-row w-1/2 gap-2 mx-auto">
                    <div
                        class="flex flex-row justify-between w-full gap-2 text-blue-600 transition-all duration-200 ease-in-out hover:text-blue-800">
                        <p>All Therapists:</p>
                        <p>{{ $therapists->total() }}</p>
                    </div>
                </button>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showActiveTherapists = true, showInactiveTherapists = false, showAllTherapists = false, showIncompleteTherapists = false, showUnverifiedTherapists = false, showCompleteTherapists = false"
                        class="w-1/2 mx-auto">
                        <div
                            class="flex flex-row justify-between gap-2 text-green-500 transition-all duration-200 ease-in-out hover:text-green-700">
                            <p>Active Therapists:</p>
                            <p>{{ $activeTherapists->total() }}</p>
                        </div>
                    </button>
                </div>
                
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showInactiveTherapists = true, showAllTherapists = false, showIncompleteTherapists = false, showUnverifiedTherapists = false, showActiveTherapists = false, showCompleteTherapists = false"
                        class="w-1/2 mx-auto">
                        <div
                            class="flex flex-row justify-between gap-2 transition-all duration-200 ease-in-out text-slate-500 hover:text-slate-700">
                            <p>Inactive Therapists:</p>
                            <p>{{ $inactiveTherapists->total() }}</p>
                        </div>
                    </button>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showIncompleteTherapists = true, showAllTherapists = false, showInactiveTherapists = false, showUnverifiedTherapists = false, showActiveTherapists = false, showCompleteTherapists = false"
                        class="justify-between w-1/2 mx-auto">
                        <div
                            class="flex flex-row justify-between gap-2 text-red-500 transition-all duration-200 ease-in-out hover:text-orange-700">
                            <p>Incomplete Therapists:</p>
                            <p>{{ $incompleteTherapists->total() }}</p>
                        </div>
                    </button>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showUnverifiedTherapists = true, showAllTherapists = false, showInactiveTherapists = false, showIncompleteTherapists = false, showActiveTherapists = false, showCompleteTherapists = false"
                        class="justify-between w-1/2 mx-auto">
                        <div
                            class="flex flex-row justify-between gap-2 text-yellow-600 transition-all duration-200 ease-in-out hover:text-yellow-700">
                            <p>Unverified Therapists:</p>
                            <p>{{ $unverifiedTherapists->total() }}</p>
                        </div>
                    </button>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showCompleteTherapists = true, showAllTherapists = false, showInactiveTherapists = false, showIncompleteTherapists = false, showActiveTherapists = false, showUnverifiedTherapists = false"
                        class="justify-between w-1/2 mx-auto">
                        <div
                            class="flex flex-row justify-between gap-2 text-green-600 transition-all duration-200 ease-in-out hover:text-green-700">
                            <p>Complete Therapists:</p>
                            <p>{{ $completeTherapists->total() }}</p>
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
                    <div class="flex justify-center w-full">
                        <div class="flex flex-wrap justify-center" x-show="showAllTherapists" x-cloak>
                            @foreach ($therapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded ||
                                    !$therapist->bio_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div class="w-full">
                                {{ $therapists->appends(request()->except('all_therapists'))->links() }}
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center w-full" x-show="showActiveTherapists" x-cloak>
                            @foreach ($activeTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded ||
                                    !$therapist->bio_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div class="w-full">
                                {{ $activeTherapists->appends(request()->except('active_therapists'))->links() }}
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center w-full" x-show="showInactiveTherapists" x-cloak>
                            @foreach ($inactiveTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded ||
                                    !$therapist->bio_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div class="w-full">
                                {{ $inactiveTherapists->appends(request()->except('inactive_therapists'))->links() }}
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center w-full" x-show="showIncompleteTherapists" x-cloak>
                            @foreach ($incompleteTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded ||
                                    !$therapist->bio_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div class="w-full">
                                {{ $incompleteTherapists->appends(request()->except('incomplete_therapists'))->links() }}
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center w-full" x-show="showUnverifiedTherapists" x-cloak>
                            @foreach ($unverifiedTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded ||
                                    !$therapist->bio_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div class="w-full">
                                {{ $unverifiedTherapists->appends(request()->except('unverified_therapists'))->links() }}
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center w-full" x-show="showCompleteTherapists" x-cloak>
                            @foreach ($completeTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                    !$therapist->W9_or_WBEN_uploaded ||
                                    !$therapist->license_uploaded ||
                                    !$therapist->insurance_uploaded ||
                                    !$therapist->headshot_uploaded ||
                                    !$therapist->bio_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                </x-therapists-card>
                            @endforeach
                            <div class="w-full">
                                {{ $completeTherapists->appends(request()->except('complete_therapists'))->links() }}
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-container-content>
        </div>
    </div>
</x-app-layout>

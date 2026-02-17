<x-app-layout>
    <div x-data="{
        showAllTherapists: {{ request('flag_filter') ? 'false' : 'true' }},
        showInactiveTherapists: false,
        showIncompleteTherapists: false,
        showUnverifiedTherapists: false,
        showActiveTherapists: false,
        showCompleteTherapists: false,
        showFlagFilteredTherapists: {{ request('flag_filter') ? 'true' : 'false' }}
    }">
        <div>
            <h2 class="text-2xl text-center">Therapists</h2>
        </div>
        
        <!-- Flag Filter Section -->
        <div class="container px-4 mx-auto mt-4 md:w-2/3">
            <div class="p-4 mb-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <h3 class="mb-3 text-lg font-semibold text-gray-800 dark:text-gray-200">Filter by Flag</h3>
                <form method="GET" action="{{ route('therapists.index') }}" class="flex flex-col gap-3 md:flex-row md:items-end">
                    <div class="flex-1">
                        <label for="flag_filter" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Select Flag:</label>
                        <select 
                            name="flag_filter" 
                            id="flag_filter" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">-- Choose a flag --</option>
                            <option value="out_of_state_coaching" {{ request('flag_filter') === 'out_of_state_coaching' ? 'selected' : '' }}>Out of State Coaching</option>
                            <option value="contact_for_promotionals" {{ request('flag_filter') === 'contact_for_promotionals' ? 'selected' : '' }}>Contact for Promotionals</option>
                            <option value="intern" {{ request('flag_filter') === 'intern' ? 'selected' : '' }}>Intern</option>
                            <option value="full" {{ request('flag_filter') === 'full' ? 'selected' : '' }}>Full</option>
                            <option value="on_vacation" {{ request('flag_filter') === 'on_vacation' ? 'selected' : '' }}>On Vacation</option>
                            <option value="contract_signed" {{ request('flag_filter') === 'contract_signed' ? 'selected' : '' }}>Contract Signed</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button 
                            type="submit" 
                            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Apply Filter
                        </button>
                        @if(request('flag_filter'))
                            <a 
                                href="{{ route('therapists.index') }}" 
                                class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500"
                            >
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        
        <div class="container flex flex-row justify-between px-4 mx-auto mt-4 md:w-2/3 md:flex-row">
            <div class="w-full mx-auto">
                <button
                    x-on:click="showAllTherapists = true, showInactiveTherapists = false, showIncompleteTherapists = false, showUnverifiedTherapists = false, showActiveTherapists = false, showCompleteTherapists = false, showFlagFilteredTherapists = false"
                    class="flex flex-row w-1/2 gap-2 mx-auto">
                    <div
                        class="flex flex-row justify-between w-full gap-2 text-blue-600 transition-all duration-200 ease-in-out hover:text-blue-800">
                        <p>All Therapists:</p>
                        <p>{{ $therapists->total() }}</p>
                    </div>
                </button>
                
                @if(request('flag_filter') && $flagFilteredTherapists->count() > 0)
                    <button
                        x-on:click="showFlagFilteredTherapists = true, showAllTherapists = false, showInactiveTherapists = false, showIncompleteTherapists = false, showUnverifiedTherapists = false, showActiveTherapists = false, showCompleteTherapists = false"
                        class="flex flex-row w-1/2 gap-2 mx-auto">
                        <div
                            class="flex flex-row justify-between w-full gap-2 text-purple-600 transition-all duration-200 ease-in-out hover:text-purple-800">
                            <p>{{ ucwords(str_replace('_', ' ', request('flag_filter'))) }}:</p>
                            <p>{{ $flagFilteredTherapists->total() }}</p>
                        </div>
                    </button>
                @endif
                
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showActiveTherapists = true, showInactiveTherapists = false, showAllTherapists = false, showIncompleteTherapists = false, showUnverifiedTherapists = false, showCompleteTherapists = false, showFlagFilteredTherapists = false"
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
                        x-on:click="showInactiveTherapists = true, showAllTherapists = false, showIncompleteTherapists = false, showUnverifiedTherapists = false, showActiveTherapists = false, showCompleteTherapists = false, showFlagFilteredTherapists = false"
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
                        x-on:click="showIncompleteTherapists = true, showAllTherapists = false, showInactiveTherapists = false, showUnverifiedTherapists = false, showActiveTherapists = false, showCompleteTherapists = false, showFlagFilteredTherapists = false"
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
                        x-on:click="showUnverifiedTherapists = true, showAllTherapists = false, showInactiveTherapists = false, showIncompleteTherapists = false, showActiveTherapists = false, showCompleteTherapists = false, showFlagFilteredTherapists = false"
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
                        x-on:click="showCompleteTherapists = true, showAllTherapists = false, showInactiveTherapists = false, showIncompleteTherapists = false, showActiveTherapists = false, showUnverifiedTherapists = false, showFlagFilteredTherapists = false"
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
                        
                        @if(request('flag_filter') && $flagFilteredTherapists->count() > 0)
                            <div class="flex flex-wrap justify-center w-full" x-show="showFlagFilteredTherapists" x-cloak>
                                <div class="w-full mb-4">
                                    <p class="text-lg font-semibold text-center text-purple-700">
                                        Showing therapists with: {{ ucwords(str_replace('_', ' ', request('flag_filter'))) }}
                                    </p>
                                </div>
                                @foreach ($flagFilteredTherapists as $therapist)
                                    <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                        !$therapist->W9_or_WBEN_uploaded ||
                                        !$therapist->license_uploaded ||
                                        !$therapist->insurance_uploaded ||
                                        !$therapist->headshot_uploaded ||
                                        !$therapist->bio_uploaded" :unverifiedTherapist="!$therapist->all_documents || !$therapist->contract_signed">
                                    </x-therapists-card>
                                @endforeach
                                <div class="w-full">
                                    {{ $flagFilteredTherapists->appends(['flag_filter' => request('flag_filter')])->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </x-slot>
            </x-container-content>
        </div>
    </div>
</x-app-layout>

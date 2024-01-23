<x-app-layout>
    <div x-data="{
        showAllTherapists: true,
        showInactiveTherapists: false,
        showIncompleteTherapists: false,
    }">
        <div>
            <h2 class="text-center text-2xl">Therapists</h2>
        </div>
        <div class="container mx-auto mt-4 flex flex-row justify-between px-4 md:w-2/3 md:flex-row">
            <div class="mx-auto w-full md:w-1/2">
                <button
                    x-on:click="showAllTherapists = true, showInactiveTherapists = false, showIncompleteTherapists = false"
                    class="flex flex-row gap-2">
                    <div class="flex flex-row gap-2 transition-all duration-200 ease-in-out hover:text-blue-800">
                        <p>All Therapists:</p>
                        <p>{{ $therapists->total() }}</p>
                    </div>
                </button>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showInactiveTherapists = true, showAllTherapists = false, showIncompleteTherapists = false">
                        <div
                            class="flex w-full flex-row gap-2 text-red-500 transition-all duration-200 ease-in-out hover:text-orange-700">
                            <p>Inactive Therapists:</p>
                            <p>{{ $inactiveTherapistsCount }}</p>
                        </div>
                    </button>
                </div>
                <div class="flex flex-row gap-2">
                    <button
                        x-on:click="showIncompleteTherapists = true, showAllTherapists = false, showInactiveTherapists = false">
                        <div
                            class="flex w-full flex-row gap-2 text-red-500 transition-all duration-200 ease-in-out hover:text-orange-700">
                            <p>Incomplete Therapists:</p>
                            <p>{{ $incompleteTherapists->count() }}</p>
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
                        <div class="flex flex-wrap justify-center" x-show="showAllTherapists">
                            @foreach ($therapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapist="$incompleteTherapist" :incompleteTherapists="$incompleteTherapists"
                                    :therapists="$therapists" />
                            @endforeach
                            <div>
                                {{ $therapists->links() }}
                            </div>
                        </div>

                        <div class="flex w-full flex-wrap justify-center" x-show="showInactiveTherapists">
                            @foreach ($inactiveTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :inactiveTherapist="$inactiveTherapist" :incompleteTherapist="$incompleteTherapist"
                                    :incompleteTherapists="$incompleteTherapists" />
                            @endforeach
                            <div>
                                {{ $inactiveTherapists->links() }}
                            </div>
                        </div>
                        <div class="flex w-full flex-wrap justify-center" x-show="showIncompleteTherapists">

                            @foreach ($incompleteTherapists as $therapist)
                                <x-therapists-card :therapist="$therapist" :incompleteTherapists="$incompleteTherapists" />
                            @endforeach
                        </div>
                    </div>
                </x-slot>
            </x-container-content>
        </div>
    </div>
</x-app-layout>

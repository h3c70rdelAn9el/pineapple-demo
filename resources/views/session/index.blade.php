<x-app-layout>
    <div x-data="{ showAllSessions: true, showMissedSessions: false, showSpecialSessions: false }">
        <div>
            <h2 class="text-center text-2xl">Sessions</h2>
        </div>
        <div class="container mx-auto flex flex-row justify-between px-4 md:w-2/3 md:flex-row">
            <div class="mx-auto w-2/3">
                <button x-on:click="showAllSessions = true, showMissedSessions = false, showSpecialSessions = false"
                    :class="{ 'font-semibold': showAllSessions }" class="flex w-full flex-row gap-2">
                    <div class="flex w-full flex-row justify-between gap-2 transition-all duration-200 ease-in-out hover:text-blue-800">
                        <p>All Sessions:</p>
                        <p>{{ $therapySessions->count() }}</p>
                    </div>
                </button>

                <div class="flex flex-row gap-2">
                    <button x-on:click="showAllSessions = false, showMissedSessions = true, showSpecialSessions = false"
                        :class="{ 'font-semibold': showMissedSessions }" class="w-full">
                        <div class="flex w-full flex-row justify-between gap-2 text-orange-500 transition-all duration-200 ease-in-out hover:text-orange-700">
                            <p>Missed Sessions:</p>
                            <p>{{ $missedSessions->count() }}</p>
                        </div>
                    </button>
                </div>

                <div class="flex flex-row justify-between gap-2">
                    <button x-on:click="showAllSessions = false, showMissedSessions = false, showSpecialSessions = true"
                        :class="{ 'font-semibold': showSpecialSessions }" class="flex w-full flex-row justify-between">
                        <div class="flex w-full flex-row justify-between gap-2 text-purple-500 transition-all duration-200 ease-in-out hover:text-purple-700">
                            <p>Special Sessions</p>
                            <p>{{ $specialSessions->count() }}</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <section x-show="showAllSessions">
            <x-session-table :sessions="$therapySessions" :therapySessions="$therapySessions" />
        </section>

        <section x-show="showMissedSessions">
            <x-session-table :sessions="$missedSessions" :therapySessions="$missedSessions" />
        </section>

        <section x-show="showSpecialSessions">
            <x-session-table :sessions="$specialSessions" :therapySessions="$specialSessions" />
        </section>
    </div>
</x-app-layout>

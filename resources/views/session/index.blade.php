<x-app-layout>
    <div x-data="{
        showAllSessions: true,
        showMissedSessions: false,
        showSpecialSessions: false,
    }" x-init="showAllSessions = {{ json_encode(request('tab') !== 'inactive') }};
    showMissedSessions = {{ json_encode(request('tab') === 'inactive') }};
    showSpecialSessions = {{ json_encode(request('tab') === 'inactive') }}">
        <div>
            <h2 class="text-center text-2xl">Sessions</h2>
        </div>
        <div class="container mx-auto flex flex-row justify-between px-4 md:w-2/3 md:flex-row">
            <div class="mx-auto w-2/3">
                <button x-on:click="showAllSessions = true, showMissedSessions = false, showSpecialSessions = false,"
                    class="flex w-full flex-row gap-2">
                    <div
                        class="flex w-full flex-row justify-between gap-2 transition-all duration-200 ease-in-out hover:text-blue-800">
                        <p>All Sessions:</p>
                        <p>{{ $therapySessions->count() }}</p>
                    </div>
                </button>

                <div class="flex flex-row gap-2">
                    <button x-on:click="showMissedSessions = true, showAllSessions = false, showSpecialSessions = false"
                        class="w-full">
                        <div
                            class="flex w-full flex-row justify-between gap-2 text-orange-500 transition-all duration-200 ease-in-out hover:text-orange-700">
                            <p>Missed Sessions:</p>
                            <p>{{ $missedSessions->count() }}</p>
                        </div>
                    </button>
                </div>



                <div class="flex flex-row justify-between gap-2">

                    <button x-on:click="showSpecialSessions = true, showAllSessions = false, showMissedSessions = false"
                        class="flex w-full flex-row justify-between">
                        <div
                            class="flex w-full flex-row justify-between gap-2 text-purple-500 transition-all duration-200 ease-in-out hover:text-purple-700">
                            <p>Special Sessions</p>
                            <p>{{ $specialSessions->count() }}</p>
                        </div>
                    </button>
                </div>

            </div>
            {{-- <div>
                <button class="button-secondary mt-4">
                    <a class="text-sm" href="{{ route('clients.create') }}">
                        Add Client
                    </a>
                </button>
            </div> --}}
        </div>

        <section x-show="showAllSessions">
            <x-session-table :sessions="$therapySessions"  :missedSessions="$missedSessions" :specialSessions="$specialSessions" :client="$client" :clients="$clients" :therapySession="$therapySession" :therapySessions="$therapySessions" />
        </section>
{{--
        <section x-show="showInactiveClients">
            <x-client-table :clients="$inactiveClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />

        </section>

        <section x-show="showWaitlistClients">
            <x-client-table :clients="$waitlistClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />
        </section>

        <section x-show="showSpecialSessionsClients">
            <x-client-table :clients="$specialSessionsClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />
        </section> --}}
    </div>
</x-app-layout>

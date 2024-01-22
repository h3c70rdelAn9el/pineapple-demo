@php
    // $totalClients = $clients->count();
    // how do  i pull in teh waitlist count?
    $waitlistCount = $waitlistClients->total();
    $totalClients = $clients->count() + $inactiveClients->count() + $waitlistClients->count() + $specialSessionsClients->count();
    $specialSessionsClientsCount = $specialSessionsClients->count();

    // $waitlistCount = $clients->where('waitlist', 1)->count();

@endphp

<x-app-layout>
    <div x-data="{
        showAllClients: true,
        showInactiveClients: false,
        showWaitlistClients: false,
        showSpecialSessionsClients: false,
    }" x-init="showAllClients = {{ json_encode(request('tab') !== 'inactive') }};
    showInactiveClients = {{ json_encode(request('tab') === 'inactive') }};
    showWaitlistClients = false">
        <div>
            <h2 class="text-center text-2xl">Clients</h2>
        </div>
        <div class="container mx-auto flex flex-row justify-between px-4 md:w-2/3 md:flex-row">
            <div class="w-full md:w-1/2">

                <button
                    x-on:click="showAllClients = true, showInactiveClients = false, showWaitlistClients = false, showSpecialSessionsClients = false"
                    class="flex flex-row gap-2">
                    <div class="flex flex-row gap-2 transition-all duration-200 ease-in-out hover:text-blue-800">
                        <p>All Clients:</p>
                        <p>{{ $clients->total() }}</p>
                        <p x-text="allClientsCount"></p>
                    </div>
                </button>
                <div class="flex flex-row gap-2">

                    <button
                        x-on:click="showInactiveClients = true, showAllClients = false, showWaitlistClients = false, showSpecialSessionsClients = false">
                        <div
                            class="flex w-full flex-row gap-2 text-orange-500 transition-all duration-200 ease-in-out hover:text-orange-700">
                            <p>Inactive Clients:</p>
                            <p>{{ $inactiveClientsCount }}</p>
                        </div>
                    </button>
                </div>
                <button
                    x-on:click="showWaitlistClients = true, showAllClients = false, showInactiveClients = false, showSpecialSessionsClients = false">
                    <div
                        class="flex flex-row gap-2 text-blue-500 transition-all duration-200 ease-in-out hover:text-blue-700">
                        <p>Waitlisted</p>
                        <p>{{ $waitlistCount }}</p>
                    </div>
                </button>

                <div class="flex flex-row gap-2">

                    <button
                        x-on:click="showSpecialSessionsClients = true, showAllClients = false, showInactiveClients = false, showWaitlistClients = false">
                        <div
                            class="flex flex-row gap-2 text-purple-500 transition-all duration-200 ease-in-out hover:text-purple-700">
                            <p>Special Sessions</p>
                            <p>{{ $specialSessionsClientsCount }}</p>
                        </div>
                    </button>
                </div>

            </div>
            <div>
                <button class="button-secondary mt-4">
                    <a class="text-sm" href="{{ route('clients.create') }}">
                        Add Client
                    </a>
                </button>
            </div>
        </div>

        <section x-show="showAllClients">
            <x-client-table :clients="$clients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />
        </section>

        <section x-show="showInactiveClients">
            <x-client-table :clients="$inactiveClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />

        </section>

        <section x-show="showWaitlistClients">
            <x-client-table :clients="$waitlistClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />
        </section>

        <section x-show="showSpecialSessionsClients">
            <x-client-table :clients="$specialSessionsClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />
        </section>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

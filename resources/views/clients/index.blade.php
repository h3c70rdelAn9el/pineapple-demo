@php
    $totalClients = $clients->count();
    // how do  i pull in teh waitlist count?
        $waitlistCount = $waitlistClients->total();


    // $waitlistCount = $clients->where('waitlist', 1)->count();

@endphp

<x-app-layout>
    <div x-data="{
        showAllClients: true,
        showInactiveClients: false,
        showWaitlistClients: false
    }">
        <div>
            <h2 class="text-center text-2xl">Clients</h2>
        </div>
        <div class="container mx-auto flex flex-row justify-between px-4 md:w-2/3 md:flex-row">
            <div class="w-full md:w-1/2">

<button x-on:click="showAllClients = true, showInactiveClients = false, showWaitlistClients = false; updateCounts()">
                    <div class="flex flex-row gap-2">
                        <p>All Clients:</p>
                        <p>{{ $clients->total() }}</p>
                        <p x-text="allClientsCount"></p>
                    </div>
                </button>
                <div class="flex flex-row gap-2">

                    <button x-on:click="showInactiveClients = true, showAllClients = false, showWaitlistClients = false">
                        <div class="flex w-full flex-row gap-2">
                            <p>Inactive Clients:</p>
                            <p>{{ $inactiveClientsCount }}</p>
                        </div>
                    </button>
                </div>
                <button x-on:click="showWaitlistClients = true, showAllClients = false, showInactiveClients = false, updateCounts()">
                    <div class="flex flex-row gap-2">
                        <p>Waitlisted</p>
                        <p>{{ $waitlistCount }}</p>
                    </div>
                </button>
            </div>
            <div>
                <button class="button-secondary mt-4">
                    <a
                        class="text-sm"
                        href="{{ route('clients.create') }}"
                    >
                        Add Client
                    </a>
                </button>
            </div>
        </div>
        <x-client-table :clients="$clients"
            :attendedSessions="$attendedSessions"
            :missedSessions="$missedSessions"
            :client="$client"
        />
    </div>
</x-app-layout>

<script
    src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
    defer
></script>

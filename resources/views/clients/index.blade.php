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
                        <div class="flex w-full flex-row gap-2 border border-purple-300">
                            <p>Inactive Clients:</p>
                            <p>{{ $inactiveClientsCount }}</p>
                        </div>
                    </button>
                </div>
                <button x-on:click="showWaitlistClients = true, showAllClients = false, showInactiveClients = false, updateCounts()">
                    <div class="flex flex-row gap-2">
                        <p>Waitlisted</p>
                        @php
                            // dd($waitlistClientsCount);
                        @endphp
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
        <section
            class="container mx-auto p-6"
            x-show="showAllClients"
        >
            @foreach ($clients as $client)
                <x-client-card
                    :client="$client"
                    :therapist="$therapist"
                    :user="$user"
                >
                </x-client-card>
            @endforeach
            {{-- add links --}}
            <div class="flex justify-center">
                {{ $clients->links() }}
                </div>
        </section>
        <section
            class="container mx-auto p-6"
            x-show="showInactiveClients"
        >
            @foreach ($inactiveClients as $client)
                <x-client-card
                    :client="$client"
                    :therapist="$therapist"
                    :user="$user"
                >
                </x-client-card>
            @endforeach
            {{-- add links --}}
            {{-- <div class="flex justify-center">
                {{ $clients->links() }}
                </div> --}}
        </section>
        <section
            class="container mx-auto p-6"
            x-show="showWaitlistClients"
        >
            @foreach ($waitlistClients as $client)
                <x-client-card
                    :client="$client"
                    :therapist="$therapist"
                    :user="$user"
                >
                </x-client-card>
            @endforeach
            {{-- add links --}}
            {{-- <div class="flex justify-center">
                        {{ $clients->links() }}
                        </div> --}}
        </section>
    </div>
</x-app-layout>

<script
    src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
    defer
></script>

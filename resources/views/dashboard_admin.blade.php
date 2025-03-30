<x-app-layout>
    <div x-data="{
        currentView: 'all',

    }">
        <div>
    @if (session('error'))
        <div class="w-1/2 p-4 m-4 mx-auto text-center text-white bg-red-500 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <x-success-message></x-success-message>
    @endif

    <div class="mt-2 ml-7 w-fit">
        <table class="w-full ml-4">
            <tbody class="text-sm">
                <tr>
                    <td>Total Sessions' Cost:</td>
                    <td><span class="ml-4 font-bold">{{ $totalSessionCost }}</span></td>
                </tr>
                <tr>
                    <td>Total Clients' Contribution:</td>
                    <td><span class="ml-4 font-bold text-blue-500">{{ $totalClientContribution }}</span></td>
                </tr>
                <?php
                $remainder = $totalSessionCost - $totalClientContribution;
                ?>
                <tr>
                    <td>Total:</td>
                    <td>
                        <span class="{{ $remainder < 0 ? 'text-red-500' : '' }} ml-4 font-bold">
                            {{ $remainder }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @if ($unreadMessagesCount > 0)
        <div
            class="flex flex-row items-center justify-center max-w-6xl px-4 py-1 mx-auto mt-2 font-medium transition duration-200 bg-blue-200 border border-blue-400 rounded-md ml-14 w-52 hover:bg-blue-500">
            <a href="/messages">
                <p class="text-center">Unread Messages:<span class="ml-2 font-bold">
                        {{ $unreadMessagesCount }}</span>
                </p>
            </a>
        </div>
    @endif

    <div class="relative grid w-full h-full max-w-6xl grid-cols-1 gap-3 p-4 mx-auto mt-3 rounded-md md:grid-cols-2">
        <section class="col-span-1">
            <x-container-content>
                <div class="w-full">
                    <x-slot name="title">
                        <div class="flex flex-col w-full text-base lg:w-1/2">
                            <div class="flex items-center justify-between font-bold">
                                <a href="{{ route('therapists.index') }}" class=""><button
                                        class="px-2 py-1 mb-1 transition duration-300 ease-in-out border-2 border-blue-300 rounded-md hover:bg-blue-400">Therapists:</button></a>
                                <p>{{ $therapists->total() }}</p>
                            </div>
                            <div class="flex justify-between text-blue-600">
                                <p><a href="#" id="active-link" class="hover:underline" x-on:click="currentView = 'active'">Active:</a></p>
                                <p>{{ $activeTherapists->count() }}</p>
                            </div>
                            <div class="flex justify-between text-slate-500">
                                <p><a href="#" id="inactive-link" class="hover:underline" x-on:click="currentView = 'inactive'">Inactive:</a></p>
                                <p>{{ $inactiveTherapists->count() }}</p>
                            </div>
                             <div class="flex justify-between text-red-600">
                                <p>Unverified Profiles:</p>
                                <p>{{ $unverifiedTherapistCount }}</p>
                            </div>
                            <div class="flex justify-between text-red-600">
                                <p>Incomplete Profiles:</p>
                                <p>{{ $incompleteTherapistsCount }}</p>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="count">
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-full h-60">
                            <div id="therapist-container" x-show="currentView === 'all'" x-cloak >
                                <div>
                                    {{ $therapists->links() }}
                                </div>
                                
                                <div class="overflow-y-auto h-96">
                                        @foreach ($therapists as $therapist)
                                            @include('components.therapists-card', ['therapist' => $therapist])
                                        @endforeach
                                    </div>
                                    <div>
                                        {{ $therapists->links() }}
                                    </div>
        
                                </div>
                                <div id="therapist-container" x-show="currentView === 'active'" x-cloak>
                                    <div>
                                        {{ $activeTherapists->links() }}
                                    </div>
        
                                    <div class="overflow-y-auto h-96">
                                        @foreach ($activeTherapists as $therapist)
                                            @include('components.therapists-card', ['therapist' => $therapist])
                                        @endforeach
                                    </div>
                                    <div>
                                        {{ $activeTherapists->links() }}
                                        </div>
                                </div>
                                <div id="therapist-container" x-show="currentView === 'inactive'" x-cloak>
                                    <div>
                                        {{ $inactiveTherapists->links() }}
                                    </div>
                                    <div class="overflow-y-auto h-96">
                                        @foreach ($inactiveTherapists as $therapist)
                                            @include('components.therapists-card', ['therapist' => $therapist])
                                        @endforeach
                                    </div>
                                    <div>
                                        {{ $inactiveTherapists->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </div>
            </x-container-content>
        </section>

        <section class="col-span-1">
            <x-container-content>
                <div class="w-full">
                    <x-slot name="title">
                        <div class="flex flex-col w-full text-base lg:w-1/2">
                            <div class="flex items-center justify-between font-bold">
                                <a href="{{ route('session.index') }}" class="">
                                    <button
                                        class="px-2 py-1 mb-1 transition duration-300 ease-in-out border-2 border-blue-300 rounded-md hover:bg-blue-400">Therapy
                                        Sessions:
                                    </button>
                                </a>
                                <p>{{ $allTherapySessions->total() }}</p>
                            </div>
                            <div class="flex justify-between text-red-500">
                                <p>Missed:</p>
                                <p>{{ $allMissedSessions->total() }}</p>
                            </div>
                            <div class="flex justify-between text-purple-500">
                                <p>Special::</p>
                                <p class="">{{ $allSpecialSessions->total() }}</p>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="count">
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-full h-60">
                            <p>Latest 10 Sessions:</p>
                            <div class="overflow-y-auto h-96">
                                @foreach ($allTherapySessions->take(10) as $ts)
                                    <x-session-card :therapySession="$ts">
                                    </x-session-card>
                                @endforeach
                            </div>
                        </div>
                    </x-slot>
                </div>
            </x-container-content>
        </section>


        <section class="col-span-1 md:col-span-2">
            {{-- TODO: only display the latest 10 clients that have had  with the latest therapy sessions --}}
            <x-container-content>
                <x-slot name="title">
                    <div class="flex flex-col w-1/3 mt-4 text-base">
                        <div class="flex justify-between font-bold">
                            <button
                                class="px-2 py-1 mb-1 transition duration-300 ease-in-out border-2 border-blue-300 rounded-md hover:bg-blue-400">
                                <a href="{{ route('clients.index') }}">
                                    <p>Clients</p>
                                </a>
                            </button>
                        </div>
                    </div>

                </x-slot>
                <x-slot name="count">
                    <button class="mt-4 button-secondary">
                        <a class="text-sm" href="{{ route('clients.create') }}">
                            Add Client
                        </a>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <p class="inline-block min-w-full py-2 sm:px-6 lg:px-8">Latest Active Clients</p>
                    <x-client-table :clients="$recentActiveClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />
                </x-slot>
            </x-container-content>
        </section>
    </div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>

<script>
    function navigateToClients(tab) {
        window.location.href = "{{ route('clients.index', ['status' => '']) }}/" + tab;
    }

    // Update the currentTab based on the URL parameter
    let urlParams = new URLSearchParams(window.location.search);
    let currentTab = urlParams.get('status') || 'all';

    let app = {
        currentTab: currentTab,
        updateTab(tab) {
            this.currentTab = tab;
        }
    };
</script>

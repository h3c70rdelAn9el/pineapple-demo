<x-app-layout>
    @if (session('error'))
        <div class="m-4 mx-auto w-1/2 rounded-md bg-red-500 p-4 text-center text-white shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <x-success-message></x-success-message>
    @endif

    <div class="ml-7 mt-2 w-fit">
        <table class="ml-4 w-full">
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
            class="mx-auto ml-14 mt-2 flex w-52 max-w-6xl flex-row items-center justify-center rounded-md border border-blue-400 bg-blue-200 px-4 py-1 font-medium transition duration-200 hover:bg-blue-500">
            <a href="/messages">
                <p class="text-center">Unread Messages:<span class="ml-2 font-bold">
                        {{ $unreadMessagesCount }}</span>
                </p>
            </a>
        </div>
    @endif

    <div class="relative mx-auto mt-3 grid h-full w-full max-w-6xl grid-cols-1 gap-3 rounded-md p-4 md:grid-cols-2">
        <section class="col-span-1">
            <x-container-content>
                <div class="w-full">
                    <x-slot name="title">
                        <div class="flex w-full flex-col text-base lg:w-1/2">
                            <div class="flex items-center justify-between font-bold">
                                <a href="{{ route('therapists.index') }}" class=""><button
                                        class="mb-1 rounded-md border-2 border-blue-300 px-2 py-1 transition duration-300 ease-in-out hover:bg-blue-400">Therapists:</button></a>
                                <p>{{ $therapists->total() }}</p>
                            </div>
                            <div class="flex justify-between text-blue-600">
                                <p>Active:</p>
                                <p>{{ $activeTherapists->count() }}</p>
                            </div>
                            <div class="flex justify-between text-slate-500">
                                <p>Inactive:</p>
                                <p class="">{{ $inactiveTherapists->count() }}</p>
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
                        <div class="h-60 w-full">
                            <div>
                                {{ $therapists->links() }}
                            </div>
                            <div class="h-96 overflow-y-scroll">
                                @foreach ($therapists as $therapist)
                                    <x-therapists-card :therapist="$therapist" :incompleteTherapist="!$therapist->id_uploaded ||
                                        !$therapist->W9_or_WBEN_uploaded ||
                                        !$therapist->license_uploaded ||
                                        !$therapist->insurance_uploaded ||
                                        !$therapist->headshot_uploaded"
                                        :unverifiedTherapist="!$therapist->all_documents ||
                                        !$therapist->contract_signed"
                                        >
                                    </x-therapists-card>
                                @endforeach
                            </div>
                            <div>
                                {{ $therapists->links() }}
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
                        <div class="flex w-full flex-col text-base lg:w-1/2">
                            <div class="flex items-center justify-between font-bold">
                                <a href="{{ route('session.index') }}" class="">
                                    <button
                                        class="mb-1 rounded-md border-2 border-blue-300 px-2 py-1 transition duration-300 ease-in-out hover:bg-blue-400">Therapy
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
                        <div class="h-60 w-full">
                            <p>Latest 10 Sessions:</p>
                            <div class="h-96 overflow-y-auto">
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
                    <div class="mt-4 flex w-1/3 flex-col text-base">
                        <div class="flex justify-between font-bold">
                            <button
                                class="mb-1 rounded-md border-2 border-blue-300 px-2 py-1 transition duration-300 ease-in-out hover:bg-blue-400">
                                <a href="{{ route('clients.index') }}">
                                    <p>Clients</p>
                                </a>
                            </button>
                        </div>
                    </div>

                </x-slot>
                <x-slot name="count">
                    <button class="button-secondary mt-4">
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

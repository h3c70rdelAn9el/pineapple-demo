<x-app-layout>
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


    <div class="relative mx-auto mt-3 grid h-full w-full max-w-6xl grid-cols-1 md:grid-cols-2 gap-3 rounded-md p-4">
       <section class="col-span-1">
            <x-container-content>
                <div class="w-full">

                    <x-slot name="title">
                        {{-- Therapists: --}}

                        <div class="flex w-full flex-col text-base lg:w-1/2">
                            <div class="flex items-center justify-between font-bold">
                                <a href="{{ route('therapists.index') }}" class=""><button
                                        class="mb-1 rounded-md border-2 border-blue-300 px-2 py-1 transition duration-300 ease-in-out hover:bg-blue-400">Therapists:</button></a>
                                <p>{{ $therapists->count() }}</p>
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
                                <p>{{ $incompleteTherapists->count() }}</p>
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
                                    <x-therapists-card :therapist="$therapist" incompleteTherapist="$incompleteTherapist"
                                        incompleteTherapists="$incompleteTherapists"></x-therapists-card>
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
                                        class="mb-1 rounded-md border-2 border-blue-300 px-2 py-1 transition duration-300 ease-in-out hover:bg-blue-400">Therapy Sessions:
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
                            {{-- <div>
                                {{ $allTherapySessions->links() }}
                            </div> --}}
                            <p>Latest 10 Sessions:</p>
                            <div class="h-96 overflow-y-auto">
                                @foreach ($allTherapySessions->take(10) as $ts)
                                    <x-session-card
                                    :therapySession="$therapySession"

                                        ></x-session-card>
                                @endforeach
                            </div>
                            {{-- <div>
                                {{ $therapists->links() }}
                            </div> --}}

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
                            {{-- <p>{{ $totalClientCount }}</p> --}}
                        </div>

                        {{-- <div class="flex justify-between">
                            <p>Inactive:</p>
                            <p class="text-orange-500">{{ $inactiveClients->count() }}</p>
                        </div> --}}


                        <!--
                        <div
                            class="flex w-full flex-row gap-2 text-orange-500">
                            {{-- <a href="javascript:void(0)" class="w-full flex flex-row"> --}}
                                    {{-- <button x-on:click="navigateToClients('inactive')" class="flex flex-row"> --}}

                                    <p>Inactive Clients:</p>
                                    <p class="text-orange-500">{{ $inactiveClients->count() }}</p>
                                {{-- </button> --}}
                                {{-- </a> --}}

                        </div>
                    -->

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
                    <div>
                        {{ $allClients->links() }}
                    </div>
                    {{-- @foreach ($allClients as $client) --}}
                    {{-- <x-client-card :client="$client" :therapist="$therapist" :user="$user"></x-client-card> --}}
                    {{-- <x-client-table :client="$client" :therapist="$therapist" :user="$user" :clients="$clients"></x-client-table> --}}
                    <x-client-table :clients="$allClients" :attendedSessions="$attendedSessions" :missedSessions="$missedSessions" :client="$client" />

                    {{-- @endforeach --}}
                    <div>
                        {{ $allClients->links() }}
                    </div>
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

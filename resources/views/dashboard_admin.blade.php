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


    <div class="relative mx-auto mt-3 flex h-full w-full max-w-6xl flex-col rounded-md p-4 md:flex-row">
        <x-container-content>
            <x-slot name="title">
                {{-- Therapists: --}}

                <div class="flex w-2/3 flex-col text-base lg:w-1/2">
                    <div class="flex justify-between font-bold">
                        <p>Therapists:</p>
                        <p>{{ $therapists->count() }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Active:</p>
                        <p class='text-blue-600'>{{ $activeTherapists->count() }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Inactive:</p>
                        <p class="text-orange-400">{{ $inactiveTherapists->count() }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Incomplete Profiles:</p>
                        <p class="text-red-600">{{ $incompleteTherapists->count() }}</p>
                    </div>
                </div>
            </x-slot>
            <x-slot name="count">

                {{-- {{ $therapists->count() }}
                    {{ $activeTherapists->count() }}
                    {{ $inactiveTherapists->count() }} --}}
                {{-- <div class="flex flex-col">
                        <p>Total: <span>{{ $therapists->count() }}</span></p>
                        <p>Active: <span>{{ $activeTherapists->count() }}</span></p>
                        <p>Inactive: <span>{{ $inactiveTherapists->count() }}</span> </p>
                    </div> --}}
            </x-slot>
            <x-slot name="content">
                <div>
                    {{ $therapists->links() }}
                </div>
                @foreach ($therapists as $therapist)
                    <x-therapists-card
                        :therapist="$therapist"
                        incompleteTherapist="$incompleteTherapist"
                    ></x-therapists-card>
                @endforeach
                <div>
                    {{ $therapists->links() }}
                </div>

            </x-slot>
        </x-container-content>

        <x-container-content>
            <x-slot name="title">
                <div class="flex w-1/4 flex-col text-base">
                    <div class="flex justify-between font-bold">
                        <a href="{{ route('clients.index') }}">
                            <p>Clients:</p>
                        </a>
                        <p>{{ $totalClientCount }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p>Inactive:</p>
                        <p class="text-orange-500">{{ $inactiveClients->count() }}</p>
                    </div>
                </div>

            </x-slot>
            <x-slot name="count">
                <button class="button-secondary mt-4">
                    <a
                        class="text-sm"
                        href="{{ route('clients.create') }}"
                    >
                        Add Client
                    </a>
                </button>
            </x-slot>

            <x-slot name="content">
                <div>
                    {{ $allClients->links() }}
                </div>
                @foreach ($allClients as $client)
                    <x-client-card
                        :client="$client"
                        :therapist="$therapist"
                        :user="$user"
                    ></x-client-card>
                @endforeach
                <div>
                    {{ $allClients->links() }}
                </div>
            </x-slot>
        </x-container-content>
    </div>
</x-app-layout>

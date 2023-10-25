<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>

        @if($user->admin==1)
        <div class="flex flex-row pt-2 ml-7">
            <p class="ml-2">
                Admin Priveleges
            </p>
        </div>
        @endif

        {{-- <div class="flex flex-row pt-2 ml-7">
            <p class="ml-2">
                {{ $user->on_vacation ? 'On Vacation' : 'Available' }}
        </p>
        </div> --}}

        <div class="mx-auto mt-2 w-1/2">
            <form action="/search"
                method="get">
                @csrf
                <div class="flex flex-row">
                    <input class="block w-full rounded-md"
                        id="query"
                        name="query"
                        type="text"
                        placeholder="Search for..."
                        {{-- value={{ request()->get('query') }} --}}>
                    <button class="rounded-md bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
                        type="submit">Search</button>
                </div>
            </form>
        </div>

        <div class="relative mx-auto mt-3 flex h-full w-full max-w-6xl flex-col rounded-md p-4 md:flex-row">
            <x-container-content>
                <x-slot name="title">
                    {{-- Therapists: --}}

                    <div class="flex w-1/4 flex-col text-base">
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
                            <p class="text-orange-500">{{ $inactiveTherapists->count() }}</p>
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
                    @foreach ($therapists as $therapist)
                        <x-therapists-card :therapist="$therapist"></x-therapists-card>
                    @endforeach
                </x-slot>
            </x-container-content>

            <x-container-content>
                <x-slot
                    name="title">
                    <div class="flex w-1/4 flex-col text-base">
                        <div class="flex justify-between font-bold">
                            <p>Clients:</p>
                            <p>{{ $allClients->count() }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p>Active:</p>
                            <p class='text-green-500'>{{ $activeClients->count() }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p>Inactive:</p>
                            <p class="text-orange-500">{{ $inactiveClients->count() }}</p>
                        </div>
                    </div>

                </x-slot>
                <x-slot name="count">
                    <button class="button-secondary mt-4">
                        <a class="text-sm"
                            href="{{ route('clients.create') }}">
                            Add Client
                        </a>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @foreach ($allClients as $client)
                        <x-client-card :client="$client"
                            :therapist="$therapist"
                            :user="$user"></x-client-card>
                    @endforeach
                </x-slot>
            </x-container-content>
        </div>
    </x-main-container>
</x-app-layout>

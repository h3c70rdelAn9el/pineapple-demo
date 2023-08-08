<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>

        {{-- <div class="flex flex-row pt-2 ml-7">
            <p class="ml-2">
                {{ $user->on_vacation ? 'On Vacation' : 'Available' }}
        </p>
        </div> --}}

        <div class="w-1/2 mx-auto mt-2">
            <form action="/search" method="get">
                @csrf
                <div class="flex flex-row">
                    <input type="text" placeholder="Search for..." id="query" name="query" class="block w-full rounded-md" {{-- value={{ request()->get('query') }} --}}>
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-700">Search</button>
                </div>
            </form>
        </div>

        <div class="relative flex flex-col w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            <x-container-content>
                <x-slot name="title">
                    Therapists:
                </x-slot>
                <x-slot name="count">
                    {{ $therapists->count() }}
                </x-slot>
                <x-slot name="content">
                    @foreach ($therapists as $therapist)
                    <x-therapists-card :therapist="$therapist"></x-therapists-card>
                    @endforeach
                </x-slot>
            </x-container-content>

            <x-container-content>
                    <x-slot name="title" class="">
                     <div class="flex flex-col w-1/4 text-base">
                            <div class="flex justify-between">
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
                        <button class="mt-4 button-secondary">
                            <a href="{{ route('clients.create') }}" class="text-sm ">
                                Add Client
                            </a>
                        </button>
                    </x-slot>

                <x-slot name="content">
                    @foreach ($allClients as $client)
                    <x-client-card :client="$client" :therapist="$therapist" :user="$user"></x-client-card>
                    @endforeach
                </x-slot>
            </x-container-content>
        </div>
    </x-main-container>
</x-app-layout>

<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
        </x-container-header>
        <div class="w-2/3 p-2 m-2 mx-auto text-center bg-blue-100 rounded-lg lg:w-1/3">
            <h1 class="capitalize">Therapist: <span class="text-lg lg:font-bold">{{ $therapist->name }}</span></h1>
            {{-- TODO:  add credentials --}}
            <p class="ml-2 text-sm text-gray-700">
                {{ $user->on_vacation ? 'On Vacation' : 'Available' }}
            </p>
            <p class="font-light">view Therapist documents</p>
            {{-- show the route for the therapist docs --}}
            <a href="{{ route('therapist.forms', $therapist, $file_name) }}" class="text-blue-500 underline">Therapist Forms</a>


        </div>
        <div class="flex flex-col w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            {{-- left/top --}}
            <x-container-content :user="$user">
                <x-slot name="title">
                    Clients
                </x-slot>
                <x-slot name="count">
                    {{ $clients->count() }}
                </x-slot>
                <x-slot name="content">
                    @foreach ($clients as $client)
                        <x-client-card :client="$client"
                            :therapist="$therapist"
                            :user="$user"></x-client-card>
                    @endforeach
                </x-slot>
            </x-container-content>
            {{-- right/bottom --}}
            <x-container-content>
                <x-slot name="title">
                    Sessions
                </x-slot>
                <x-slot name="count">
                    {{ $clients->sum(function ($client) {
                        return $client->therapySessions->count();
                    }) }}
                </x-slot>
                <x-slot name="content">
                    @forelse ($clients as $client)
                        @foreach ($client->therapySessions as $therapySession)
                            <x-session-card :therapySession='$therapySession'
                                :therapist='$therapist'
                                :client='$client'></x-session-card>
                        @endforeach
                    @empty
                        <p>There are no sessions to display</p>
                    @endforelse
                </x-slot>
            </x-container-content>
        </div>
    </x-main-container>
</x-app-layout>

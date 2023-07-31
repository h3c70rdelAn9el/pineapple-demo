<x-app-layout>
    {{-- add the error --}}
    @if (session('error'))
        <div class="w-1/2 p-4 m-4 mx-auto text-center text-white bg-red-500 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    @endif
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>
        <div class="flex flex-row pt-2 ml-7">
            {{-- <p>
                On Vacation:
            </p> --}}
            <p class="ml-2">
                {{ $user->on_vacation ? 'On Vacation' : 'Available' }}
            </p>
        </div>
        {{-- search form --}}
        <div class="w-1/2 mx-auto mt-2">
            <form action="/search"
                method="get">
                @csrf
                <div class="flex flex-row">
                    <input type="text"
                        placeholder="Search for..."
                        id="query"
                        name="query"
                        class="block w-full rounded-md"
                        livekeyup="search"
                        {{-- value={{ request()->get('query') }} --}}>
                    <button type="submit"
                        class="px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-700">Search</button>
                </div>
            </form>
        </div>
        <div class="flex flex-col-reverse w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            <x-container-content>
                <x-slot name="title">
                    Clients:
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
            {{-- <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-row flex-wrap justify-between mx-12 mb-2 text-lg border-b border-gray-100">
                    <p class="font-bold">Clients:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $clients->count() }}</span></p>
                </div>
                <div class="flex flex-row flex-wrap p-2 m-2 mx-auto overflow-y-scroll h-96">

                    @foreach ($clients as $client)
                        <x-client-card :client="$client"
                            :therapist="$therapist"
                            :user="$user"></x-client-card>
                    @endforeach
                </div>
            </div> --}}
            <x-container-content>
                <x-slot name="title">
                    Sessions:
                </x-slot>
                <x-slot name="count">
                    {{ $therapySessions->count() }}
                </x-slot>
                <x-slot name="content">
                    @forelse ($therapySessions as $therapySession)
                        <x-session-card :therapySession='$therapySession'
                            :therapist='$therapist'
                            :client='$therapySession->client'></x-session-card>
                    @empty
                        <p>There are no sessions to display</p>
                    @endforelse
                </x-slot>
            </x-container-content>
    </x-main-container>
</x-app-layout>

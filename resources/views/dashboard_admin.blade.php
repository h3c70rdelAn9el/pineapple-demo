<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>

        <div class="flex flex-col w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
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
                <x-slot name="title">
                    Clients:
                </x-slot>
                <x-slot name="count">
                    {{ $allClients->count() }}
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
        {{-- <div class="w-10/12 max-w-3xl mx-auto">
            <h3 class="text-lg text-center">Add Client</h3>
            <x-client-form :therapists="$therapists"></x-client-form>
        </div> --}}

        <div x-data="{ open: false }"
            x-cloak
            class="w-10/12 max-w-3xl mx-auto">
            <button x-on:click="open = ! open"
                class="text-lg text-center text-blue-400 hover:text-blue-600">Add Client</button>
            <div x-show="open"
                x-transition.duration.300ms
                x-cloak>
                <div class="relative">
                    <div class="absolute z-20 w-full h-screen bg-blue-200 border border-blue-600 rounded-md -top-20 -mt-96 lg:-top-80"
                        style="z-index: 99999;"
                        @click.away="open = false"
                        x-cloak>
                        <x-client-form :therapists="$therapists"></x-client-form>
                    </div>
                </div>
            </div>
        </div>
    </x-main-container>
</x-app-layout>

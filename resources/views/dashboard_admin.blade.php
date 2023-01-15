<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>

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
        <div x-data="{ open:  false }">
            <button @click="open = !open"
                class="text-lg text-center text-blue-400 hover:text-blue-600">Add Client</button>
            <div x-show="open" x-cloak @click.away="open = false">
                <div class="absolute inset-0 w-2/3 mx-auto top-2 ">
                    <x-client-form :therapists="$therapists"></x-client-form>
                </div>
            </div>
        </div>

    </x-main-container>
</x-app-layout>

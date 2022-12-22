<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">
            {{ $user->name }}
        </x-container-header>

        <div class="flex flex-col w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-row flex-wrap justify-between mx-12 mb-2 text-lg border-b border-gray-100">
                    <p class="font-bold">Therpists:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $therapists->count() }}</span></p>
                </div>

                <div class="inline overflow-scroll overflow-y-scroll h-96">
                    <div class="flex flex-col flex-wrap justify-center mx-auto lg:flex-row">
                        @forelse ($therapists as $therapist)
                            @include('components/therapists-card')
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-wrap justify-between mx-12 mb-2 text-lg">
                    <p class="font-bold">Clients:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $allClients->count() }}</span></p>
                </div>
                <div class="flex overflow-scroll overflow-y-scroll h-96">
                    <div class="flex flex-row flex-wrap justify-center mx-auto">
                        @forelse ($allClients as $client)
                            @include('components/client-card')
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="w-2/3 mx-auto">
            <x-client-form :therapists="$therapists"></x-client-form>
        </div>
    </x-main-container>
</x-app-layout>

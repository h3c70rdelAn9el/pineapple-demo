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

                <div class="w-full overflow-y-scroll h-96">
                    <div class="w-full px-2 mx-auto -mt-4">
                        @forelse ($therapists as $therapist)
                            {{-- @include('components/therapists-card') --}}
                            <x-therapists-card :therapist="$therapist" :therapySessions="$therapySessions"></x-therapists-card>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-wrap justify-between mx-12 mb-2 text-lg">
                    <p class="font-bold">All Clients:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $allClients->count() }}</span></p>
                </div>
                <div class="flex overflow-y-scroll h-96">
                    <div class="flex flex-row flex-wrap justify-center mx-auto">
                        @forelse ($allClients as $client)
                            @include('components/client-card')
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="w-10/12 max-w-3xl mx-auto">
            <h3 class="text-lg text-center">Add Client</h3>
            <x-client-form :therapists="$therapists"></x-client-form>
        </div>
    </x-main-container>
</x-app-layout>

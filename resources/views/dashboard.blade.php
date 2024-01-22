<x-app-layout>
    @if (session('error'))
        <div class="w-1/2 p-4 m-4 mx-auto text-center text-white bg-red-500 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="w-1/2 p-4 m-4 mx-auto text-center text-white bg-green-500 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    @endif
        {{-- <x-container-header :user="$user">
            {{ $user->preferred_name ? $user->preferred_name : $user->name }}
        </x-container-header> --}}
        <div class="flex flex-row pt-2 ml-7">
            @if ($incompleteTherapist)
            <div class="text-red-600 text-xs flex flex-col">
                <p >Your Profile Is Incomplete</p>
                <p>Before clients are assigned, you must visit your profile page and complete it.</p>
            </div>

            @endif
        </div>

        <div class="flex flex-col-reverse w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            <x-container-content>
                <x-slot name="title">
                    <div class="flex flex-col">
                        <p>Clients:</p>
                        <p class="text-orange-600">Inactive Clients:</p>
                    </div>
                </x-slot>
                <x-slot name="count">
                    <div class="flex flex-col">
                        <p>{{ $clients->total() }}</p>
                        <p class="text-orange-600">{{ $inactiveTherapistClientsCount }}</p>
                    </div>
                </x-slot>
                <x-slot name="content">
                    @foreach ($clients as $client)
                        <x-client-card :client="$client"
                            :therapist="$therapist"
                            :user="$user"></x-client-card>
                    @endforeach
                    <div class="flex flex-col">
                        {{-- add paginator links --}}
                        {{ $clients->links() }}
                    </div>

                </x-slot>
            </x-container-content>
            <x-container-content>
                <x-slot name="title">
                    Sessions:
                </x-slot>
                <x-slot name="count">
                    {{ $therapySessionsForTherapistClients->total() }}
                </x-slot>
                <x-slot name="content">
                    @forelse ($therapySessionsForTherapistClients as $therapySession)
                        <x-session-card :therapySession='$therapySession'
                            :therapist='$therapist'
                            :client='$therapySession->client'></x-session-card>
                    @empty
                        <p>There are no sessions to display</p>
                    @endforelse
                    <div class="flex flex-col">
                        {{-- add paginator links --}}
                        {{ $therapySessionsForTherapistClients->links() }}
                        {{-- {{ $therapySessionsForTherapistClients->links('pagination::tailwind') }} --}}
                    </div>
                </x-slot>
            </x-container-content>
</x-app-layout>

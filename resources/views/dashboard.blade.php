<x-app-layout>
    @if (session('error'))
        <div class="m-4 mx-auto w-1/2 rounded-md bg-red-500 p-4 text-center text-white shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="m-4 mx-auto w-1/2 rounded-md bg-green-500 p-4 text-center text-white shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="ml-7 flex flex-row pt-2">
        @if ($incompleteTherapist)
            <div
                class="mx-auto flex flex-col rounded-md border border-red-800 bg-red-100 p-2 text-center text-lg text-red-600">
                <p>Your Profile Is Incomplete</p>
                <p>Before clients are assigned, you must visit your profile page and complete it.</p>
            </div>
        @endif
    </div>

    <div class="mx-auto mt-3 flex h-full w-full max-w-6xl flex-col rounded-md p-4 md:flex-row">
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
                <div class="flex flex-col">
                    {{ $therapistClients->links() }}
                </div>

                @foreach ($clients as $client)
                    <x-client-card :client="$client" :therapist="$therapist" :user="$user"></x-client-card>
                @endforeach
                <div class="flex flex-col">
                    {{ $therapistClients->links() }}
                </div>

            </x-slot>
        </x-container-content>
        <x-container-content>
            <x-slot name="title">
                <a href="{{ route('session.index') }}" class="">
                    <button
                        class="mb-1 rounded-md border-2 border-blue-300 px-2 py-1 transition duration-300 ease-in-out hover:bg-blue-400">Therapy
                        Sessions:
                    </button>
                </a>
            </x-slot>
            <x-slot name="count">
                <div class="flex flex-col items-center pt-1.5">
                    {{-- {{ $therapySessionsForTherapistClients->count() }} --}}
                    <p>{{ $therapySessionsForTherapistClients->total() }}</p>
                </div>
            </x-slot>
            <x-slot name="content">
                <p>Latest 10 sessions:</p>
                @forelse ($therapySessionsForTherapistClients as $therapySession)
                    <x-session-card :therapySession='$therapySession' :therapist='$therapist' :client='$therapySession->client'></x-session-card>
                @empty
                    <p>There are no sessions to display</p>
                @endforelse
            </x-slot>
        </x-container-content>
</x-app-layout>

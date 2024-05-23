<x-app-layout>
    @if (session('error'))
        <div class="m-4 mx-auto w-1/2 rounded-md bg-red-500 p-4 text-center text-white shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <x-success-message></x-success-message>
    @endif

        @if ($user)
            @php
             $incompleteTherapist = false;
            /*
                $fieldsToCheck = [
                    'id_uploaded' => $user->id_uploaded ?? null,
                    'W9_or_WBEN_uploaded' => $user->W9_or_WBEN_uploaded ?? null,
                    'license_uploaded' => $user->license_uploaded ?? null,
                    'insurance_uploaded' => $user->insurance_uploaded ?? null,
                    'headshot_uploaded' => $user->headshot_uploaded ?? null,
                ];



                foreach ($fieldsToCheck as $field) {
                    if (is_null($field) || $field == false) {
                        $incompleteTherapist = true;
                        break;
                    }
                }
                */
                $incompleteTherapist = !$user->isComplete()['status'];

                $fieldsToCheck = [
                    'contract_signed' => $user->contract_signed ?? null,
                    'all_documents' => $user->all_documents ?? null,
                ];

                $unverifiedTherapist = false;
                $unverifiedTherapist = !$user->isVerified()['status'];
                /*
                foreach ($fieldsToCheck as $field) {
                    if (is_null($field) || $field == false) {
                        $unverifiedTherapist = true;
                        break;
                    }
                }
                */
            @endphp
        @endif

        <div class="mx-auto flex flex-col md:w-2/3">
            @if ($incompleteTherapist)
                <div
                    class="mx-auto flex flex-col rounded-md border border-red-800 bg-red-100 p-2 text-center text-lg text-red-600">
                    <p>Your Profile is Incomplete</p>
                    <p>Before clients are assigned, you must visit your profile page and complete it.</p>
                </div>
            @endif
            @if ($unverifiedTherapist)
                <div
                    class="mx-auto mt-2 flex flex-col rounded-md border border-yellow-800 bg-yellow-100 p-2 text-center text-lg text-yellow-700">
                    <p>Your Profile is currently unverified</p>
                    <p>Please contact admin to complete verification.</p>
                </div>
            @endif
        </div>

    @if ($unreadMessagesCount > 0)
        <div
            class="mx-auto ml-14 mt-2 flex w-52 max-w-6xl flex-row items-center justify-center rounded-md border border-blue-400 bg-blue-200 px-4 py-1 font-medium transition duration-200 hover:bg-blue-500">
            <a href="/messages">
                <p class="text-center">Unread Messages:<span class="ml-2 font-bold">
                        {{ $unreadMessagesCount }}</span>
                </p>
            </a>
        </div>
    @endif

    <div class="mx-auto mt-2 flex h-full w-full max-w-6xl flex-col rounded-md p-4 md:flex-row">
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

<x-app-layout>
    <x-main-container>
            <x-container-header :user="$user">
        </x-container-header>
        @if (Auth::user()->admin)
            <a class="h-6 ml-10 text-sm text-blue-600 hover:text-blue-800"
                href="{{ route('clients.edit', $client->id) }}">
                Edit Client
            </a>
        @endif

        {{-- <div class="flex flex-col max-w-5xl mx-auto border border-purple-700 rounded-lg lg:w-full lg:flex-row"> --}}
        <div class="grid w-full grid-cols-1 gap-3 p-2 px-6 mx-auto rounded-lg md:grid-cols-2">
            {{-- left side --}}
            <div
                class="p-1 px-3 mt-2 overflow-hidden border border-green-500 rounded-md shadow-md bg-blue-50 shadow-blue-100">
                @include('partials.client-fields')
            </div>

            {{-- right side --}}
            <div class="flex flex-col p-1 mt-2 border border-purple-500 rounded-md shadow-md shadow-blue-100">
                <h2 class="text-lg font-bold text-center">Client Sessions</h2>
                <div class="flex flex-row w-2/3 mx-auto ">
                    <div class="flex flex-col mt-4 text-xs">
                        <p class="text-gray-500">
                            {{-- <span>{{ $attendedSessions->count() }} out of {{ $client->max_sessions }}</span> --}}
                            <span
                                class="mr-3 font-bold">{{ $client->max_sessions - $attendedSessions->count() }}</span>Sessions
                            Left
                        </p>
                        <p class="text-green-600">
                            <span
                                class="mr-1">{{ $client->therapySessions->where('attendance', 'attended')->count() }}</span>
                            Attended
                        </p>
                        <p class="text-red-600">
                            <span
                                class="mr-2">{{ $client->therapySessions->where('attendance', 'no-show')->count() }}</span>
                            No Show
                        </p>
                    </div>
                    <div class="p-2 mx-auto mt-2 mb-2 rounded-md shadow-md bg-blue-50 shadow-blue-100 lg:w-1/2">
                        {{-- TODO: REFACTOR THE FOLLOWING LATER --}}
                        {{-- Add Session --}}
                        <div x-data="{ showModal: false }">
                            <!-- Modal Trigger Button -->
                            <button
                                class="w-full p-2 mt-2 text-sm font-bold text-center text-white transition-all duration-200 ease-in bg-blue-500 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg"
                                @click="showModal = true">
                                Add Session
                            </button>
                            <!-- Modal Background -->
                            <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-gray-800 bg-opacity-50"
                                x-show="showModal"
                                x-transition.duration.300ms
                                x-cloak>
                                <!-- Modal Content -->
                                <div
                                    class="w-1/2 p-4 mx-auto my-10 overflow-hidden text-left align-middle bg-white rounded-lg shadow-xl md:w-1/3">
                                    <div class="flex flex-row justify-between">
                                        <h3 class="text-lg font-bold">Add Session</h3>
                                        <button class="text-gray-400 hover:text-gray-500"
                                            @click="showModal = false">
                                            <svg class="w-6 h-6"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2.5"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        @include('components/session-form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-row flex-wrap w-full p-2 mx-auto overflow-y-scroll rounded-md shadow-md h-96">
                    @forelse ($client->therapySessions as $therapySession)
                        <x-session-card :therapySession='$therapySession'
                            :therapist='$therapist' />
                    @empty
                        <p>Client does not have any sessions</p>
                    @endforelse
                </div>
            </div>
        </div>


    </x-main-container>
</x-app-layout>

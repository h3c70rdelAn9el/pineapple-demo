<x-app-layout>
    @if (session('success'))
        <x-success-message></x-success-message>
    @endif
    <div x-data="{ showLimitModal: {{ $client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count() >= 16? 'true': 'false' }} }">
        <div class="relative">
            <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-gray-800 bg-opacity-50"
                x-show="showLimitModal" x-transition.duration.300ms x-cloak>
                <div
                    class="fixed z-50 flex flex-col rounded-lg border-2 border-blue-700 bg-gray-200 p-8 text-center shadow-md">

                    <h2 class="mb-4 text-2xl font-bold">Client Reached 16 Sessions</h2>
                    <p>Client has completed 16 sessions.</p>
                    <button class="button-secondary mx-auto mt-4" @click="showLimitModal = false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto grid h-full w-full grid-cols-1 gap-3 rounded-lg p-2 px-6 md:grid-cols-2">
        {{-- left side --}}

        <div class="col-span-1 h-full">@include('partials.client-fields')</div>


        {{-- right side --}}
        <div class="mt-2 flex h-full flex-col rounded-md border border-purple-500 p-1 shadow-md shadow-blue-100">
            <h2 class="text-center text-lg font-bold">Client Sessions</h2>
            <p class="ml-2 text-xs">Assigned Sessions: {{ $client->max_sessions }}</p>
            <div class="mx-auto flex w-2/3 flex-row">
                <div class="w-full">@include('partials.sessions-attended')</div>
                <div class="mx-auto mb-2 mt-2 rounded-md bg-blue-50 p-2 shadow-md shadow-blue-100 lg:w-1/2">
                    {{-- TODO: REFACTOR THE FOLLOWING LATER --}}
                    {{-- Add Session --}}
                    <div x-data="{ showSessionModal: false }">
                        @if ($client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count() < $client->max_sessions)
                            <div class="w-full">
                                <button
                                    class="mt-2 w-full rounded-lg bg-blue-500 p-2 text-center text-sm font-bold text-white shadow-md transition-all duration-200 ease-in hover:bg-blue-700 hover:shadow-lg"
                                    @click="showSessionModal = true">
                                    Add Session
                                </button>
                            </div>
                        @else
                            <p class="text-center text-xs text-red-500">
                                Session Limit Reached, please <a href="mailto: kellie@pineapplesupport.org"
                                    class="text-blue-400 hover:text-blue-600">contact us</a>.
                            </p>
                        @endif
                        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-gray-800 bg-opacity-50"
                            x-show="showSessionModal" x-transition.duration.300ms x-cloak>
                            <div
                                class="mx-auto my-10 w-1/2 overflow-hidden rounded-lg bg-white p-4 text-left align-middle shadow-xl md:w-1/3">
                                <div class="flex flex-row justify-between">
                                    <h3 class="text-lg font-bold">Add Session</h3>
                                    <button class="text-gray-400 hover:text-gray-500" @click="showSessionModal = false">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
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
                <div class="mx-auto flex h-96 w-full flex-row flex-wrap overflow-y-scroll rounded-md p-2 shadow-md">
                    @forelse ($client->therapySessions as $therapySession)
                        <x-session-card :therapySession='$therapySession' :therapist='$therapist' />
                    @empty
                        <p>Client does not have any sessions</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

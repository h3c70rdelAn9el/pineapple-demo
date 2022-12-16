<x-app-layout>
    <div
        class="w-11/12 pb-4 mx-auto mt-20 bg-gray-100 border border-blue-500 shadow-lg max-w-7xl rounded-xl shadow-blue-100">
        <section
            class="flex flex-col items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
            <div class="p-4 text-center capitalize shadow-md sm:rounded-lg">
                <p class="text-lg md:text-lg">Welcome:<span class="text-xl font-bold"> {{ $user->name }}</span></p>
            </div>

            <div class="bg-blue-500">
                <x-clock class="text-lg text-white bg-blue-500 w-44"></x-clock>
            </div>
        </section>
        <div class="flex flex-col-reverse w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-row flex-wrap justify-between mx-12 mb-2 text-lg border-b border-gray-100">
                    <p class="font-bold">Clients:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $clients->count() }}</span></p>
                </div>
                <div class="flex flex-row flex-wrap justify-center mx-auto overflow-y-scroll">
                    @forelse ($clients as $client)
                        @include('components/client-card')
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-row flex-wrap justify-between mx-12 mb-2 text-lg border-b border-gray-100">
                    <p class="font-bold">Sessions:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $therapySessions->count() }}</span></p>
                </div>
                <div class="flex flex-row flex-wrap justify-center mx-auto overflow-y-scroll">
                    @forelse ($therapySessions as $therapySession)
                        <a href="{{ route('session.show', $therapySession->id) }}"
    class="relative w-full p-2 m-2 transition-all duration-200 ease-in border border-blue-200 rounded-lg shadow-md hover:border hover:border-blue-400 bg-blue-50 shadow-blue-100 hover:shadow-lg ">
    <div class="text-base">
        <h2>{{ $client->chosen_name }}</h2>
        <p>{{ $client->pronouns }}</p>
    </div>
    <div class="flex justify-between p-1">
        <p class="text">{{ $therapySession->created_at->format('M d Y') }}</p>
        {{-- TODO: ADD PROPER TIME --}}
        {{-- <p class="text">{{ $therapySession->created_at->format('h:m') }}</p> --}}
    </div>
    <div class="w-full text-xs text-right">
        <div class="">
            <p><span class="font-bold">Total Bill</span>: {{ $therapySession->total_bill }}</p>
        </div>
        <div class="">
            <p><span class="font-bold">Covered Cost</span>: {{ $therapySession->covered_cost }}</p>
        </div>
    </div>
</a>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
</x-app-layout>

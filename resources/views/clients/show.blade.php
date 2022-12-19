<x-app-layout>
    <x-main-container>
        <section
            class="flex flex-row items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
            <div class="p-4 text-center capitalize shadow-md sm:rounded-lg">
                <p class="text-lg md:text-xl">Client: <span class="font-bold">{{ $client->chosen_name }}</span></p>
            </div>
            <div class="bg-blue-500 w-44">
                <x-clock class="text-xl font-bold text-white bg-blue-500"></x-clock>
            </div>
        </section>
        <div class="container w-5/6 mx-auto rounded-lg lg:w-2/3">
            @if (Auth::user()->admin)
                <a href="{{ route('fileUpload') }}" class="text-blue-600 hover:text-blue-800">
                        Upload Insurance Form
                </a>
            @endif
            <div class="w-5/6 p-2 mx-auto mt-2 mb-2 rounded-md shadow-md bg-blue-50 shadow-blue-100 lg:w-1/2">
                <p class="text-lg text-center">Add Session</p>
                @include('components/session-form')
            </div>

            <h2 class="my-2 text-lg font-bold">Client Sessions:</h2>
            <div class="container grid grid-cols-3 gap-5">

                @forelse ($client->therapySessions as $therapySession)
                    @include('components/session-card')
                @empty
                    <p>No sessions to display</p>
                @endforelse
            </div>
        </div>
    </x-main-container>
</x-app-layout>

<x-app-layout>
    @if (Session::has('error'))
        <div class="relative z-10 grid h-12 mx-auto place-items-center">
            <div class="absolute px-4 py-2 text-white bg-blue-800 rounded-md alert alert-danger">
                {{ Session::get('error') }}
            </div>
        </div>
    @endif
    <x-main-container>
        <section
            class="flex flex-row items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
            <div class="p-4 text-center capitalize shadow-md sm:rounded-lg">
                <p class="text-md md:text-xl">Client: <span class="font-bold">{{ $client->chosen_name }}</span></p>
            </div>
            <div class="bg-blue-500 w-44">
                <x-clock class="pr-2 font-bold text-right text-white bg-blue-500 lg:text-xl"></x-clock>
            </div>
        </section>
        @if (Auth::user()->admin)
            <a href="{{ route('fileUpload') }}"
                class="h-6 ml-10 text-sm text-blue-600 hover:text-blue-800">
                Upload Insurance Form
            </a>
        @endif
        <div class="container flex flex-col w-5/6 max-w-5xl mx-auto rounded-lg lg:flex-row">
            {{-- left side --}}
            <div class="p-2 mx-auto mt-2 mb-2 rounded-md shadow-md bg-blue-50 shadow-blue-100 lg:w-1/2">
                <p class="text-lg text-center">Add Session</p>
                @include('components/session-form')
                <div class="flex flex-row mt-4">
                    <p class="text-xs text-gray-500">Sessions Left:
                        <span class="font-bold">{{ $client->max_sessions - $client->therapySessions->count() }}</span>
                        out of <span class="font-bold">{{ $client->max_sessions  }}</span>
                    </p>
                </div>
            </div>
            {{-- right side --}}
            <div class="p-1 mx-auto mt-2 mb-2 rounded-md shadow-md bg-blue-50 shadow-blue-100 lg:w-1/2 lg:p-2">
                <h2 class="text-lg font-bold text-center">Client Sessions:</h2>
                <div class="flex flex-row flex-wrap p-2 mx-auto overflow-y-scroll h-96">
                    @forelse ($client->therapySessions as $therapySession)
                        <x-session-card :therapySession='$therapySession'
                            :user='$therapist' />
                    @empty
                        <p>Client does not have any sessions</p>
                    @endforelse
                </div>
            </div>
        </div>
    </x-main-container>
</x-app-layout>

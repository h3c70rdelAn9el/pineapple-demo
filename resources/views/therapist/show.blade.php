<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">

        </x-container-header>
        <div class="grid items-center w-full h-full max-w-6xl grid-cols-3 p-4 mx-auto mt-3 rounded-md md:flex-row">

            <div class="w-full text-center">
                <h1 class="text-xl capitalize">Therapist: <span class="font-bold">{{ $therapist->name }}</span></h1>
                {{-- TODO:  add credentials --}}
            </div>

            <div class="flex flex-row justify-center">
                <p class="mr-2 text-center">Number of patients: </p>
                <p>{{ $clients->count() }}</p>
            </div>
            {{-- TODO:  ADD SESSIONS --}}
            <div class="text-center">
                sessions go here
            </div>
        </div>
    </x-main-container>
</x-app-layout>

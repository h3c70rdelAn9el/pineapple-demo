<x-app-layout>
    <x-main-container>
        <x-container-header :user="$user">

        </x-container-header>
        <div class="grid items-center w-full h-full max-w-6xl grid-cols-3 gap-3 p-4 mx-auto mt-3 rounded-md md:flex-row">

            <div class="w-full p-2 m-2 text-center bg-blue-100 rounded-lg">
                <h1 class="capitalize">Therapist: <span class="text-lg font-bold">{{ $therapist->name }}</span></h1>
                {{-- TODO:  add credentials --}}
            </div>

            <div class="flex flex-row justify-center w-full p-2 m-2 text-center bg-blue-100 rounded-lg">
                <p class="mr-2 text-center">Clients: </p>
                <p>{{ $clients->count() }}</p>
            </div>
            {{-- TODO:  ADD SESSIONS --}}
            <div class="flex flex-row w-full p-2 m-2 text-center bg-blue-100 rounded-lg">
                <p class="text-center ">Sessions: </p>
                <p>{{ $therapySessions->count() }}</p>
            </div>
        </div>
    </x-main-container>
</x-app-layout>

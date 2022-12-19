<x-app-layout>
    <x-main-container>
        <x-container-header-secondary :user='$user'>
            {{ $user->name }}
        </x-container-header-secondary>


        <section
            class="w-5/6 h-full p-2 mx-auto mt-3 text-gray-800 bg-gray-100 border border-black rounded-lg shadow-md shadow-blue-100 lg:w-1/2">
               <div>
            <p class="text-lg">Client: <span class="font-bold capitalize">
                {{ $therapySession->client->chosen_name }}
            <p class="text-lg text-center">Session Details</p>
        </div>
            <div class="flex flex-row">
                <div class="w-1/2 p-2 border-b border-r border-gray-400">Chosen Name:</div>
                <div class="flex justify-between w-1/2 p-2 capitalize border-b border-gray-400">
                    <p>{{ $client->chosen_name }} </p>
                    <p class="mt-1 mr-2 text-xs">{{ $client->pronouns }}</p>
                </div>
            </div>
              <div class="flex flex-row">
                <div class="w-1/2 p-2 border-b border-r border-gray-400">Therapist:</div>
                <div class="flex justify-between w-1/2 p-2 capitalize border-b border-gray-400">
                    <p>{{ $therapist->name }} </p>
                </div>
            </div>
            <div class="flex flex-row">
                <div class="w-1/2 p-2 border-b border-r border-gray-400">Session ID:</div>
                <div class="w-1/2 p-2 border-b border-gray-400">{{ $therapySession->id }}</div>
            </div>
            <div class="flex flex-row">
                <div class="w-1/2 p-2 border-b border-r border-gray-400">Session Date:</div>
                <div class="w-1/2 p-2 border-b border-gray-400">
                    {{ date('M d, Y, h:m', strtotime($therapySession->created_at)) }}
                </div>
            </div>
            <div class="flex flex-row">
                <div class="w-1/2 p-2 border-b border-r border-gray-400">Session Billed:</div>
                <div class="w-1/2 p-2 border-b border-y-gray-400">{{ $therapySession->total_bill }}</div>
            </div>
            <div class="flex flex-row">
                <div class="w-1/2 p-2 border-r border-gray-400">Insurance Coverage:</div>
                <div class="w-1/2 p-2">{{ $therapySession->covered_cost }}</div>
            </div>
        </section>
        <div class="flex mt-2">
            <a href="{{ route('clients.show', $therapySession->client_id) }}"
                class="mx-auto hover:text-blue-500">
                Back to client Details
            </a>
        </div>
    </x-main-container>
</x-app-layout>

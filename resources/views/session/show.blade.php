<x-app-layout>
    <x-slot name="header">
        <p class="text-lg">Client: <span class="font-bold capitalize">{{ $therapySession->client->chosen_name }}
        <p class="text-lg">Session Details</p>
    </x-slot>

    <section
        class="w-5/6 h-full mx-auto text-gray-800 bg-gray-100 border border-black rounded-lg shadow-md shadow-blue-100 lg:w-1/2">
        <div class="flex flex-row">
            <div class="w-1/2 p-2 border-b border-r border-gray-700">Client Name:</div>
            <div class="flex justify-between w-1/2 p-2 capitalize border-b border-gray-700">{{ $therapySession->client->first }}
                <p>{{ $client->chosen_name }} </p>
                <p class="mt-1 mr-2 text-xs">{{ $client->pronouns }}</p>
            </div>
        </div>
        <div class="flex flex-row">
            <div class="w-1/2 p-2 border-b border-r border-gray-700">Session ID:</div>
            <div class="w-1/2 p-2 border-b border-gray-700">{{ $therapySession->id }}</div>
        </div>
        <div class="flex flex-row">
            <div class="w-1/2 p-2 border-b border-r border-gray-700">Session Date:</div>
            <div class="w-1/2 p-2 border-b border-gray-700">{{ date('M d, Y, h:m', strtotime($therapySession->created_at)) }}
            </div>
        </div>
        <div class="flex flex-row">
            <div class="w-1/2 p-2 border-b border-r border-gray-700">Session Billed:</div>
            <div class="w-1/2 p-2 border-b border-y-gray-700">{{ $therapySession->total_bill }}</div>
        </div>
        <div class="flex flex-row">
            <div class="w-1/2 p-2 border-r border-gray-700">Insurance Coverage:</div>
            <div class="w-1/2 p-2">{{ $therapySession->covered_cost }}</div>
        </div>
    </section>
    <div class="flex mt-2">
        <a href="{{ route('clients.show', $therapySession->client_id) }}" class="mx-auto hover:text-blue-500">
            Back to client Details
        </a>
    </div>
</x-app-layout>

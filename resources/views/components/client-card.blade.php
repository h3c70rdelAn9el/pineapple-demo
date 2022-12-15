{{-- <a href="{{ route('client', $client->id) }}" --}}
<a href="#"

    class="flex flex-row">
    <div
        class="flex flex-row justify-between w-40 p-2 m-2 text-center transition-all duration-200 ease-in bg-blue-200 rounded-md shadow-md shadow-blue-100 hover:scale-105 hover:shadow-lg">
        <p class="text-center capitalize">{{ $client->chosen_name }}</p>
        <p class="text-sm">{{ $client->pronouns }}</p>
    </div>
</a>

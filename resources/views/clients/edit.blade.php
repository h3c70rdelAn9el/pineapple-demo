<x-app-layout>
    <x-main-container>
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="preferred_name">Preferred Name</label>
            <input type="text">
        </form>
    </x-main-container>
</x-app-layout>

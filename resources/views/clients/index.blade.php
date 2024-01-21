<x-app-layout>
    <div>
        <h2 class="text-center text-2xl">Clients</h2>
    </div>
    <div class="flex flex-row justify-between px-4 md:flex-row">
        <div>
            <div class="flex flex-row gap-2">
                <p>All Clients:</p>
                <p>{{ $clients->count() }}</p>
            </div>
            <div class="flex flex-row gap-2">
                <p>Inactive Clients:</p>
                <p>{{ $inactiveClients->count() }}</p>
            </div>
            <div class="flex flex-row gap-2">
                <p>Waitlisted</p>
                <p>{{ $waitlistClients->count() }}</p>
            </div>
        </div>
        <div>
            <button class="button-secondary mt-4">
                <a
                    class="text-sm"
                    href="{{ route('clients.create') }}"
                >
                    Add Client
                </a>
            </button>
        </div>
    </div>
    <section class="container mx-auto p-6">
        @foreach ($clients as $client)
            <x-client-card
                :client="$client"
                :therapist="$therapist"
                :user="$user"
            >
            </x-client-card>
        @endforeach
        {{-- add links --}}
        {{-- <div class="flex justify-center">
            {{ $clients->links() }}
            </div> --}}
    </section>
</x-app-layout>

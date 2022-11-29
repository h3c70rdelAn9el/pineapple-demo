<x-app-layout>
    therapists
    <section>
        @forelse ($therapists as $therapist)
            <p>{{ $therapist->name }}</p>
        @empty

        @endforelse
    </section>
</x-app-layout>

<x-app-layout>
    Your patients
    <div>
        @foreach ($patients as $patient)
            <p>{{ $patient->first }}</p>
        @endforeach
    </div>
</x-app-layout>

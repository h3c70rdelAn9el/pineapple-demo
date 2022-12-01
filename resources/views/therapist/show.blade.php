<x-app-layout>
    <h1 class="text-xl capitalize">Therapist: <span class="font-bold">{{ $therapist->name }}</span></h1>
    <div class="flex flex-row">
        <p class="mr-2">Number of patients: </p>
        <p>{{ $patients->count() }}</p>
    </div>
    {{-- <h1>{{ $user->name }}</h1> --}}
    {{-- TODO:  PULL IN PROPER PATIENTS FOR THERAPISTS! --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
        @forelse ($patients as $patient)
            <a href="{{ route('patient', $patient->id) }}">
                <div class="p-3 text-center rounded-md shadow-md shadow-blue-50 hover:shadow-xl">
                    <p>{{ $patient->first }} {{ $patient->last }}</p>
                </div>
            </a>
        @empty
    </div>
    No Patients to display
    @endforelse
</x-app-layout>

<x-app-layout>
    <h1 class="text-xl capitalize">Therapist: <span class="font-bold">{{ $therapist->name }}</span></h1>
    <div class="flex flex-row">
        <p class="mr-2">Number of patients: </p>
        <p>{{ $clients->count() }}</p>
    </div>
</x-app-layout>

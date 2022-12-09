<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
 <div class="min-h-screen">
        <div class="container p-2 capitalize bg-white shadow-lg shadow-blue-100 sm:rounded-lg">
            {{-- <x-jet-welcome /> --}}
            <p class="text-xl">welcome<span class="font-bold"> {{ $user->name }}</span></p>
        </div>
        <div class="w-2/3 h-full p-4 mx-auto mt-3 bg-white rounded-md">
            <div class="flex flex-row flex-wrap mb-2 text-lg">
                <p>Number of Therpists:</p>
                <p class="ml-2">{{ $therapists->count() }}</p>
            </div>
            <div class="grid grid-cols-4 gap-4 bg-white">
                @forelse ($therapists as $therapist)
                    <a href="{{ route('therapist.show', $therapist->id) }}"
                        class="duration-200 hover:scale-105 group">
                        <div
                            class="w-40 text-center capitalize border rounded-md shadow-xl border-b-blue-200 bg-blue-50 shadow-blue-50">
                            <p>{{ $therapist->name }}</p>
                        </div>
                    </a>
                @empty
                @endforelse
            </div>
            <div>
                <p>Patients</p>
                <p>{{ $allpatients->count() }}</p>
                <div class="grid grid-cols-4 gap-4 bg-white">
                    @forelse ($allpatients as $patient)
                        @include('components/patient-card')
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
 </div>
</x-app-layout>

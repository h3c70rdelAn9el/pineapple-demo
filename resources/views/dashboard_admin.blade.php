<x-app-layout>
    <div class="w-11/12 pb-4 mx-auto mt-20 bg-gray-100 border border-blue-500 shadow-lg max-w-7xl rounded-xl shadow-blue-100">
        <section class="flex flex-row items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
            <div class="p-4 text-center capitalize shadow-md sm:rounded-lg">
                <p class="text-lg md:text-xl">Welcome Admin:<span class="font-bold"> {{ $user->name }}</span></p>
            </div>

            <div class="bg-blue-500">
                <x-clock class="text-xl font-bold text-white bg-blue-500"></x-clock>
            </div>
        </section>

        <div class="flex flex-col w-full h-full max-w-6xl p-4 mx-auto mt-3 rounded-md md:flex-row">
            <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-row flex-wrap justify-between mx-12 mb-2 text-lg border-b border-gray-100">
                    <p class="font-bold ">Therpists:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $therapists->count() }}</span></p>
                </div>

                <div class="flex flex-row flex-wrap justify-center mx-auto overflow-hidden">
                    @forelse ($therapists as $therapist)
                        @include('components/therapists-card')
                    @empty
                    @endforelse
                </div>
            </div>

            <div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
                <div class="flex flex-wrap justify-between mx-12 mb-2 text-lg">
                    <p class="font-bold">Patients:</p>
                    <p class="ml-2">Total: <span class="font-bold">{{ $allpatients->count() }}</span></p>
                </div>
                <div class="flex">
                    <div class="flex flex-row flex-wrap justify-center mx-auto overflow-hidden">
                        @forelse ($allpatients as $patient)
                            @include('components/patient-card')
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

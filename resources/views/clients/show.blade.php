<x-app-layout>
    <x-main-container>
        <section
            class="flex flex-row items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
            <div class="p-4 text-center capitalize shadow-md sm:rounded-lg">
                <p class="text-lg md:text-xl">Client: <span class="font-bold">{{ $client->chosen_name }}</span></p>
            </div>
            <div class="bg-blue-500 w-44">
                <x-clock class="text-xl font-bold text-white bg-blue-500"></x-clock>
            </div>
        </section>
        <div class="container w-5/6 mx-auto rounded-lg lg:w-2/3">
            <div class="w-5/6 p-2 mx-auto mt-2 mb-2 rounded-md shadow-md bg-blue-50 shadow-blue-100 lg:w-1/2">
                <p class="text-lg text-center">Add Session</p>
                <form action="{{ route('session.store') }}"
                    class="capitalize"
                    method="POST">
                    @csrf
                    <div>
                        <label for="total_bill">total bill</label>
                        <input type="text"
                            id="total_bill"
                            name="total_bill"
                            class="form-input">
                    </div>
                    <div>
                        <label for="covered_cost">covered cost</label>
                        <input type="text"
                            id="covered_cost"
                            name="covered_cost"
                            class="form-input">
                    </div>
                    <div>
                        <label for="created_at">Session Date</label>
                        <input type="datetime-local"
                            id="created_at"
                            name="created_at"
                            class="form-input">
                    </div>
                    <div class="hidden">
                        <label for="client_id">id</label>
                        <input type="text"
                            id="client_id"
                            name="client_id"
                            class="form-input"
                            {{-- value="{{ $client->id }}" --}}
                            value="{{ $client->id }}"

                            readonly>
                    </div>
                    <div class="mt-2">
                        <button type="submit"
                            class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
            <h2 class="my-2 text-lg font-bold">Client Sessions:</h2>
            <div class="container grid grid-cols-3 gap-5">

                @forelse ($client->therapySessions as $therapySession)
                    <a href="{{ route('session.show', $therapySession->id) }}"
                        class="relative p-2 duration-200 border border-blue-300 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:shadow-xl hover:shadow-blue-100">
                        <div class="flex justify-between p-1 mx-2">
                            {{-- <p class="text-lg font-bold">{{ $therapySession->created_at->format('M d Y') }}</p> --}}
                            <p class="text-lg">{{ $therapySession->created_at->format('M d Y') }}</p>
                            <p class="text-lg">{{ $therapySession->created_at->format('h:m') }}</p>





                        </div>
                        <div class="w-full text-xs text-right">
                            <div class="">
                                <p><span class="font-bold">Total Bill</span>: {{ $therapySession->total_bill }}</p>
                            </div>
                            <div class="">
                                <p><span class="font-bold">Covered Cost</span>: {{ $therapySession->covered_cost }}</p>
                            </div>
                        </div>
                        <div class="text-xs">
                            <button>
                                View more
                            </button>
                        </div>
                    </a>
                @empty
                    <p>No sessions to display</p>
                @endforelse
            </div>
        </div>
    </x-main-container>
</x-app-layout>

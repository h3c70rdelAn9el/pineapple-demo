    search
    <x-app-layout>
        <div class="w-1/2">
            <form action="/search"
                method="get">
                @csrf
                <div class="flex flex-row">
                    <input type="text"
                        placeholder="Search for..."
                        id="query"
                        name="query"
                        class="block w-full rounded-md"
                        value={{ request()->get('query') }}>
                    <button type="submit"
                        class="px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-700">Search</button>
                </div>
            </form>
            @if ($results)
                <div>
                    @if (count($results) > 0)
                        {{-- <h2>Client Results</h2> --}}
                        @foreach ($results as $result)
                            @if ($result instanceof \App\Models\Client)
                                <div class="flex flex-row">
                                    <p class="mr-2 font-bold">Client:</p>
                                    <p>{{ $result->preferred_name }}</p>
                                </div>
                            @endif
                        @endforeach

                        {{-- <h2>User Results</h2> --}}
                        @foreach ($results as $result)
                            @if ($result instanceof \App\Models\User)
                                <div class="flex flex-row">
                                    <p class="mr-2 font-bold">Therapist:</p>
                                    <p>{{ $result->name }}</p>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p>No results found for "{{ $query }}".</p>
                    @endif

                </div>

            @endif

        </div>
    </x-app-layout>

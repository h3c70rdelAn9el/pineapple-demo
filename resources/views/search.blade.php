    <x-app-layout>
        <x-main-container>
            <x-container-header :user="$user">
                {{ $user->name }}
            </x-container-header>

            <div class="flex flex-col w-1/2 mx-auto mt-2">
                <form action="/search"
                    method="get">
                    @csrf
                    <div class="flex flex-row">
                        <input type="text"
                            placeholder="Search for..."
                            id="query"
                            name="query"
                            class="block w-full rounded-md"
                            value={{ request()->get('query') }}
                            >
                        <button type="submit"
                            class="px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-700">Search</button>
                    </div>
                </form>
                @if ($results)
                    <div class="w-full p-2 mx-auto text-left">
                        <h2 class="mb-2">Search Results:</h2>
                        @if (count($results) > 0)
                            {{-- <h2>Client Results</h2> --}}
                            @foreach ($results as $result)
                                @if ($result instanceof \App\Models\Client)
                                    <div class="flex flex-row">
                                        <p class="mr-2 font-bold">Client:</p>

                                        <p>
                                            <a href="/clients/{{ $result->id }}">
                                                {{ $result->preferred_name }}</p>
                                            </a>
                                    </div>
                                @endif
                            @endforeach

                            {{-- <h2>User Results</h2> --}}
                            @foreach ($results as $result)
                                @if ($result instanceof \App\Models\User)
                                    <div class="flex flex-row">
                                        <p class="mr-2 font-bold">Therapist:</p>
                                        <a href="/therapist/{{ $result->id }}">
                                            <p>{{ $result->name }}</p>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p>No results found for "{{ $query }}".</p>
                        @endif

                    </div>

                @endif

            </div>
        </x-main-container>

    </x-app-layout>

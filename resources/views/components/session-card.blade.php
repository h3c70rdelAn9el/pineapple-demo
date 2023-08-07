<a href="{{ route('session.show', $therapySession->id) }}" class="relative w-full h-20 p-2 m-2 transition-all duration-200 ease-in border border-blue-200 rounded-lg shadow-md bg-blue-50 shadow-blue-100 hover:border hover:border-blue-400 hover:shadow-lg">
    <div class="flex flex-row justify-between w-full ml-1 text-xs">
        <div class="flex flex-col">
            <div class="flex flex-row">
                <p class="mr-1">Client:</p>
                <p>{{ $therapySession->client->preferred_name }}</p>
            </div>

            @if (Auth::user()->admin)
            <div class="flex flex-row">
                <p class="mr-1">Therapist:</p>
                <p>{{ $therapySession->client->user->name }}</p>
            </div>
            @endif
        </div>
        <div class="mr-1 font-light text-right">
            <div>
                <p class="">Session Date:<span class="ml-2">{{ $therapySession->created_at->format('M d Y') }}</span></p>
            </div>

            <div class="">
                <p><span class="mr-2">Session Cost</span>: {{ $therapySession->session_cost }}</p>
            </div>
            <div class="">
                <p>
                    Client Contribution remaining: <span class="ml-2">${{ $therapySession->client->client_contribution - $therapySession->client->therapySessions->sum('session_cost') }}</span>
                </p>
            </div>
        </div>
    </div>
</a>

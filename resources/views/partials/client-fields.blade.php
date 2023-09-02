<div class="flex flex-row items-center justify-between px-4">
    <p class="flex flex-col text-sm font-bold text-left">Client: <span class="text-lg font-bold">{{ $client->preferred_name }}</span>
    </p>
            @if (Auth::user()->admin)
            <a class="h-6 ml-10 text-sm text-blue-600 hover:text-blue-800"
                href="{{ route('clients.edit', $client->id) }}">
                Edit Client
            </a>
        @endif
</div>
<div class="w-2/3 mx-auto border border-gray-400"></div>

<section class="mt-2 text-gray-700">
    <div>
        @if ($client->legal_name)
            <p>{{ $client->legal_name }}</p>
        @else
            <p>Legal Name needed</p>
        @endif
    </div>
    <div>
        <p>Therapist: <span>{{ $client->user->name }}</span></p>
    </div>
    <div>
        @if ($client->client_code)
            <p>Client Code:<span>{{ $client->client_code }}<Client /span>
            </p>
        @else
            <p>Client Code needed</p>
        @endif
    </div>
    <div>
        @if ($client->phone)
            <p>{{ $client->phone }}</p>
        @else
            <p>Phone needed</p>
        @endif
    </div>
    <div>
        @if ($client->contact_method)
            <p>Contact by:<span class="ml-2">{{ $client->contact_method }}</span></p>
        @else
            <p>Contact method needed</p>
        @endif
    </div>
    <div>
        {{-- @if ($client->status)
            <p>{{ $client->status }}</p>
        @else --}}
        {{-- it'a boolean no is 0 yes is 1 --}}
        <p>Client is:
            @if ($client->status === 1)
                <span>Inactive</span>
            @else
                <span>Active</span>
            @endif
        </p>
        {{--
            <p>Status needed</p>
        @endif --}}
    </div>

    <div>
        @if ($client->pronouns)
            <p>{{ $client->pronouns }}</p>
        @else
            <p>Pronouns needed</p>
        @endif
    </div>

    <div>
        @if ($client->sexual_orientation)
            <p>{{ $client->sexual_orientation }}</p>
        @else
            <p>Sexual Orientation needed</p>
        @endif
    </div>
    <div>
        @if ($client->ethnic_group)
            <p>{{ $client->ethnic_group }}</p>
        @else
            <p>Ethnic Group not provided</p>
        @endif
    </div>
    <div>
        @if ($client->home_address_state)
            <p>{{ $client->home_address_state }}</p>
        @else
            <p>Home Address State needed</p>
        @endif
    </div>
    <div>
        @if ($client->home_address_country)
            <p>{{ $client->home_address_country }}</p>
        @else
            <p>Home Address Country needed</p>
        @endif
    </div>

    <div>
        @if ($client->previous_therapy)
            @if ($client->previous_therapy === 1)
                <p>Previous Therapy: Yes</p>
            @else
                <p>Previous Therapy: No</p>
            @endif
        @else
            <p>Previous Therapy not provided</p>
        @endif
    </div>

    <div>
        @if ($client->possible_support_needed)
            <p>{{ $client->possible_support_needed }}</p>
        @else
            <p>Possible Support Needed not provided</p>
        @endif
    </div>

    {{-- client contribution --}}
    <div>
        @if ($client->client_contribution)
            <p>{{ $client->client_contribution }}</p>
        @else
            <p>Client Contribution not provided</p>
        @endif
    </div>

    {{-- additional notes --}}
    <div>
        @if ($client->additional_notes)
            <p>{{ $client->additional_notes }}</p>
        @else
            <p>Additional Notes not provided</p>
        @endif
    </div>
</section>

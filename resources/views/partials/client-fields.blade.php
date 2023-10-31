 <div class="p-1 px-3 mt-2 overflow-x-scroll border border-green-500 rounded-md shadow-md h-[500px] bg-blue-50 shadow-blue-100">
     <h2 class="text-lg font-bold text-center">Client: {{ $client->preferred_name }}</h2>
        @if (auth()->user()->admin == 1)
        <div class="flex flex-row justify-end">
            <a href="{{ route('clients.edit', $id) }}" class="button">Edit</a>
        </div>
        @endif
     @foreach ([
        'Preferred Name' => $client->preferred_name ?: 'Preferred Name needed',
        'Legal Name' => $client->legal_name ?: 'Legal Name needed',
        'Therapist' => $client->user->name,
        'Client Code' => $client->client_code ?: 'Client Code needed',
        'Phone' => $client->phone ?: 'Phone needed',
        'Contact by' => $client->contact_method ?: 'Contact method needed',
        'Client Status' => $client->status === 1 ? 'Inactive' : 'Active',
        'Pronouns' => $client->pronouns ?: 'Pronouns needed',
        'Gender' => $client->gender ?: 'Gender needed',
        'Sexual Orientation' => $client->sexual_orientation ?: 'Sexual Orientation needed',
        'Ethnic Group' => $client->ethnic_group ?: 'Ethnic Group not provided',
        'Home Address State' => $client->home_address_state ?: 'Home Address State needed',
        'Home Address Country' => $client->home_address_country ?: 'Home Address Country needed',
        'Previous Therapy' => $client->previous_therapy === 1 ? ' Yes' : 'No',
        'Possible Support Needed' => $client->possible_support_needed ?: 'Possible Support Needed not provided',
        'Client Contribution' => $client->client_contribution ?: 'Client Contribution not provided',
        'Additional Notes' => $client->additional_notes ?: 'Additional Notes not provided',
    ] as $label => $value)
        <div class="flex flex-row text-sm">
            <div class="w-1/2 p-2 border-b border-r border-gray-400">{{ $label }}:</div>
            <div class="w-1/2 p-2 font-medium border-b border-gray-400">{{ $value }}</div>
        </div>
     @endforeach
 </div>

<x-app-layout>
    <x-main-container>
        <h2 class="mt-2 text-lg font-normal text-center">Edit client: {{ $client->preferred_name }}</h2>
        <div class="w-1/2 mx-auto bg-gray-400 border-b border-gray-400">

        </div>
        <form class="w-1/2 mx-auto" action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input name="_method" type="hidden" value="PUT">

            <x-form_input_div>
                <x-form_label for="client_code">Client Code</x-form_label>
                <x-edit-form-input id="client_code" name="client_code" type="text" value="{{ old('client_code', $client->client_code) }}" />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="preferred_name">Preferred Name</x-form_label>
                <x-edit-form-input id="preferred_name" name="preferred_name" type="text" value="{{ old('preferred_name', $client->preferred_name) }}" />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="legal_name">Legal Name</x-form_label>
                <x-edit-form-input id="legal_name" name="legal_name" type="text" value="{{ old('legal_name', $client->legal_name) }}" />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="pronouns" class="-mt-1">Pronouns</x-form_label>
                <select class="form-select" id="pronouns" name="pronouns" type="text">
                    <option value="" disabled selected hidden>{{ old('pronouns') }}</option>
                    <option {{ old('pronouns', $client->pronouns) == 'they/them/theirs' ? 'selected' : '' }}>
                        they/them/theirs</option>
                    <option {{ old('pronouns', $client->pronouns) == 'she/her/hers' ? 'selected' : '' }}>she/her/hers
                    </option>
                    <option {{ old('pronouns', $client->pronouns) == 'he/him/his' ? 'selected' : '' }}>he/him/his
                    </option>
                    <option {{ old('pronouns', $client->pronouns) == 'per/per/pers' ? 'selected' : '' }}>per/per/pers
                    </option>
                    <option {{ old('pronouns', $client->pronouns) == 'ze/hir/hirs' ? 'selected' : '' }}>ze/hir/hirs
                    </option>
                    <option {{ old('pronouns', $client->pronouns) == 'prefer not to say' ? 'selected' : '' }}>prefer
                        not to say</option>
                    <option {{ old('pronouns', $client->pronouns) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </x-form_input_div>


            <x-form_input_div>
                <x-form_label for="sexual_orientation">Sexual Orientation</x-form_label>
                <select class="form-select" id="sexual_orientation" name="sexual_orientation" type="text">
                    <option value="" disabled selected hidden>{{ old('sexual_orientation') }}</option>
                    <option {{ old('sexual_orientation', $client->sexual_orientation) == 'bisexual' ? 'selected' : '' }}>
                        bisexual</option>
                    <option {{ old('sexual_orientation', $client->sexual_orientation) == 'gay/lesbian' ? 'selected' : '' }}>
                        gay/lesbian</option>
                    <option {{ old('sexual_orientation', $client->sexual_orientation) == 'hetrosexaul/straight' ? 'selected' : '' }}>
                        hetrosexaul/straight</option>
                    <option {{ old('sexual_orientation', $client->sexual_orientation) == "don't know" ? 'selected' : '' }}>
                        don't know</option>
                    <option {{ old('sexual_orientation', $client->sexual_orientation) == 'prefer not to say' ? 'selected' : '' }}>
                        prefer not to say</option>
                    <option {{ old('sexual_orientation', $client->sexual_orientation) == 'Other' ? 'selected' : '' }}>
                        Other</option>
                </select>
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="ethnic_group">Ethnic Group</x-form_label>
                <select class="form-select" id="ethnic_group" name="ethnic_group" type="text">
                    <option value="" disabled selected hidden>{{ old('ethnic_group') }}</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'American Indian or Alaska Native' ? 'selected' : '' }}>
                        American Indian or Alaska Native</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'Asian' ? 'selected' : '' }}>Asian
                    </option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'Black or African American' ? 'selected' : '' }}>
                        Black or African American</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'Hispanic or Latino' ? 'selected' : '' }}>
                        Hispanic or Latino</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'Native Hawaiian or Other Pacific Islander' ? 'selected' : '' }}>
                        Native Hawaiian or Other Pacific Islander</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'White' ? 'selected' : '' }}>White
                    </option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'prefer not to say' ? 'selected' : '' }}>
                        prefer not to say</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'Other' ? 'selected' : '' }}>Other
                    </option>
                </select>
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="home_address_state">State (optional)</x-form_label>
                <select class="w-full p-2 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="home_address_state" name="home_address_state" type="text" required>
                    <option value="" disabled selected hidden>{{ old('home_address_state', $client->home_address_state) }}</option>
                    @foreach ($states as $state)
                    <option value="{{$state['name']}}">{{ $state['name'] }}</option>
                    @endforeach
                </select>
            </x-form_input_div>

            {{-- <x-form_input_div>
                <x-form_label for="health_coverage_provider">Health Coverage Provider</x-form_label>
                <x-edit-form-input id="health_coverage_provider" name="health_coverage_provider" type="text" value="{{ old('health_coverage_provider', $client->health_coverage_provider) }}" />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="health_coverage_number">Health Coverage Number</x-form_label>
                <x-edit-form-input id="health_coverage_number" name="health_coverage_number" type="text" value="{{ old('health_coverage_number', $client->health_coverage_number) }}" />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="health_coverage_expiration">Health Coverage Expiration</x-form_label>
                <x-edit-form-input id="health_coverage_expiration" name="health_coverage_expiration" type="text" value="{{ old('health_coverage_expiration', $client->health_coverage_expiration) }}" />
            </x-form_input_div> --}}

            <x-form_input_div>
                <x-form_label for="previous_therapy">Previous Therapy from Pineapple</x-form_label>
                <select class="form-select" id="previous_therapy" name="previous_therapy" type="text">
                    <option value="" disabled selected hidden>
                        @php
                        $previousTherapy = old('previous_therapy', $client->previous_therapy);
                        $displayText = $previousTherapy ? 'Yes' : 'No';
                        @endphp
                        {{ $displayText }}
                    </option>
                    <option {{ old('previous_therapy', $client->previous_therapy) == 'Yes' ? 'selected' : '' }}>Yes
                    </option>
                    <option {{ old('previous_therapy', $client->previous_therapy) == 'No' ? 'selected' : '' }}>No
                    </option>
                </select>
            </x-form_input_div>


            {{-- Possible Support Needed --}}
            <div x-data="{ showDropdown: false }" class="relative w-full mt-6 mb-4">
                <x-form_label for="possible_support_needed">
                    Possible Support Needed
                </x-form_label>
                <div class="rounded-md" @click.away="showDropdown = false">
                    <div class="flex justify-between w-full p-1.5 bg-white border border-blue-200 rounded-md">
                        Select Options
                        <button type="button" @click="showDropdown = !showDropdown" class="">
                            <svg class="w-[18px] h-[18px] text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <div x-show="showDropdown" class="rounded-md bg-gray-50 md:flex md:flex-wrap" x-transition.scale.origin.top x-cloak>
                        @foreach ($categories as $category)
                        <label class="items-center p-2">
                            <input type="checkbox" class="rounded-md mb-0.5 hover:bg-blue-300 transition-all duration-300" name="possible_support_needed[]" value="{{ $category }}" @if(is_array(old('possible_support_needed')) && in_array($category, old('possible_support_needed'))) checked @endif>
                            {{ $category }}
                        </label><br>
                        @endforeach
                    </div>
                </div>
            </div>



            {{-- <x-form_input_div>
                <x-form_label for="preferred_language">Preferred Language</x-form_label>
                <select id="preferred_language" type="text" name="preferred_language" class="w-full p-3 text-gray-600 border-b-2 border-blue-200 rounded-md peer ring-0">
                    <option value="" disabled selected hidden>{{ old('preferred_language') }}</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'English' ? 'selected' : '' }}>English</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'Spanish' ? 'selected' : '' }}>Spanish</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'French' ? 'selected' : '' }}>French</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'German' ? 'selected' : '' }}>German</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'Chinese' ? 'selected' : '' }}>Chinese</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'Japanese' ? 'selected' : '' }}>Japanese</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'prefer not to say' ? 'selected' : '' }}>prefer not to say</option>
            <option {{ old('preferred_language', $client->preferred_language) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            </x-form_input_div> --}}

            <x-form_input_div>
                <x-form_label for="email" class="-mt-2">Email</x-form_label>
                <x-edit-form-input id="email" name="email" type="text" value="{{ old('email', $client->email) }}" />
            </x-form_input_div>


            <x-form_input_div>
                <x-form_label for="country">
                    Country
                </x-form_label>
                <select class="w-full p-2 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="home_address_country" name="home_address_country" type="text" required>
                    <option value="" disabled selected hidden>{{ old('home_address_country', $client->home_address_country) }}</option>
                    @foreach ($countries as $country)
                    <option value="{{$country['code']}}">{{ $country['name'] }}</option>
                    @endforeach
                </select>
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="phone">
                    Phone
                </x-form_label>
                <x-edit-form-input id="phone" value="{{ old('phone', $client->phone) }}" name="phone" type="tel" required />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="contact_method">Contact Method</x-form_label>
                <select class="p-2 form-select" id="contact_method" name="contact_method" type="text">
                    <option value="" disabled selected hidden>
                        {{ old('contact_method', $client->contact_method) }}</option>
                    </option>
                    <option {{ old('contact_method', $client->contact_method) == 'Telephone Call' ? 'selected' : '' }}>
                        Telephone Call</option>
                    <option {{ old('contact_method', $client->contact_method) == 'TextMessage' ? 'selected' : '' }}>
                        Text Message</option>
                    <option {{ old('contact_method', $client->contact_method) == 'Email' ? 'selected' : '' }}>Email
                    </option>
                </select>
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="client_contribution">Client Contribution</x-form_label>
                <x-edit-form-input id="client_contribution" name="client_contribution" type="text" value="{{ old('client_contribution', $client->client_contribution) }}" />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="additional_notes">Additional Notes</x-form_label>
                <textarea class="w-full border-blue-300 rounded-md focus:ring-blue-300" id="additional_notes" name="additional_notes" type="text" value="{{ old('additional_notes', $client->additional_notes) }}"></textarea>
            </x-form_input_div>

            <x-jet-button class="ml-4" type="submit">
                {{ __('Update') }}
            </x-jet-button>
        </form>
    </x-main-container>
</x-app-layout>

<script src="{{ asset('js/intlTelInput.js') }}"></script>
<script src="{{ asset('js/utils.js') }}"></script>

<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        initialCountry: "us"
        , separateDialCode: true
        , utilsScript: "{{ asset('js/utils.js') }}"
    , });

</script>

<x-app-layout>
    <x-main-container>
        <form class="w-1/2 mx-auto" action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input name="_method" type="hidden" value="PUT">

            <x-edit-form-input id="client_code" name="client_code" type="text"
                value="{{ old('client_code', $client->client_code) }}" placeholder="Client code" />
            <x-form_input_div>
                <x-form_label for="preferred_name">Preferred Name</x-form_label>
                <x-edit-form-input class="font-normal opacity-60" id="preferred_name" name="preferred_name"
                    type="text" value="{{ old('preferred_name', $client->preferred_name) }}" />
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="legal_name">Legal Name</x-form_label>
                <x-edit-form-input id="legal_name" name="legal_name" type="text"
                    value="{{ old('legal_name', $client->legal_name) }}" />
            </x-form_input_div>
            <x-form_input_div>
                <x-form_label for="sexual_orientation">Sexual Orientation</x-form_label>
                <select class="w-full px-3 py-2 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
                    id="sexual_orientation" name="sexual_orientation" type="text">
                    <option value="" disabled selected hidden>{{ old('sexual_orientation') }}</option>
                    <option
                        {{ old('sexual_orientation', $client->sexual_orientation) == 'bisexual' ? 'selected' : '' }}>
                        bisexual</option>
                    <option
                        {{ old('sexual_orientation', $client->sexual_orientation) == 'gay/lesbian' ? 'selected' : '' }}>
                        gay/lesbian</option>
                    <option
                        {{ old('sexual_orientation', $client->sexual_orientation) == 'hetrosexaul/straight' ? 'selected' : '' }}>
                        hetrosexaul/straight</option>
                    <option
                        {{ old('sexual_orientation', $client->sexual_orientation) == "don't know" ? 'selected' : '' }}>
                        don't know</option>
                    <option
                        {{ old('sexual_orientation', $client->sexual_orientation) == 'prefer not to say' ? 'selected' : '' }}>
                        prefer not to say</option>
                    <option {{ old('sexual_orientation', $client->sexual_orientation) == 'Other' ? 'selected' : '' }}>
                        Other</option>
                </select>
            </x-form_input_div>

            <x-form_input_div>
                <x-form_label for="ethnic_group">Ethnic Group</x-form_label>
                <select class="w-full px-3 py-2 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
                    id="ethnic_group" name="ethnic_group" type="text">
                    <option value="" disabled selected hidden>{{ old('ethnic_group') }}</option>
                    <option
                        {{ old('ethnic_group', $client->ethnic_group) == 'American Indian or Alaska Native' ? 'selected' : '' }}>
                        American Indian or Alaska Native</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'Asian' ? 'selected' : '' }}>Asian
                    </option>
                    <option
                        {{ old('ethnic_group', $client->ethnic_group) == 'Black or African American' ? 'selected' : '' }}>
                        Black or African American</option>
                    <option {{ old('ethnic_group', $client->ethnic_group) == 'Hispanic or Latino' ? 'selected' : '' }}>
                        Hispanic or Latino</option>
                    <option
                        {{ old('ethnic_group', $client->ethnic_group) == 'Native Hawaiian or Other Pacific Islander' ? 'selected' : '' }}>
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
                    <x-edit-form-input id="home_address_state" name="home_address_state" type="text" value="{{ old('home_address_state', $client->home_address_state) }}" />
                {{-- TODO: ADD SELECT FIELDS FOR STATES --}}
                {{-- <select class="w-full px-3 py-2 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
                    id="home_address_state" name="home_address_state" type="text">
                    <option value="" disabled selected hidden>Select State</option>
                    <option
                        {{ old('home_address_state', $client->home_address_state) == 'Alabama' ? 'selected' : '' }}>
                        Alabama</option>
                    <option {{ old('home_address_state', $client->home_address_state) == 'Alaska' ? 'selected' : '' }}>
                        Alaska</option>
                    <option
                        {{ old('home_address_state', $client->home_address_state) == 'American Samoa' ? 'selected' : '' }}>
                        American Samoa</option>
                    <option
                        {{ old('home_address_state', $client->home_address_state) == 'Arizona' ? 'selected' : '' }}>
                        Arizona</option>
                    <option
                        {{ old('home_address_state', $client->home_address_state) == 'Arkansas' ? 'selected' : '' }}>
                        Arkansas</option>


                    <!-- Add remaining states following the same pattern -->
                    <option {{ old('home_address_state', $client->home_address_state) == 'Wyoming' ? 'selected' : '' }}>
                        Wyoming</option>


                </select> --}}
            </x-form_input_div>

            <!-- health_coverage_provider -->
            <x-form_input_div>
                <x-form_label for="health_coverage_provider">Health Coverage Provider</x-form_label>
                <x-edit-form-input id="health_coverage_provider" name="health_coverage_provider" type="text"
                    value="{{ old('health_coverage_provider', $client->health_coverage_provider) }}" />
            </x-form_input_div>

            <!-- health_coverage_number -->
            <x-form_input_div>
                <x-form_label for="health_coverage_number">Health Coverage Number</x-form_label>
                <x-edit-form-input id="health_coverage_number" name="health_coverage_number" type="text"
                    value="{{ old('health_coverage_number', $client->health_coverage_number) }}" />
            </x-form_input_div>

            <!-- health_coverage_expiration -->
            <x-form_input_div>
                <x-form_label for="health_coverage_expiration">Health Coverage Expiration</x-form_label>
                <x-edit-form-input id="health_coverage_expiration" name="health_coverage_expiration" type="text"
                    value="{{ old('health_coverage_expiration', $client->health_coverage_expiration) }}" />
            </x-form_input_div>

            <!-- previous_therapy -->
            <x-form_input_div>
                <x-form_label for="previous_therapy">Previous Therapy</x-form_label>
                <x-edit-form-input id="previous_therapy" name="previous_therapy" type="text"
                    value="{{ old('previous_therapy', $client->previous_therapy == 1 ? 'Yes' : 'No') }}" />
            </x-form_input_div>

            <!-- possible_support_needed -->
            <x-form_input_div>
                <x-form_label for="possible_support_needed">Possible Support Needed</x-form_label>
                <x-edit-form-input id="possible_support_needed" name="possible_support_needed" type="text"
                    value="{{ old('possible_support_needed', $client->possible_support_needed) }}" />
            </x-form_input_div>

            <!-- preferred_language -->
            <x-form_input_div>
                <x-form_label for="preferred_language">Preferred Language</x-form_label>
                <x-edit-form-input id="preferred_language" name="preferred_language" type="text"
                    value="{{ old('preferred_language', $client->preferred_language) }}" />
            </x-form_input_div>

            <!-- additional_notes -->
            <x-form_input_div>
                <x-form_label for="additional_notes">Additional Notes</x-form_label>
                <textarea class="w-full border-blue-300 rounded-md focus:ring-blue-300" id="additional_notes" name="additional_notes"
                    type="text" value="{{ old('additional_notes', $client->additional_notes) }}"></textarea>
            </x-form_input_div>

            <!-- pronouns -->
            <x-form_input_div>
                <x-form_label for="pronouns">Pronouns</x-form_label>
                <select class="w-full px-3 py-2 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="pronouns"
                    name="pronouns" type="text">
                    <option value="" disabled selected hidden>Select Pronouns</option>
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

            <!-- email -->
            <x-form_input_div>
                <x-form_label for="email">Email</x-form_label>
                <x-edit-form-input id="email" name="email" type="text"
                    value="{{ old('email', $client->email) }}" placeholder="email@example.com" />
            </x-form_input_div>

            <!-- phone -->
            <x-form_input_div>
                <x-form_label for="phone">Phone</x-form_label>
                <x-edit-form-input id="phone" name="phone" type="text"
                    value="{{ old('phone', $client->phone) }}" x-data x-mask="(999)999-9999"
                    placeholder="(xxx)xxx-xxxx" />
            </x-form_input_div>

            <!-- contact_method -->
            <x-form_input_div>
                <x-form_label for="contact_method">Contact Method</x-form_label>
                <select class="w-full px-3 py-2 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
                    id="contact_method" name="contact_method" type="text">
                    <option value="" disabled selected hidden>Preferred Contact Method</option>
                    <option {{ old('contact_method', $client->contact_method) == 'Telephone Call' ? 'selected' : '' }}>
                        Telephone Call</option>
                    <option {{ old('contact_method', $client->contact_method) == 'TextMessage' ? 'selected' : '' }}>
                        Text Message</option>
                    <option {{ old('contact_method', $client->contact_method) == 'Email' ? 'selected' : '' }}>Email
                    </option>
                </select>
            </x-form_input_div>

            <button type="submit">update client</button>

            <x-jet-button class="ml-4" type="submit">
                {{ __('Update') }}
            </x-jet-button>

        </form>
    </x-main-container>
</x-app-layout>

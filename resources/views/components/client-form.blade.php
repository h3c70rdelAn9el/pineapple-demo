{{-- ! commented code out are fields they wanted ommitted. I kept them in place incase someone decides to put them back --}}
<form class="z-50 w-5/6 h-full p-4 mx-auto mt-2 mb-4 bg-blue-200 border border-blue-600 rounded-md shadow-lg md:w-2/3" style="z-index: 99999;" action="{{ route('client.store') }}" method="POST">
    @csrf
    <x-form_input_div>
        <x-form_label for="client_code">
            Client Code
        </x-form_label>
        <x-form_input id="client_code" name="client_code" type="text" required placeholder="Client code" />
    </x-form_input_div>

    {{-- Legal Name --}}
    <x-form_input_div>
        <x-form_label for="legal_name">
            Legal Name
        </x-form_label>
        <x-form_input id="legal_name" name="legal_name" type="text" required placeholder="Legal name" />
    </x-form_input_div>

    {{-- Preferred Name --}}
    <x-form_input_div>
        <x-form_label for="preferred_name">
            Preferred Name
        </x-form_label>
        <x-form_input id="preferred_name" name="preferred_name" type="text" required placeholder="Preferred name" />
    </x-form_input_div>

    {{-- Pronouns --}}
    <x-form_input_div>
        <x-form_label for="pronouns">
            Pronouns
        </x-form_label>
        <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="pronouns" name="pronouns" type="text" required>
            <option value="" disabled selected hidden>Select Pronouns</option>
            <option>they/them/theirs</option>
            <option>she/her/hers</option>
            <option>he/him/his</option>
            <option>per/per/pers</option>
            <option>ze/hir/hirs</option>
            <option>prefer not to say</option>
            <option>Other</option>
        </select>
    </x-form_input_div>

    {{-- Sexual Orientation --}}
    <x-form_input_div>
        <x-form_label for="sexual_orientation">
            Sexual Orientation
        </x-form_label>
        <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="sexual_orientation" name="sexual_orientation" type="text" required>
            <option value="" disabled selected hidden>Select Orientation</option>
            <option>bisexual</option>
            <option>gay/lesbian</option>
            <option>hetrosexaul/straight</option>
            <option>don't know</option>
            <option>prefer not to say</option>
            <option>Other</option>
        </select>
    </x-form_input_div>

    {{-- ethnic_group --}}
    <x-form_input_div>
        <x-form_label for="ethnic_group">
            Ethnic Group
        </x-form_label>
        <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="ethnic_group" name="ethnic_group" type="text" required>
            <option value="" disabled selected hidden>Select Ethnic Group</option>
            <option>American Indian or Alaska Native</option>
            <option>Asian</option>
            <option>Black or African American</option>
            <option>Hispanic or Latino</option>
            <option>Native Hawaiian or Other Pacific Islander</option>
            <option>White</option>
            <option>prefer not to say</option>
            <option>Other</option>
        </select>
    </x-form_input_div>

    {{-- home_address_line_1 --}}
    {{-- <x-form_input_div>
        <x-form_label for="home_address_line_1">
            Address Line 1
        </x-form_label>
        <x-form_input id="home_address_line_1" type="text" name="home_address_line_1" required
                      placeholder="Home Address Line 1" />
    </x-form_input_div> --}}

    {{-- home_address_line_2 --}}
    {{-- <x-form_input_div>
        <x-form_label for="home_address_line_2">
            Address Line 2
        </x-form_label>
        <x-form_input id="home_address_line_2" type="text" name="home_address_line_2"
                      placeholder="Home Address Line 2" />
    </x-form_input_div> --}}

    {{-- home_address_city --}}
    {{-- <x-form_input_div>
        <x-form_label for="home_address_city">
            City
        </x-form_label>
        <x-form_input id="home_address_city" type="text" name="home_address_city" required placeholder="City" />
    </x-form_input_div> --}}

    {{-- home_address_state --}}
    <x-form_input_div>
        <x-form_label for="home_address_state">
            State (optional)
        </x-form_label>
        <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="home_address_state" name="home_address_state" type="text">
            <option value="" disabled selected hidden>Select State</option>
            @foreach ($states as $state)
            <option value="{{$state['name']}}">{{ $state['name'] }}</option>
            @endforeach
        </select>
    </x-form_input_div>

    {{-- home_address_zip --}}
    {{-- <x-form_input_div>
        <x-form_label for="home_address_zip">
            Zip Code
        </x-form_label>
        <x-form_input id="home_address_zip" type="text" name="home_address_zip" required placeholder="Zip Code" />
    </x-form_input_div> --}}

    <x-form_input_div>
        <x-form_label for="country">
            Country
        </x-form_label>
        <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="home_address_country" name="home_address_country" type="text" required>
            <option value="" disabled selected hidden>Select Country</option>
            @foreach ($countries as $country)
            <option value="{{$country['code']}}">{{ $country['name'] }}</option>
            @endforeach
        </select>
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="email">
            Email
        </x-form_label>
        <x-form_input id="email" name="email" type="text" required placeholder="email@example.com" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="phone">
            Phone
        </x-form_label>
        <x-form_input id="phone" name="phone" type="tel" required />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="contact_method">
            Contact Method
        </x-form_label>
        <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="contact_method" name="contact_method" type="text" required>
            <option value="" disabled selected hidden>Select Contact Method</option>
            <option>Telephone Call</option>
            <option>Text Message</option>
            <option>Email</option>
        </select>
    </x-form_input_div>

    {{-- <x-form_input_div>
        <x-form_label for="health_coverage_provider">
            Health Coverage Provider
        </x-form_label>
        <x-form_input id="health_coverage_provider" type="text" name="health_coverage_provider" required
                      placeholder="Health Coverage Provider" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="health_coverage_number">
            Health Coverage Number
        </x-form_label>
        <x-form_input id="health_coverage_number" type="text" name="health_coverage_number" required
                      placeholder="Health Coverage Number" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="health_coverage_expiration">
            Health Coverage Expiration
        </x-form_label>
        <input type="date" required id="health_cover_expiration" name="health_coverage_expiration">
    </x-form_input_div> --}}

    {{-- Previous therapy --}}
    <x-form_input_div>
        <x-form_label for="previous_therapy">Previous Therapy from Pineapple</x-form_label>
        <select class="p-3 form-select" id="previous_therapy" name="previous_therapy" type="text">
            <option value="" disabled selected hidden>Select One</option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </x-form_input_div>


    {{-- possible_support_needed --}}
    <div x-data="{ showDropdown: false }" class="relative w-full mt-6 mb-4">
        <x-form_label for="possible_support_needed">
            Possible Support Needed
        </x-form_label>
        <div class="rounded-md" @click.away="showDropdown = false">
            <div class="flex justify-between w-full p-3 bg-gray-100 rounded-md">
                Select Options
                <button type="button" @click="showDropdown = !showDropdown" class="">
                    <svg class="w-[18px] h-[18px] text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>
            </div>
            <div x-show="showDropdown" class="rounded-md bg-gray-50 md:flex md:flex-wrap" x-transition.scale.origin.left x-cloak>
                @foreach ($categories as $category)
                <label class="items-center p-2">
                    <input type="checkbox" class="rounded-md mb-0.5 hover:bg-blue-300 transition-all duration-300" name="possible_support_needed[]" value="{{ $category }}">
                    {{ $category }}
                </label><br>
                @endforeach
            </div>
        </div>
    </div>

    <x-form_input_div>
        <x-form_label for="client_contribution">
            Client Contribution
        </x-form_label>
        <x-form_input id="client_contribution" name="client_contribution" type="number" required placeholder="xxx" inputmode="numeric" pattern="[0-9]*" />
    </x-form_input_div>

    {{-- preferred_language --}}
    {{-- <x-form_input_div>
        <x-form_label for="preferred_language">
            Preferred Language
        </x-form_label>
        <select id="preferred_language" type="text" name="preferred_language"
                class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" required>
            <option value="" disabled selected hidden>Please Select:</option>
            <option>English</option>
            <option>Spanish</option>
            <option>French</option>
            <option>German</option>
            <option>Italian</option>
            <option>Portuguese</option>
            <option>Chinese</option>
            <option>Japanese</option>
            <option>Arabic</option>
            <option>Other</option>
        </select>
    </x-form_input_div> --}}

    <x-form_input_div>
        <x-form_label for="therapist">
            Therapist
        </x-form_label>
        <select class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0" id="user_id" name="user_id" required>
            <option value="" disabled selected hidden>Therapist</option>
            @foreach ($therapists as $row)
            <option value="{{ $row->id }}">
                {{ $row->name }}
            </option>
            @endforeach
        </select>
    </x-form_input_div>

    <div class="flex mt-2">
        <button class="mx-auto button-secondary">Add</button>
    </div>
</form>

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

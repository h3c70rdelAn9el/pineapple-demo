<form action="{{ route('client.store') }}"
    class="z-50 p-4 mt-2 overflow-scroll bg-blue-200 border border-blue-600 rounded-md shadow-lg h-[700px]">
    @csrf
    <x-form_input_div>
        <x-form_label for="client_code">
            Client Code
        </x-form_label>
        <x-form_input id="client_code"
            type="text"
            required
            name="client_code"
            placeholder="Client code" />
    </x-form_input_div>

    {{-- Legal Name  --}}
    <x-form_input_div>
        <x-form_label for="legal_name">
            Legal Name
        </x-form_label>
        <x-form_input id="legal_name"
            type="text"
            name="legal_name"
            required
            placeholder="Legal name" />
    </x-form_input_div>

    {{-- Preferred Name --}}
    <x-form_input_div>
        <x-form_label for="preferred_name">
            Preferred Name
        </x-form_label>
        <x-form_input id="preferred_name"
            type="text"
            name="preferred_name"
            required
            placeholder="Preferred name" />
    </x-form_input_div>

    {{-- Pronouns --}}
    <x-form_input_div>
        <x-form_label for="pronouns">
            Pronouns
        </x-form_label>
        <select type="text"
            id="pronouns"
            required
            name="pronouns"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0">
            <option value=""
                disabled
                selected
                hidden>Select Pronouns</option>
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
        <select type="text"
            id="sexual_orientation"
            required
            name="sexual_orientation"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0">
            <option value=""
                disabled
                selected
                hidden>Select Orientation</option>
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
        <select type="text"
            id="ethnic_group"
            required
            name="ethnic_group"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0">
            <option value=""
                disabled
                selected
                hidden>Select Ethnic Group</option>
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
    <x-form_input_div>
        <x-form_label for="home_address_line_1">
            Address Line 1
        </x-form_label>
        <x-form_input id="home_address_line_1"
            type="text"
            name="home_address_line_1"
            required
            placeholder="Home Address Line 1" />
    </x-form_input_div>

    {{-- home_address_line_2 --}}
    <x-form_input_div>
        <x-form_label for="home_address_line_2">
            Address Line 2
        </x-form_label>
        <x-form_input id="home_address_line_2"
            type="text"
            name="home_address_line_2"
            placeholder="Home Address Line 2" />
    </x-form_input_div>

    {{-- home_address_city --}}
    <x-form_input_div>
        <x-form_label for="home_address_city">
            City
        </x-form_label>
        <x-form_input id="home_address_city"
            type="text"
            name="home_address_city"
            required
            placeholder="City" />
    </x-form_input_div>

    {{-- home_address_state --}}
    <x-form_input_div>
        <x-form_label for="home_address_state">
            State
        </x-form_label>
        <select type="text"
            id="home_address_state"
            required
            name="home_address_state"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0">
            <option value=""
                disabled
                selected
                hidden>Select State</option>
            {{-- TODO: RETRIEVE FROM JSON FILE SUCCESSFULLY --}}


            <option>Alabama</option>
            <option>Alaska</option>
            <option>Arizona</option>
            <option>Arkansas</option>
            <option>California</option>
            <option>Colorado</option>
            <option>Connecticut</option>
            <option>Delaware</option>
            <option>Florida</option>
            <option>Georgia</option>
            <option>Hawaii</option>
            <option>Idaho</option>
            <option>Illinois</option>
            <option>Indiana</option>
            <option>Iowa</option>
            <option>Kansas</option>
            <option>Kentucky</option>
            <option>Louisiana</option>
            <option>Maine</option>
            <option>Maryland</option>
            <option>Massachusetts</option>
            <option>Michigan</option>
            <option>Minnesota</option>
            <option>Mississippi</option>
            <option>Missouri</option>
            <option>Montana</option>
            <option>Nebraska</option>
            <option>Nevada</option>
            <option>New Hampshire</option>
            <option>New Jersey</option>
            <option>New Mexico</option>
            <option>New York</option>
            <option>North Carolina</option>
            <option>North Dakota</option>
            <option>Ohio</option>
            <option>Oklahoma</option>
            <option>Oregon</option>
            <option>Pennsylvania</option>
            <option>Rhode Island</option>
            <option>South Carolina</option>
            <option>South Dakota</option>
            <option>Tennessee</option>
            <option>Texas</option>
            <option>Utah</option>
            <option>Vermont</option>
            <option>Virginia</option>
            <option>Washington</option>
            <option>West Virginia</option>
            <option>Wisconsin</option>
            <option>Wyoming</option>
        </select>
    </x-form_input_div>

    {{-- home_address_zip --}}
    {{-- <x-form_input_div>
        <x-form_label for="home_address_zip">
            Zip Code
        </x-form_label>
        <x-form_input id="home_address_zip"
            type="text"
            name="home_address_zip"
            required
            placeholder="Zip Code" />
    </x-form_input_div> --}}

    {{-- home_address_country --}}
    <x-form_input_div>
        <x-form_label for="home_address_country">
            Country
        </x-form_label>
        <x-form_input id="home_address_country"
            type="text"
            name="home_address_country"
            required
            placeholder="Country" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="email">
            Email
        </x-form_label>
        <x-form_input id="email"
            type="text"
            name="email"
            required
            placeholder="email@example.com" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="phone">
            Phone
        </x-form_label>
        <x-form_input x-data
            id="phone"
            type="text"
            name="phone"
            x-mask="(999)999-9999"
            placeholder="(xxx)xxx-xxxx"
            required />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="contact_method">
            Contact Method
        </x-form_label>
        <select id="contact_method"
            type="text"
            name="contact_method"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
            required>
            <option value=""
                disabled
                selected
                hidden>Preferred Contact Method</option>
            <option>Telephone Call</option>
            <option>Text Message</option>
            <option>Email</option>
        </select>
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="health_coverage_provider">
            Health Coverage Provider
        </x-form_label>
        <x-form_input id="health_coverage_provider"
            type="text"
            name="health_coverage_provider"
            required
            placeholder="Health Coverage Provider" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="health_coverage_number">
            Health Coverage Number
        </x-form_label>
        <x-form_input id="health_coverage_number"
            type="text"
            name="health_coverage_number"
            required
            placeholder="Health Coverage Number" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="health_coverage_expiration">
            Health Coverage Expiration
        </x-form_label>
        <input type="date"
            required
            id="health_cover_expiration"
            name="health_coverage_expiration">
    </x-form_input_div>

    {{-- Previous therapy --}}
    <x-form_input_div>
        <x-form_label for="previous_therapy">
            Previous therapy
        </x-form_label>
        <input type="radio"
            id="yes"
            name="previous_therapy"
            value="1">
        <label for="yes">Yes</label><br>
        <input type="radio"
            id="no"
            name="previous_therapy"
            value="0">
        <label for="no">No</label><br>
    </x-form_input_div>

    {{-- TODO: PUT THE OPTIONS IN A JSON FILE --}}
    {{-- possible_support_needed --}}
    <x-form_input_div>
        <x-form_label for="possible_support_needed">
            Possible Support Needed
        </x-form_label>
        <select id="possible_support_needed"
            type="text"
            name="possible_support_needed"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
            required>
            <option value=""
                disabled
                selected
                hidden>Please Select:</option>
            <option>ADHD</option>
            <option>Adjustment Issues</option>
            <option>Adoption</option>
            <option>Anger</option>
            <option>Anxiety</option>
            <option>Autism Spectrum</option>
            <option>Bipolar Disorder</option>
            <option>Chronic Illness</option>
            <option>Chronic Pain</option>
            <option>Codependency</option>
            <option>Depression</option>
            <option>Divorce</option>
            <option>Domestic Violence</option>
            <option>Eating Disorders</option>
            <option>Family Conflict</option>
            <option>Family of Origin Issues</option>
            <option>Gambling</option>
            <option>Grief and Loss</option>
            <option>HIV/AIDS</option>
            <option>Hoarding</option>
            <option>Impuslivity</option>
            <option>Intellectual and Developmental Disabilities</option>
            <option>LGBTQ</option>
            <option>Life Coaching</option>
            <option>Life Transitions</option>
            <option>Obesity</option>
            <option>Obsessive Compulsive Disorder</option>
            <option>Parenting</option>
            <option>Personality Disorders</option>
            <option>Psychosis</option>
            <option>Racial Identity</option>
            <option>Relationship Issues</option>
            <option>Self-Esteem</option>
            <option>Self-Harm</option>
            <option>Sex Addiction/Issues</option>
            <option>Sexual Assault</option>
            <option>Sleep Issues</option>
            <option>Spirituality</option>
            <option>Stress</option>
            <option>Substance Use - Sober Only - </option>
            <option>Substance Use - Harm Reduction</option>
            <option>Trauma/Post-Traumatic Stress Disorder</option>
            <option>Weight Loss</option>
            <option>Women's Issues</option>
            <option>Other</option>
        </select>
    </x-form_input_div>

    {{-- preferred_language --}}
    <x-form_input_div>
        <x-form_label for="preferred_language">
            Preferred Language
        </x-form_label>
        <select id="preferred_language"
            type="text"
            name="preferred_language"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
            required>
            <option value=""
                disabled
                selected
                hidden>Please Select:</option>
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
    </x-form_input_div>

    {{-- TODO: ASSIGN TO PROPER THERAPIST --}}
    <x-form_input_div>
        <x-form_label for="therapist">
            Therapist
        </x-form_label>
        <select id="user_id"
            name="user_id"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
            required>
            <option value=""
                disabled
                selected
                hidden>Therapist</option>
            @foreach ($therapists as $row)
                <option value="{{ $row->id }}">
                    {{ $row->name }}
                </option>
            @endforeach
        </select>
    </x-form_input_div>

    <div class="mt-2">
        <button type="submit"
            class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110">
            Add
        </button>
    </div>
</form>

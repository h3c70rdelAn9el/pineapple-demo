<form action="{{ route('client.store') }}"
    class="z-50 p-4 mt-2 bg-blue-200 border border-blue-600 rounded-md shadow-lg">
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
                hidden>Pronouns</option>
            <option>they/them/theirs</option>
            <option>she/her/hers</option>
            <option>he/him/his</option>
            <option>per/per/pers</option>
            <option>ze/hir/hirs</option>
            <option>prefer not to say</option>
            <option>Other</option>

        </select>
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
        <x-form_label for="therapist">
            Therapist
        </x-form_label>
        <select id="therapist"
            name="therapist"
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

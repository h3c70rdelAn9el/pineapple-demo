<form action="{{ route('client.store') }}"
    class="p-4 mt-2">
    @csrf
    <x-form_input_div>
        <x-form_label for="client_code">
            Client Code
        </x-form_label>
        <x-form_input id="client_code"
            type="text"
            name="client_code"
            placeholder="Client code" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="chosen_name">
            Chosen Name
        </x-form_label>
        <x-form_input id="chosen_name"
            type="text"
            name="chosen_name"
            placeholder="Chosen name" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="pronouns">
            Pronouns
        </x-form_label>
        <select x-model="pronouns"
            id="pronouns"
            name="pronouns"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0"
            placeholder="Pronouns">
            <option value=""
                disabled
                selected
                hidden>Pronouns:</option>
            <option>He/Him</option>
            <option>She/Her</option>
            <option>They/Them</option>
            <option>Ze</option>
            <option>Chosen Name</option>
        </select>
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="email">
            Email
        </x-form_label>
        <x-form_input id="email"
            type="text"
            name="email"
            placeholder="email@example.com" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="phone">
            Phone
        </x-form_label>
        <x-form_input id="phone"
            type="text"
            name="phone"
            placeholder="(xxx)xxx-xxxx" />
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="contact_method">
            Contact Method
        </x-form_label>
        <select id="contact_method"
            type="text"
            name="contact_method"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0">
            <option value=""
                disabled
                selected
                hidden>Preferred Contact Method</option>
            <option>Phone</option>
            <option>Text</option>
            <option>Email</option>
        </select>
    </x-form_input_div>

    <x-form_input_div>
        <x-form_label for="therapist">
            Therapist
        </x-form_label>
        <select id="therapist"
            name="therapist"
            class="w-full p-3 mt-2 border-b-2 border-blue-200 rounded-md peer ring-0">
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

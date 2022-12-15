<form action="{{ route('client.store') }}"
    class="p-4 mt-2">
    @csrf
    <x-form_input_div>
        <x-form_input id="client_code"
            type="text"
            name="client_code"
            class=""
            placeholder="Client code"
            wire:model.defer="state.client_code" />
        <x-form_label for="client_code">
            Client Code
        </x-form_label>
    </x-form_input_div>

    <x-form_input_div>
        <x-form_input id="chosen_name"
            type="text"
            name="chosen_name"
            placeholder="Chosen name" />
        <x-form_label for="chosen_name">
            Chosen Name
        </x-form_label>
    </x-form_input_div>
    <x-form_input_div>
        <x-form_input id="pronouns"
            type="pronouns"
            name="pronouns"
            placeholder="Pronouns" />
        <x-form_label for="pronouns">
            Pronouns
        </x-form_label>
    </x-form_input_div>
    <x-form_input_div>
        <x-form_input id="email"
            type="text"
            name="email"
            placeholder="Email" />
        <x-form_label for="email">
            Email
        </x-form_label>
    </x-form_input_div>
     <x-form_input_div>
        <x-form_input id="phone"
            type="text"
            name="phone"
            placeholder="Phone" />
        <x-form_label for="phone">
            Phone
        </x-form_label>
    </x-form_input_div>
    <x-form_input_div>
        <x-form_input id="contact_method"
            type="text"
            name="contact_method"
            placeholder="Contact Method" />
        <x-form_label for="contact_method">
            Contact Method
        </x-form_label>
    </x-form_input_div>
    <x-form_input_div>
        <x-form_input id="user_id"
            type="text"
            name="user_id"
            placeholder="Therapist" />
        <x-form_label for="user_id">
            Therapist
        </x-form_label>
    </x-form_input_div>
    <div class="mt-2">
        <button type="submit"
            class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110">
            Add
        </button>
    </div>
</form>

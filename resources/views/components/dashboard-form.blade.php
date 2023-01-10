<form action="{{ route('patient.store') }}"
    class="p-4 mt-2">
    @csrf
    <x-form_input_div>
        <x-form_input id="first"
            type="text"
            name="first"
            class=""
            placeholder="First"
            wire:model.defer="state.expires_at" />
        <x-form_label for="first">
            First Name
        </x-form_label>
    </x-form_input_div>

    <x-form_input_div>
        <x-form_input id="last"
            type="text"
            name="last"
            placeholder="Last" />
        <x-form_label for="last">
            Last Name
        </x-form_label>
    </x-form_input_div>
    <x-form_input_div>
        <x-form_input id="email"
            type="email"
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
        <x-form_input id="insurance"
            type="text"
            name="insurance"
            placeholder="Insurance" />
        <x-form_label for="insurance">
            Insurance
        </x-form_label>
    </x-form_input_div>
    <x-form_input_div>
        <x-form_input id="user_id"
            type="text"
            name="user_id"
            placeholder="Therapist" />
        <x-form_label for="user">
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

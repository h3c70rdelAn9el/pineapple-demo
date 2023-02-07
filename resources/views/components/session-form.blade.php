<form action="{{ route('session.store') }}"
    class="capitalize"
    method="POST">
    @csrf
    <div>
        <label for="session_cost">Session Cost</label>
        <input type="text"
            x-data
            id="session_cost"
            name="session_cost"
            class="form-input"
            required
            x-mask:dynamic="$money($input)"
            placeholder="0.00">
    </div>
    <div>
        <label for="client_contribution">Client Contribution</label>
        <input type="text"
            x-data
            id="client_contribution"
            name="client_contribution"
            class="form-input"
            required
            x-mask:dynamic="$money($input)"
            placeholder="0.00">
    </div>
    <div>
        <label for="created_at">Session Date</label>
        <input type="datetime-local"
            id="created_at"
            name="created_at"
            class="form-input"
            required>
    </div>
    <div class="hidden">
        <label for="client_id">id</label>
        <input type="text"
            id="client_id"
            name="client_id"
            class="form-input"
            {{-- value="{{ $client->id }}" --}}
            value="{{ $client->id }}"
            readonly>
    </div>
    <div class="mt-2">
        <button type="submit"
            class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110"
            e.preventDefault();>
            Submit
        </button>
    </div>
</form>

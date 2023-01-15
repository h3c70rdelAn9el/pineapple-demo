<form action="{{ route('session.store') }}"
    class="capitalize"
    method="POST">
    @csrf
    <div>
        <label for="total_bill">total bill</label>
        <input type="text"
            x-data
            id="total_bill"
            name="total_bill"
            class="form-input"
            required
            x-mask:dynamic="$money($input)"
            placeholder="0.00">
    </div>
    <div>
        <label for="covered_cost">covered cost</label>
        <input type="text"
            x-data
            id="covered_cost"
            name="covered_cost"
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

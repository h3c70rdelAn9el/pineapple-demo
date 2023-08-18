<form action="{{ route('session.store') }}" class="capitalize" method="POST">
    @csrf
    <div>
        <label for="session_cost">Session Cost</label>
        <input type="text" x-data id="session_cost" name="session_cost" class="form-input" required x-mask:dynamic="$money($input)" placeholder="0.00">
    </div>
    <div class="my-2 text-xs font-light">
        <p>
            Original Client Contribution - ${{ $client->client_contribution }}
        </p>
        <p>
            Client Contribution remaining - ${{ $client->client_contribution - $client->therapySessions->sum('session_cost') }}
        </p>
    </div>

    {{-- <div>
        <label for="client_contribution">Client Contribution</label>
        <input type="text"
            x-data
            id="client_contribution"
            name="client_contribution"
            class="form-input"
            required
            x-mask:dynamic="$money($input)"
            placeholder="0.00">
    </div> --}}
    <div>
        <label for="created_at">Session Date</label>
        <input type="date" id="created_at" name="created_at" class="form-input" required>
    </div>



    <div>
        <label for="attendance">Attendance</label>
        <select name="attendance" id="attendance" class="w-full rounded-md" required>

            <option value="" disabled selected hidden>Please Select:</option>
            <option value="attended">Attended</option>
            {{-- <option value="canceled">Canceled</option> --}}
            <option value="no-show">No Show</option>
        </select>
    </div>

    <div>
        <label for="notes">Notes</label>
        <textarea name="notes" id="notes" cols="30" rows="10" class="form-input" placeholder="Enter notes here..."></textarea>
    </div>

    <div class="hidden">
        <label for="client_id">id</label>
        <input type="text" id="client_id" name="client_id" class="form-input" {{-- value="{{ $client->id }}" --}} value="{{ $client->id }}" readonly>
    </div>
    <div class="mt-2">
        <button type="submit" class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110" e.preventDefault();>
            Submit
        </button>
    </div>
</form>

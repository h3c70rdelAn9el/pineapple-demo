<form class="capitalize" action="{{ route('session.store') }}" method="POST" x-data="{ showModal: false }">
    @csrf
    <div>
        <label for="session_cost">Session Cost</label>
        <input class="form-input" id="session_cost" name="session_cost" type="text" x-data required
            x-mask:dynamic="$money($input)" placeholder="0.00">
    </div>
    <div class="my-2 text-xs font-light">
        <p>
            Original Client Contribution - ${{ $client->client_contribution }}
        </p>
        <p>
            Client Contribution remaining -
            ${{ $client->client_contribution - $client->therapySessions->sum('session_cost') }}
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
        <input class="form-input" id="created_at" name="created_at" type="date" required>
    </div>

    <div>
        <label for="attendance">Attendance</label>
        <select class="w-full rounded-md" id="attendance" name="attendance" required
            x-on:change="showModal = ($event.target.value === 'no-show')">
            <option value="" disabled selected hidden>Please Select:</option>
            <option value="attended">Attended</option>
            {{-- <option value="canceled">Canceled</option> --}}
            <option value="no-show">No Show</option>
        </select>
    </div>

    <div>
        <label for="notes">Notes</label>
        <textarea class="form-input" id="notes" name="notes" cols="30" rows="10"
            placeholder="Enter notes here..."></textarea>
    </div>

    <div class="hidden">
        <label for="client_id">id</label>
        <input class="form-input" id="client_id" name="client_id" type="text" value="{{ $client->id }}"
            {{-- value="{{ $client->id }}" --}} readonly>
    </div>
    <div class="mt-2">
        <button class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110" type="submit"
            e.preventDefault();>
            Submit
        </button>
    </div>

    <div class="fixed inset-0 z-50 flex items-center justify-center" x-show="showModal" x-cloak
        x-transition.duration.300ms>
        <div
            class="max-w-md p-8 text-sm leading-tight text-left text-red-700 bg-blue-100 border-2 border-red-600 rounded-lg shadow-lg md:text-base text-normal">
            <p>Thank you for letting us know that the client did not attend this appointment without giving sufficient
                notice.</p>
            <p>It is the client’s responsibility to pay for a 'no show' in full.</p>
            <p>As a reminder, Pineapple Support will no longer provide subsidised therapy after three missed sessions.
            </p>
            <button class="px-2 py-1 mt-4 duration-300 bg-blue-300 border border-red-600 rounded-md hover:scale-110"
                x-on:click="showModal = false">OK</button>
        </div>
    </div>
</form>

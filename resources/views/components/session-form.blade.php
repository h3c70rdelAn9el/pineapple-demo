<form class="capitalize"
    action="{{ route('session.store') }}"
    method="POST"

    x-data="{ showSessionMaxModal: false }">
    @csrf
    {{-- <div>
        <label for="created_at">Session Date</label>
        <input class="form-input"
            id="created_at"
            name="created_at"
            type="date"
            required>
    </div> --}}
    {{-- <div>
        <label for="created_at">Session Date</label>
        <input class="form-input" id="created_at" name="created_at" type="date" value="{{ now()->format('Y-m-d') }}">
        <p class="text-xs text-red-500">Cannot add a future date</p>
    </div> --}}
    {{-- <div>
        <label for="session_cost">Session Cost</label>
        <input class="form-input"
            id="session_cost"
            name="session_cost"
            type="text"
            x-data
            required
            x-mask:dynamic="$money($input)"
            placeholder="0.00">
    </div> --}}

    <div>
        <label for="created_at">Session Date</label>
        <input class="form-input"
            id="created_at"
            name="created_at"
            type="date"

            max="{{ now()->format('Y-m-d') }}">
        <p class="text-xs text-red-500">Cannot add a future date</p>

    </div>

    <div>
        <label for="session_cost">Session Cost</label>

        <div class="flex items-center">
            <input class="form-input"
                id="session_cost_display"
                type="text"
                value="{{ $therapist->session_cost }}"
                readonly>
            <input name="session_cost"
                type="hidden"
                value="{{ $therapist->session_cost }}">
        </div>
    </div>

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

    <div>
        <label for="attendance">Attendance</label>
        <select class="w-full rounded-md"
            id="attendance"
            name="attendance"
            required
            x-on:change="showModal = ($event.target.value === 'no-show')">
            <option value=""
                disabled
                selected
                hidden>Please Select:</option>
            <option value="attended">Attended</option>
            {{-- <option value="canceled">Canceled</option> --}}
            <option value="no-show">No Show</option>
        </select>
    </div>

    <div>
        <label for="notes">Notes</label>
        <textarea class="form-input"
            id="notes"
            name="notes"
            cols="30"
            rows="10"
            placeholder="Enter notes here..."></textarea>
    </div>

    <div class="hidden">
        <label for="client_id">id</label>
        <input class="form-input"
            id="client_id"
            name="client_id"
            type="text"
            value="{{ $client->id }}"
            readonly>
    </div>
    <div class="mt-2">
        <button class="rounded-md bg-blue-300 px-2 py-1 duration-200 hover:scale-110"
            type="submit"
            e.preventDefault();>
            Submit
        </button>
    </div>

    <div class="fixed inset-0 z-50 flex items-center justify-center"
        x-show="showSessionMaxModal && $refs.attendance.value === 'no-show'"
        x-cloak
        x-transition.duration.300ms>
        <div
            class="text-normal max-w-md rounded-lg border-2 border-red-600 bg-blue-100 p-8 text-left text-sm leading-tight text-red-700 shadow-lg md:text-base">
            <p>Thank you for letting us know that the client did not attend this appointment without giving sufficient
                notice.</p>
            <p>It is the client’s responsibility to pay for a 'no show' in full.</p>
            <p>As a reminder, Pineapple Support will no longer provide subsidised therapy after three missed sessions.
            </p>
            <button x-on:click="showSessionMaxModal = false" class="button">Close</button> <!-- Update this line -->
            <button class="mt-4 rounded-md border border-red-600 bg-blue-300 px-2 py-1 duration-300 hover:scale-110"
                x-on:click="showSessionMaxModal = !showSessionModal">OK</button>
        </div>
    </div>
</form>

<form action="{{ route('patient.store') }}"
                class="p-4">
                @csrf
                <div>
                    <label for="first">First</label>
                    <input type="text"
                        id="first"
                        name="first"
                        class="form-input">
                </div>
                <div>
                    <label for="last">Last</label>
                    <input type="text"
                        id="last"
                        name="last"
                        class="form-input">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="text"
                        id="email"
                        name="email"
                        class="form-input">
                </div>
                <div>
                    <label for="phone">Phone</label>
                    <input type="text"
                        id="phone"
                        name="phone"
                        class="form-input">
                </div>
                <div>
                    <label for="insurance">Insurance</label>
                    <input type="text"
                        id="insurance"
                        name="insurance"
                        class="form-input">
                </div>
                <div class="mt-2">
                    <button type="submit"
                        class="px-2 py-1 duration-200 bg-blue-300 rounded-md hover:scale-110">
                        Add
                    </button>
                </div>
            </form>

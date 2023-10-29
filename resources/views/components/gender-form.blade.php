<div class="flex justify-end">
    <div class="my-4 flex flex-col input-div w-full md:w-2/3" x-data="{ openGender: false, selectedGenders: [] }">
        <x-jet-label>
            <div class="flex flex-col">
                <p>Gender</p>
                <p class="text-xs">Previous: {{ $user->gender }}</p>
            </div>
        </x-jet-label>
        <button
            class="-m-0.5 flex w-full justify-between rounded-md border border-blue-300 bg-gray-100 p-3 text-gray-700 focus:border-blue-500"
            type="button"
            @click="openGender = !openGender">
            <span> (Select multiple if applicable)</span>
            <span class="ml-0"
                x-text="selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Select Options'"></span>
            <svg class="mt-0.5 h-[18px] w-[18px] text-gray-800"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"></path>
            </svg>

        </button>
        <div class="-ml-[2px] -mt-2 mr-[2px] rounded-md rounded-t-none border border-b border-r border-t-0 border-blue-500 bg-gray-100 py-4 md:flex md:flex-wrap"
            x-show="openGender"
            x-transition.scale.origin.top
            x-transition:enter.duration.300ms
            x-transition:enter.ease-in-out
            x-transition:leave.duration.300ms
            x-transition:ease-in-out
            x-cloak>

            <form action="{{ route('update.gender') }}"
                method="post">
                @csrf
                @method('post')
                {{-- <div class="input-div"> --}}
                    {{-- <x-jet-label value="Gender(s)" /> --}}
                    <div class="select-input-div">
                        <input class="select-input"
                            id="male"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="male">
                        <label class="ml-2"
                            for="male">Male</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input"
                            id="female"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="female">
                        <label class="ml-2"
                            for="female">Female</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input"
                            id="transgender"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="transgender">
                        <label class="ml-2"
                            for="transgender">Transgender</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input"
                            id="cisgender"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="cisgender">
                        <label class="ml-2"
                            for="cisgender">Cisgender</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input"
                            id="bigender"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="bigender">
                        <label class="ml-2"
                            for="bigender">Bigender</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input"
                            id="non-binary"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="non-binary">
                        <label class="ml-2"
                            for="non-binary">Non-Binary</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input"
                            id="other"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="other">
                        <label class="ml-2"
                            for="other">Other</label>
                    </div>
                    <div class="select-input-div">
                        <input class="select-input"
                            id="prefer-not-to-say"
                            name="selectedGenders[]"
                            type="checkbox"
                            value="prefer-not-to-say">
                        <label class="ml-2"
                            for="prefer-not-to-say">Prefer Not To Say</label>
                    </div>
                <x-jet-button class="" type="submit">Save Gender</x-jet-button>
            </form>
        </div>
    </div>
</div>

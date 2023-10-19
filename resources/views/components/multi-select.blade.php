{{-- bring the gender prop --}}
@props(['options' => [], 'label' => 'Select Options', 'name' => 'options', 'id' => 'options'])

<div class="relative w-full mt-6 mb-4"
    x-data="{ showOptions: false, selectedOptions: [], toggleSelectedOption(option) { if (this.selectedOptions.includes(option)) { this.selectedOptions = this.selectedOptions.filter(item => item !== option); } else { this.selectedOptions.push(option); } } }"
    x-init="alpine.watch('showOptions', value => { if (!value) showOptions = false; })">

    <x-form_label :for="$id">
        {{ $label }}
    </x-form_label>
    <div class="rounded-md"
        @click.away="showOptions = false">
        <div class="flex justify-between w-full p-3 bg-gray-100 rounded-md border border-blue-300">
            <button class="flex justify-between w-full text-gray-700 -m-0.5"
                type="button"
                @click="showOptions = !showOptions">
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
        </div>
        <div class="w-full text-gray-600 rounded-t-none rounded-b-md bg-gray-100 border-blue-300 border-b border-l border-r -mt-1 md:flex md:flex-wrap pt-1"
            x-show="showOptions"
            x-transition.scale.origin.top
            x-transition.duration.300ms
            x-transition.ease-in-out
            x-cloak>
            @foreach ($options as $option)
                <label class="items-center p-2 mx-auto">
                    <input class="mb-0.5 rounded-md transition-all duration-300 hover:bg-blue-300 focus:border-indigo-400 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-blue-300"
                        name="{{ $name }}[]"
                        type="checkbox"
                        :id="$id"
                        :value=" $option "
                        wire:model='multi'
                        multiple
                        x-on:click="toggleSelectedOption('{{ $option }}')">
                    {{ $option }}
                </label><br>
            @endforeach
        </div>
    </div>
</div>
 <script>
    // import alpine from the cdn
    import 'https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.0/alpine.js';
 </script>

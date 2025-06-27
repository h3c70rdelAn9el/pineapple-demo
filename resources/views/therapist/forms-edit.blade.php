<x-app-layout>
    <h1 class="w-1/2 mx-auto text-lg text-center">Edit Form</h1>
    <p class="text-xs text-center capitalize">{{ $therapist->name }}</p>
    <a href="{{ route('therapist.forms', $therapist->id) }}"
        class="button">
        Back
    </a>
    <div class="flex flex-col items-center justify-center my-4 bg-gray-100">
        <div class="items-center justify-center">
            @if (Str::contains($form->file_name, '.pdf'))
                <embed class="h-64 rounded-md md:h-[300px] md:w-full"
                    src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}"
                    type="application/pdf"
                    alt="{{ $form->file_name }}" />
            @elseif (Str::contains($form->file_name, '.jpg') ||
                    Str::contains($form->file_name, '.png') ||
                    Str::contains($form->file_name, '.jpeg') ||
                    Str::contains($form->file_name, '.JPEG'))
                <img class="h-64 rounded-md md:h-[300px] md:w-full"
                    src="{{ $form->url() }}"
                    alt="{{ $form->file_name }}" />
            @endif

            @if ($user->admin == 1)
                <div class="mt-4">
                    <a class="text-xs button"
                        href="{{ $form->url() }}"
                        download>
                        Download
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-col w-2/3 mx-auto text-sm md:w-1/2">
        <form action="{{ route('fileUpdate', $form->id) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="relative mt-4 mb-5">
                <x-jet-label for="date"
                    value="{{ __('Expiration Date') }}"
                    x-bind:required="documentType == 'clinical_license' || documentType ==
                        'public_liability_insurance' || documentType == 'photographic_id'" />
                <div class="relative">
                    <x-jet-input class="mt-1 block w-[100%]"
                        id="date"
                        name="date"
                        type="date"
                        x-bind:required="['clinical_license', 'public_liability_insurance', 'photographic_id'].includes(documentType)"
                        :value="old('date')"
                        placeholder="Date" />
                </div>
            </div>
 {{-- document type --}}
 <div class="flex flex-col mt-5" x-data="{ document_type: '{{ $form->document_type }}' }" x-init="document_type = '{{ $form->document_type }}'">
    <div class="relative">
        <select
            class="block w-full px-3 py-2 pr-8 leading-tight text-gray-700 bg-white border border-blue-400 rounded-md appearance-none focus:border-gray-500 focus:bg-white focus:outline-none"
            id="document_type" name="document_type" x-model="document_type" wire:model="document_type" required>
            <option value="">Select Document Type</option>
            <option value="photographic_id" {{$form->document_type == 'photographic_id' ? 'selected' : ''}}>Photographic ID</option>
            <option value="W9" {{$form->document_type == 'W9' ? 'selected' : ''}} >W9</option>
            <option value="clinical_license" {{$form->document_type == 'clinical_license' ? 'selected' : ''}}>Clinical License</option>
            <option value="public_liability_insurance" {{$form->document_type == 'public_liability_insurance' ? 'selected' : ''}}>Public Liability Insurance</option>
            <option value="W8BENE" {{$form->document_type == 'W8BENE' ? 'selected' : ''}}>W8BENE</option>
            <option value="W8BEN"> {{$form->document_type == 'W8BEN' ? 'selected' : ''}}W8BEN</option>
            <option value="Voided Check" {{$form->document_type == 'Voided Check' ? 'selected' : ''}}>Voided Check</option>
            <option value="supervisor_approval_letter" {{$form->document_type == 'supervisor_approval_letter' ? 'selected' : ''}}>Supervisor Approval Letter</option>
            <option value="headshot" {{$form->document_type == 'headshot' ? 'selected' : ''}}>Headshot</option>
            <option value="Bio" {{$form->document_type == 'Bio' ? 'selected' : ''}}>Bio</option>
            <option value="Other" {{$form->document_type == 'Other' ? 'selected' : ''}}>Other</option>
        </select>
    </div>
    
    {{-- Region selection for clinical license --}}
    <div class="relative my-5" x-show="document_type === 'clinical_license'">
        <x-jet-label for="region" value="{{ __('License Region') }}" />
        <select
            class="block w-full px-3 py-2 pr-8 leading-tight text-gray-700 bg-white border border-blue-400 rounded-md appearance-none focus:border-gray-500 focus:bg-white focus:outline-none"
            id="region" name="region" x-bind:required="document_type === 'clinical_license'">
            <option value="">Select Region</option>
            <option value="Canada" {{ $form->region == 'Canada' ? 'selected' : '' }}>Canada</option>
            <option value="Latin America" {{ $form->region == 'Latin America' ? 'selected' : '' }}>Latin America</option>
            <option value="Europe" {{ $form->region == 'Europe' ? 'selected' : '' }}>Europe</option>
            <option value="Australia" {{ $form->region == 'Australia' ? 'selected' : '' }}>Australia</option>
            <optgroup label="United States">
                <option value="Alabama" {{ $form->region == 'Alabama' ? 'selected' : '' }}>Alabama</option>
                <option value="Alaska" {{ $form->region == 'Alaska' ? 'selected' : '' }}>Alaska</option>
                <option value="Arizona" {{ $form->region == 'Arizona' ? 'selected' : '' }}>Arizona</option>
                <option value="Arkansas" {{ $form->region == 'Arkansas' ? 'selected' : '' }}>Arkansas</option>
                <option value="California" {{ $form->region == 'California' ? 'selected' : '' }}>California</option>
                <option value="Colorado" {{ $form->region == 'Colorado' ? 'selected' : '' }}>Colorado</option>
                <option value="Connecticut" {{ $form->region == 'Connecticut' ? 'selected' : '' }}>Connecticut</option>
                <option value="Delaware" {{ $form->region == 'Delaware' ? 'selected' : '' }}>Delaware</option>
                <option value="Florida" {{ $form->region == 'Florida' ? 'selected' : '' }}>Florida</option>
                <option value="Georgia" {{ $form->region == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                <option value="Hawaii" {{ $form->region == 'Hawaii' ? 'selected' : '' }}>Hawaii</option>
                <option value="Idaho" {{ $form->region == 'Idaho' ? 'selected' : '' }}>Idaho</option>
                <option value="Illinois" {{ $form->region == 'Illinois' ? 'selected' : '' }}>Illinois</option>
                <option value="Indiana" {{ $form->region == 'Indiana' ? 'selected' : '' }}>Indiana</option>
                <option value="Iowa" {{ $form->region == 'Iowa' ? 'selected' : '' }}>Iowa</option>
                <option value="Kansas" {{ $form->region == 'Kansas' ? 'selected' : '' }}>Kansas</option>
                <option value="Kentucky" {{ $form->region == 'Kentucky' ? 'selected' : '' }}>Kentucky</option>
                <option value="Louisiana" {{ $form->region == 'Louisiana' ? 'selected' : '' }}>Louisiana</option>
                <option value="Maine" {{ $form->region == 'Maine' ? 'selected' : '' }}>Maine</option>
                <option value="Maryland" {{ $form->region == 'Maryland' ? 'selected' : '' }}>Maryland</option>
                <option value="Massachusetts" {{ $form->region == 'Massachusetts' ? 'selected' : '' }}>Massachusetts</option>
                <option value="Michigan" {{ $form->region == 'Michigan' ? 'selected' : '' }}>Michigan</option>
                <option value="Minnesota" {{ $form->region == 'Minnesota' ? 'selected' : '' }}>Minnesota</option>
                <option value="Mississippi" {{ $form->region == 'Mississippi' ? 'selected' : '' }}>Mississippi</option>
                <option value="Missouri" {{ $form->region == 'Missouri' ? 'selected' : '' }}>Missouri</option>
                <option value="Montana" {{ $form->region == 'Montana' ? 'selected' : '' }}>Montana</option>
                <option value="Nebraska" {{ $form->region == 'Nebraska' ? 'selected' : '' }}>Nebraska</option>
                <option value="Nevada" {{ $form->region == 'Nevada' ? 'selected' : '' }}>Nevada</option>
                <option value="New Hampshire" {{ $form->region == 'New Hampshire' ? 'selected' : '' }}>New Hampshire</option>
                <option value="New Jersey" {{ $form->region == 'New Jersey' ? 'selected' : '' }}>New Jersey</option>
                <option value="New Mexico" {{ $form->region == 'New Mexico' ? 'selected' : '' }}>New Mexico</option>
                <option value="New York" {{ $form->region == 'New York' ? 'selected' : '' }}>New York</option>
                <option value="North Carolina" {{ $form->region == 'North Carolina' ? 'selected' : '' }}>North Carolina</option>
                <option value="North Dakota" {{ $form->region == 'North Dakota' ? 'selected' : '' }}>North Dakota</option>
                <option value="Ohio" {{ $form->region == 'Ohio' ? 'selected' : '' }}>Ohio</option>
                <option value="Oklahoma" {{ $form->region == 'Oklahoma' ? 'selected' : '' }}>Oklahoma</option>
                <option value="Oregon" {{ $form->region == 'Oregon' ? 'selected' : '' }}>Oregon</option>
                <option value="Pennsylvania" {{ $form->region == 'Pennsylvania' ? 'selected' : '' }}>Pennsylvania</option>
                <option value="Rhode Island" {{ $form->region == 'Rhode Island' ? 'selected' : '' }}>Rhode Island</option>
                <option value="South Carolina" {{ $form->region == 'South Carolina' ? 'selected' : '' }}>South Carolina</option>
                <option value="South Dakota" {{ $form->region == 'South Dakota' ? 'selected' : '' }}>South Dakota</option>
                <option value="Tennessee" {{ $form->region == 'Tennessee' ? 'selected' : '' }}>Tennessee</option>
                <option value="Texas" {{ $form->region == 'Texas' ? 'selected' : '' }}>Texas</option>
                <option value="Utah" {{ $form->region == 'Utah' ? 'selected' : '' }}>Utah</option>
                <option value="Vermont" {{ $form->region == 'Vermont' ? 'selected' : '' }}>Vermont</option>
                <option value="Virginia" {{ $form->region == 'Virginia' ? 'selected' : '' }}>Virginia</option>
                <option value="Washington" {{ $form->region == 'Washington' ? 'selected' : '' }}>Washington</option>
                <option value="West Virginia" {{ $form->region == 'West Virginia' ? 'selected' : '' }}>West Virginia</option>
                <option value="Wisconsin" {{ $form->region == 'Wisconsin' ? 'selected' : '' }}>Wisconsin</option>
                <option value="Wyoming" {{ $form->region == 'Wyoming' ? 'selected' : '' }}>Wyoming</option>
                <option value="District of Columbia" {{ $form->region == 'District of Columbia' ? 'selected' : '' }}>District of Columbia</option>
            </optgroup>
        </select>
    </div>
            <div class="relative my-5">
                <x-jet-label for="file_title"
                    value="File Title" />
                <div class="relative">
                    <x-jet-input class="mt-1 block w-[100%]"
                        id="file_title"
                        name="file_title"
                        type="text"
                        :value="old('file_title')"
                        placeholder="{{ $form->file_title }}" />
                </div>

            </div>

            <div class="relative">
                <x-jet-label for="note"
                    value="{{ __('Note (optional)') }}" />
                <textarea
                    class="block w-full px-3 py-2 pr-8 leading-tight text-gray-700 bg-gray-100 border border-blue-300 rounded appearance-none focus:border-gray-500 focus:bg-white focus:outline-none"
                    id="note"
                    name="note"
                    cols="40"
                    rows="2"
                    placeholder="{{ $form->note }}"></textarea>
            </div>

            <x-jet-button class="right-0 mt-3 mb-3 mr-6"
                type="submit">
                Update
            </x-jet-button>
        </form>
        @if ($form->verified == 1)
            <p class="pb-2 mt-3">Document has been verified</p>
        @else
            @if ($user->admin == 1)
                <form action="{{ route('fileUpdate', $form->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <label for="verified">Verify</label>
                    <input name="verified"
                        type="hidden"
                        value="0">
                    <input id="verified"
                        name="verified"
                        type="checkbox"
                        value="1">
                    <button type="submit">Submit</button>
                </form>
            @endif
        @endif
                {{--
        @if ($form->pinned == 1)
            <p class="pb-2 mt-3">Document has been pinned</p>
        @else
            <form action="{{ route('fileUpdate', $form->id) }}"
                method="POST">
                @csrf
                @method('PUT')
                <label for="pinned">Pin Document</label>
                <input name="pinned"
                    type="hidden"
                    value="0">
                <input id="pinned"
                    name="pinned"
                    type="checkbox"
                    value="1"
                    {{ $form->pinned ? 'checked' : '' }}>
                <button type="submit">Submit</button>
            </form>
        @endif
        --}}
    </div>
</x-app-layout>

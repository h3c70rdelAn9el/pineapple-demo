<x-app-layout>
    <h1 class="mx-auto w-1/2 text-center text-lg">Edit Form</h1>
    <p class="text-center text-xs capitalize">{{ $therapist->name }}</p>
    <a href="{{ route('therapist.forms', $therapist->id) }}"
        class="button">
        Back
    </a>
    <div class="my-4 flex flex-col items-center justify-center bg-gray-100">
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
                    <a class="button text-xs"
                        href="{{ $form->url() }}"
                        download>
                        Download
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="mx-auto flex w-2/3 flex-col text-sm md:w-1/2">
        <form action="{{ route('fileUpdate', $form->id) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="relative mb-5 mt-4">
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
 <div class="mt-5 flex flex-col" x-data="{ documentType: '' }">
    <div class="relative">
        <select
            class="block w-full appearance-none rounded-md border border-blue-400 bg-white px-3 py-2 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
            id="document_type" name="document_type" x-model="document_type" wire:model="document_type">
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
                    class="block w-full appearance-none rounded border border-blue-300 bg-gray-100 px-3 py-2 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
                    id="note"
                    name="note"
                    cols="40"
                    rows="2"
                    placeholder="{{ $form->note }}"></textarea>
            </div>

            <x-jet-button class="right-0 mb-3 mr-6 mt-3"
                type="submit">
                Update
            </x-jet-button>
        </form>
        @if ($form->verified == 1)
            <p class="mt-3 pb-2">Document has been verified</p>
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

        @if ($form->pinned == 1)
            <p class="mt-3 pb-2">Document has been pinned</p>
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
    </div>
</x-app-layout>

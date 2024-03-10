<x-app-layout>
    <h1 class="mx-auto w-1/2 text-lg">Edit Form</h1>
    <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100">
        <div class="items-center justify-center">
            @if (Str::contains($form->file_name, '.pdf'))
                <embed class="h-64 w-full rounded-md md:h-[300px] md:w-full"
                    src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" type="application/pdf"
                    alt="{{ $form->file_name }}" />
            @elseif (Str::contains($form->file_name, '.jpg') ||
                    Str::contains($form->file_name, '.png') ||
                    Str::contains($form->file_name, '.jpeg') ||
                    Str::contains($form->file_name, '.JPEG'))
                <img class="h-64 w-full rounded-md md:h-[300px] md:w-full" src="{{ $form->url() }}"
                    alt="{{ $form->file_name }}" />
            @endif

            @if ($user->admin == 1)
                <a class="button text-xs" href="{{ $form->url() }}" download>
                    Download
                </a>
            @endif
        </div>
    </div>

    <div class="mx-auto flex w-2/3 flex-col text-sm md:w-1/2">
        {{-- <div class="mt-2 flex flex-row">
            <p class="">Date:</p>
            <p class="ml-4">{{ $form->date }}</p>
        </div>
        <div class="mt-2 flex flex-row flex-wrap">
            <p class="">Document Type:</p>
            <p class="ml-4">{{ $form->document_type }}License</p>
        </div>
        <div class="mt-2 flex w-full flex-col">
            <p class="">Notes:</p>
            @if (!empty($form->notes))
                <p class="rounded-md border border-gray-200">
                    {{ $form->notes }}
                </p>
            @else
                <p class="rounded-md border border-gray-200 font-light">No notes available.</p>
            @endif
        </div> --}}
        <form action="{{ route('fileUpdate', $form->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="relative mb-5 mt-4">
                <x-jet-label for="date" value="{{ __('Expiration Date') }}"
                    x-bind:required="documentType == 'clinical_license' || documentType ==
                        'public_liability_insurance' || documentType == 'photographic_id'" />
                <div class="relative">
                    <x-jet-input class="mt-1 block w-[100%]" id="date" name="date" type="date"
                        x-bind:required="['clinical_license', 'public_liability_insurance', 'photographic_id'].includes(documentType)"
                        :value="old('date')" placeholder="Date" />
                </div>
            </div>

            <div class="relative my-5">
                <x-jet-label for="file_title" value="File Title" />
                <div class="relative">
                    <x-jet-input class="mt-1 block w-[100%]" id="file_title" name="file_title" type="text"
                        :value="old('file_title')" placeholder="{{ $form->file_title }}" />
                </div>

            </div>

            <div class="relative">
                <x-jet-label for="note" value="{{ __('Note (optional)') }}" />
                <textarea
                    class="block w-full appearance-none rounded border border-blue-300 bg-gray-100 px-3 py-2 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
                    id="note" name="note" cols="40" rows="2" placeholder="{{ $form->note }}"></textarea>
            </div>

            <x-jet-button class=" right-0 mb-3 mr-6 mt-3" type="submit">
                Update
            </x-jet-button>
        </form>
        @if ($user->admin == 1)
            @if ($form->verified == 1)
                <p class="mt-3 pb-2">Document has been verified</p>
            @else
                <form action="{{ route('fileUpdate', $form->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="verified">Verify</label>
                    <input type="hidden" name="verified" value="0">
                    <input id="verified" name="verified" type="checkbox" value="1">
                    <button type="submit">Submit</button>
                </form>
            @endif
            @if ($form->pinned == 1)
                <p class="mt-3 pb-2">Document has been pinned</p>
            @else
                <form action="{{ route('fileUpdate', $form->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="pinned">Pin Document</label>
                    <input type="hidden" name="pinned" value="0">
                    <input id="pinned" name="pinned" type="checkbox" value="1"
                        {{ $form->pinned ? 'checked' : '' }}>
                    <button type="submit">Submit</button>
            @endif
        @endif
    </div>
</x-app-layout>

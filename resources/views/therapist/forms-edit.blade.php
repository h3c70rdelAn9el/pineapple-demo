<x-app-layout>
    <h1>Edit Form</h1>

    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="items-center justify-center">
            @if (Str::contains($form->file_name, '.pdf'))
            <embed src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" class="h-64 w-full rounded-md md:h-[300px] md:w-full" type="application/pdf" alt="{{ $form->file_name }}" />
            @elseif (Str::contains($form->file_name, '.jpg') || Str::contains($form->file_name, '.png') || Str::contains($form->file_name, '.jpeg'))
            <img src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" {{-- class="h-[300px] w-full rounded-md" --}} class="h-64 w-full rounded-md md:h-[300px] md:w-full" alt="{{ $form->file_name }}" />
            @endif
        </div>

    </div>

    <div class="flex flex-row justify-between w-full">
        <div class="flex flex-row w-full">
            <div class="flex flex-col w-1/2">
                <div class="flex flex-row">
                    <p class="text-xs font-light">Verified:</p>
                    <p class="pl-2 text-xs font-light">
                        @if ($form->verified == 1)
                        Yes
                        @else
                        No
                        @endif
                    </p>
                </div>
                <div class="flex flex-row">
                    <p class="text-xs font-light">Date:</p>
                    <p class="pl-2 text-xs font-light">{{ $form->date }}</p>
                </div>
                <div class="flex flex-col flex-wrap">
                    <p class="text-xs font-light">Document Type:</p>
                    <p class="ml-2 text-xs font-light">{{ $form->document_type }}License</p>
                </div>
            </div>

            <div class="flex flex-col w-1/2">
                <p class="text-xs font-light">Notes:</p>
                <p class="pl-2 text-xs font-light">{{ $form->notes }}</p>
            </div>
        </div>
    </div>
    @if ($user->admin == 1)

    <form action="{{ route('fileUpdate', $form->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_id" value="{{ $form->id }}">
        <label for="verified">Verify</label>
        <input type="checkbox" name="verified" id="verified">
        <button type="submit">Submit</button>
    </form>
    @else

    @endif
</x-app-layout>

<x-app-layout>
    <h1 class="text-lg w-1/2 mx-auto">Edit Form</h1>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
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
                <a class="text-xs button" href="{{ $form->url() }}" download>
                    Download
                </a>
            @endif
        </div>
    </div>

    <div class="flex flex-col md:w-1/2 w-2/3 mx-auto text-sm">
        <div class="flex flex-row mt-2">
            <p class="">Date:</p>
            <p class="ml-4 ">{{ $form->date }}</p>
        </div>
        <div class="flex flex-row flex-wrap mt-2">
            <p class=" ">Document Type:</p>
            <p class="  ml-4">{{ $form->document_type }}License</p>
        </div>
        <div class="flex flex-col w-full mt-2">
            <p class=" ">Notes:</p>
                @if (!empty($form->notes))
    <p class="border border-gray-200 rounded-md">
        {{ $form->notes }}
    </p>
@else
    <p class="border border-gray-200 rounded-md font-light">No notes available.</p>
@endif
        </div>
        @if ($user->admin == 1)
            @if ($form->verified == 1)
                <p class=" mt-3 pb-2">Document has been verified</p>
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
        @else
        @endif
    </div>
</x-app-layout>

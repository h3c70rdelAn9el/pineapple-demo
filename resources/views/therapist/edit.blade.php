<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
             <div class="items-center justify-center">
                 @if (Str::contains($form->file_name, '.pdf'))
                 <embed src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" class="h-64 w-full rounded-md md:h-[300px] md:w-full" type="application/pdf" alt="{{ $form->file_name }}" />
                 @elseif (Str::contains($form->file_name, '.jpg') || Str::contains($form->file_name, '.png') || Str::contains($form->file_name, '.jpeg'))
                 <img src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" {{-- class="h-[300px] w-full rounded-md" --}} class="h-64 w-full rounded-md md:h-[300px] md:w-full" alt="{{ $form->file_name }}" />
                 @endif
             </div>
    </div>
</x-app-layout>

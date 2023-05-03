<x-app-layout>
    <x-main-container class="pb-20 overflow-hidden"
        style="height: 80vh;">
        <x-container-header :user="$user">
        </x-container-header>
        <div class="h-full overflow-scroll">
            <div class="flex flex-row flex-wrap w-full gap-2">
                <div class="flex flex-col w-full">
                    <ul class="flex flex-row pt-2 pl-2 text-xs font-light">
                        <li> {{ $therapist->name }} / </li>
                        <li>Forms</li>
                    </ul>
                    <div class="p-2 mb-2 text-center">
                        <h2>Therapist Forms</h2>
                    </div>
                    <div>
                        <p class="font-light">
                            <span class="pl-2 text-sm">Total:</span> {{ $file_name->count() }}
                        </p>
                    </div>

                </div>
            </div>
            <div class="flex flex-row flex-wrap justify-center w-full gap-4">
                @foreach ($file_name as $form)
                    <div class="flex flex-col">
                        <div>
                            <p class="mb-2 overflow-hidden text-sm text-ellipsis">{{ $form->file_name }}</p>
                        </div>
                        <div class="items-center justify-center">
                            @if (Str::contains($form->file_name, '.pdf'))
                                <embed src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}"
                                    class="h-60 w-60 rounded-md lg:h-[300px] lg:w-full"
                                    type="application/pdf"
                                    alt="{{ $form->file_name }}" />
                            @elseif (Str::contains($form->file_name, '.jpg') || Str::contains($form->file_name, '.png'))
                                <img src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}"
                                    class="h-[300px] w-full rounded-md"
                                    alt="{{ $form->file_name }}" />
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </x-main-container>
</x-app-layout>

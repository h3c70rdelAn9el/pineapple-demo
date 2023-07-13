<x-app-layout>
    <x-main-container class="pb-20 overflow-hidden"
        style="height: 80vh;">
        <x-container-header :user="$user">
        </x-container-header>
        <div class="h-full overflow-scroll">
            <div class="flex flex-row flex-wrap w-full gap-2">
                <div class="flex flex-col w-full">
                    <ul class="flex flex-row pt-2 pl-2 text-xs font-light">
                        <li>{{ $therapist->name }}</li>
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
            {{-- <section class="flex flex-row flex-wrap justify-center w-full gap-4"> --}}
            {{-- make a grid for the resources --}}
            <section class="grid w-2/3 grid-cols-1 gap-5 p-2 px-4 mx-auto md:grid-cols-2 lg:grid-cols-3 md:w-full">
                @foreach ($file_name as $form)
                    <div class="">
                        <div>
                            <p class="mb-2 overflow-hidden text-sm text-ellipsis">{{ $form->file_name }}vvvvvvvvvvvvvvvv1234567890123456788123456789</p>
                        </div>
                            <div class="flex flex-row">
                                <p class="text-xs font-light">Document Type:</p>
                                <p class="pl-2 text-xs font-light">{{ $form->document_type }}</p>
                            </div>

                        <div class="items-center justify-center">
                            @if (Str::contains($form->file_name, '.pdf'))
                                <embed src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}"
                                    class="h-64 w-full rounded-md md:h-[300px] md:w-full"
                                    type="application/pdf"
                                    alt="{{ $form->file_name }}" />
                            @elseif (Str::contains($form->file_name, '.jpg') || Str::contains($form->file_name, '.png') || Str::contains($form->file_name, '.jpeg'))
                                <img src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}"
                                    {{-- class="h-[300px] w-full rounded-md" --}}
                                    class="h-64 w-full rounded-md md:h-[300px] md:w-full"
                                    alt="{{ $form->file_name }}" />
                            @endif
                        </div>
                        <div class="flex flex-row justify-between w-full">
                            <div class="flex flex-col">
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
                                    <p class="text-xs font-light">Notes:</p>
                                    <p class="pl-2 text-xs font-light">{{ $form->notes }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex flex-row">
                                    <p class="text-xs font-light">Date:</p>
                                    <p class="pl-2 text-xs font-light">{{ $form->date }}</p>
                                </div>
                                <div class="flex flex-row">
                                    <p class="text-xs font-light">Document Type:</p>
                                    <p class="pl-2 text-xs font-light">{{ $form->document_type }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </section>
        </div>
    </x-main-container>
</x-app-layout>

<x-app-layout>
    <x-main-container class="pb-20 overflow-hidden" style="height: 80vh;">
        <x-container-header :user="$user">
        </x-container-header>
        <div class="h-full overflow-scroll">
            <div class="flex flex-row flex-wrap w-full">
                <div class="flex flex-col w-full">
                    <div class="p-2 mt-2 mb-2 text-center">
                        <h2>Forms</h2>
                    </div>
                </div>
            </div>
            <div class="w-5/6 px-4 mx-auto md:w-full">
                <div class="flex flex-col px-2">
                    <button class="w-32 button-secondary">
                        <a href="{{ route('therapist.show', $therapist) }}">{{ $therapist->name }}</a>
                    </button>
                    <p class="font-light">
                        <span class="pl-2 text-sm">Total:</span> {{ $file_name->count() }}
                    </p>
                    <div>
                        <div class="flex flex-row justify-between w-full">
                            <div class="flex flex-row font-light">
                                <p class="pl-2 text-sm">Verified:</p>
                                <p class="pl-2 text-sm">{{ $file_name->where('verified', 1)->count() }} of {{ $file_name->count() }}</p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="grid w-5/6 grid-cols-1 gap-5 p-2 px-4 mx-auto md:grid-cols-2 lg:grid-cols-3 md:w-full">
                @foreach ($file_name as $form)
                <div class="p-4 rounded-md shadow-xl">
                    <div>
                        {{-- <p class="mb-2 overflow-hidden text-sm text-ellipsis">{{ $form->file_name }}</p> --}}
                        @if ($form->file_title)
                        <div>
                            <p class="mb-2 overflow-hidden text-sm text-ellipsis">{{ $form->file_title }}</p>
                        </div>
                        @else
                        <div>
                            <p class="mb-2 overflow-hidden text-sm text-ellipsis">{{ $form->file_name }}</p>
                        </div>
                        @endif

                    </div>
                    <div class="flex flex-row">
                        <p class="text-xs font-light">Document Type:</p>
                        <p class="pl-2 text-xs font-light">{{ $form->document_type }}</p>
                    </div>
                    <div class="flex flex-row">
                        <a href="{{ route('fileEdit', $form->id) }}" class="text-lg font-light">View</a>
                    </div>

                    <div class="items-center justify-center">
                        @if (Str::contains($form->file_name, '.pdf'))
                        <embed src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" class="h-64 w-full rounded-md md:h-[300px] md:w-full" type="application/pdf" alt="{{ $form->file_name }}" />
                        @elseif (Str::contains($form->file_name, '.jpg') || Str::contains($form->file_name, '.png') || Str::contains($form->file_name, '.jpeg'))
                        <img src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" class="h-64 w-full rounded-md md:h-[300px] md:w-full" alt="{{ $form->file_name }}" />
                        @endif
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
                </div>
                @endforeach
            </section>
        </div>
    </x-main-container>
</x-app-layout>

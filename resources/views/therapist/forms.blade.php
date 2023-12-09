<x-app-layout>
    <x-main-container class="overflow-hidden pb-20"
        style="height: 80vh;">
        <x-container-header :user="$user">
        </x-container-header>
        <div class="h-full overflow-scroll">
            <div class="flex w-full flex-row flex-wrap">
                <div class="flex w-full flex-col">
                    <div class="mb-2 mt-2 p-2 text-center">
                        <h2>Forms</h2>
                    </div>
                </div>
            </div>

            <div class="flex">
                <div class="mx-auto"
                    x-data="{ search: '' }">
                    <form x-on:submit.prevent="searchForm">
                        @csrf
                        <input class="rounded-md p-2.5 text-sm"
                            type="text"
                            x-model="search"
                            placeholder="Search for filename">
                        <button class="button"
                            type="submit">Search</button>
                    </form>
                </div>
            </div>

            <div class="mx-auto w-5/6 px-4 md:w-full">
                <div class="flex flex-col px-2">
                    {{-- <button class="w-32 button-secondary">
                        <a href="{{ route('therapist.show', $therapist) }}">{{ $therapist->name }}</a>
                    </button> --}}
                    @if ($user->admin == '1')
                        <button class="button-secondary w-32">
                            <a href="{{ route('therapist.show', $therapist) }}">{{ $therapist->name }}</a>
                        </button>
                    @else
                        <div class="flex flex-row gap-2">
                            <button class="button-secondary w-32">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </button>
                            <button class="button-secondary w-32">
                                <a href="{{ route('profile.show') }}">Profile</a>
                            </button>
                        </div>
                    @endif
                    <p class="font-light">
                        <span class="pl-2 text-sm">Total:</span> {{ $file_name->count() }}
                    </p>
                    <div>
                        <div class="flex w-full flex-row justify-between">
                            <div class="flex flex-row font-light">
                                <p class="pl-2 text-sm">Verified:</p>
                                <p class="pl-2 text-sm">{{ $file_name->where('verified', 1)->count() }} of
                                    {{ $file_name->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="mx-auto grid w-5/6 grid-cols-1 gap-5 p-2 px-4 md:w-full md:grid-cols-2 lg:grid-cols-3">
                @foreach ($file_name as $form)
                    <div class="searchable-item rounded-md p-4 shadow-xl">
                        <div>
                            {{-- <p class="mb-2 overflow-hidden text-sm text-ellipsis">{{ $form->file_name }}</p> --}}
                            @if ($form->file_title)
                                <div>
                                    <p class="mb-2 overflow-hidden text-ellipsis text-sm">{{ $form->file_title }}</p>
                                </div>
                            @else
                                <div>
                                    <p class="mb-2 overflow-hidden text-ellipsis text-sm">{{ $form->file_name }}</p>
                                </div>
                            @endif

                        </div>
                        <div class="flex flex-row">
                            <p class="text-xs font-light">Document Type:</p>
                            <p class="pl-2 text-xs font-light">{{ $form->document_type }}</p>
                        </div>
                        <div class="flex flex-row">
                            {{-- TODO: STYLE THIS --}}
                            <a class="text-lg font-light"
                                href="{{ route('fileEdit', $form->id) }}">View</a>
                        </div>

                        <div class="items-center justify-center">
                            @if (Str::contains($form->file_name, '.pdf'))
                                <embed class="h-64 w-full rounded-md object-cover md:h-[300px] md:w-full"
                                    src="{{ $form->url() }}"
                                    type="application/pdf"
                                    alt="{{ $form->file_name }}" />
                            @elseif (Str::contains($form->file_name, '.jpg') ||
                                    Str::contains($form->file_name, '.png') ||
                                    Str::contains($form->file_name, '.jpeg') ||
                                    Str::contains($form->file_name, '.JPEG'))
                                <img class="h-64 w-full rounded-md object-cover md:h-[300px] md:w-full"
                                    src="{{ $form->url() }}"
                                    alt="{{ $form->file_name }}" />
                            @endif
                        </div>

                        <div class="flex w-full flex-row justify-between">
                            <div class="flex w-full flex-row">
                                <div class="flex w-1/2 flex-col">
                                    <div class="flex flex-row">
                                        <p class="text-xs font-light">Verified:</p>
                                        <p class="pl-2 text-xs font-light">
                                        <input name="verified_{{ $form->id }}}}"
                                            type="radio"
                                            value="1"
                                            {{ $form->verified == 1 ? 'checked' : '' }}>
                                        <label for="Yes">Yes</label>
                                        <input name="verified_{{ $form->id }}"
                                            type="radio"
                                            value="0"
                                            {{ $form->verified == 0 ? 'checked' : '' }}>
                                        <label for="No">No</label>
                                    </div>
                                    <div class="flex flex-row">
                                        <p class="text-xs font-light">Date:</p>
                                        {{-- <p class="pl-2 text-xs font-light">{{ $form->date }}</p> --}}
                                        @if ($form->date !== null)
                                            <p class="pl-2 text-xs font-light{{ now() > $form->date ? ' text-red-500' : '' }}">
                                                {{ $form->date->format('Y-m-d') }}
                                            </p>
                                        @else
                                            <p class="pl-2 text-xs font-light">N/A</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col flex-wrap">
                                        <p class="text-xs font-light">Document Type:</p>
                                        <p class="ml-2 text-xs font-light">{{ $form->document_type }}</p>
                                    </div>
                                </div>

                                <div class="flex w-1/2 flex-col">
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



    <script>
        function searchForm() {
            const searchQuery = this.search.trim().toLowerCase();
            const items = document.querySelectorAll('.searchable-item');

            items.forEach(item => {
                const text = item.textContent.trim().toLowerCase();
                if (text.includes(searchQuery)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('searchForm', searchForm);
            Alpine.store('search', ''); // Initialize search variable in Alpine store

            // Alpine.$watch('search', (value) => {
            //     searchForm.call({
            //         search: value
            //     }); // Trigger searchForm with immediate update
            // });
        });
    </script>

</x-app-layout>

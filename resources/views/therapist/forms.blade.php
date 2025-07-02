<x-app-layout>
    @if (session('success'))
        <x-success-message></x-success-message>
    @endif

    <div class="h-full overflow-scroll">
        <div class="flex w-full flex-row flex-wrap">
            <div class="flex w-full flex-col">
                <div class="mb-2 mt-2 p-2 text-center">
                    <h2>Forms</h2>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="mx-auto" x-data="{ search: '' }">
                <form x-on:submit.prevent="searchForm">
                    @csrf
                    <input class="rounded-md p-2.5 text-sm" type="text" x-model="search"
                        placeholder="Search for filename">
                    <button class="button" type="submit">Search</button>
                </form>
            </div>
        </div>

        <div class="mx-auto w-5/6 px-4 md:w-full" x-data="{ openUpload: false }">
            <div class="itmes-center flex flex-row justify-between px-2">
                {{-- <button class="w-32 button-secondary">
                        <a href="{{ route('therapist.show', $therapist) }}">{{ $therapist->name }}</a>
                    </button> --}}
                <div>
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
                    <div class="flex flex-row justify-between">
                        <div class="flex flex-row font-light">
                            <p class="pl-2 text-sm">Verified:</p>
                            <p class="pl-2 text-sm">{{ $file_name->where('verified', 1)->count() }} of
                                {{ $file_name->count() }}</p>
                        </div>
                    </div>
                </div>

                <button x-on:click="openUpload = !openUpload" class="button h-10 w-44 justify-end text-sm">
                    <span x-show="!openUpload" x-cloak>Upload Document</span>
                    <span x-show="openUpload" x-cloak>Close Form</span>
                </button>
            </div>
            <div x-show="openUpload" x-cloak x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-[-20px]"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300 transform"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-[-20px]">
                <x-file-upload :user="$user" :therapist="$therapist" />
            </div>
        </div>

        <div class="bg-gray-200">
            <p class="py-4 text-center">Pinned Forms</p>
            <section class="mx-auto grid w-5/6 grid-cols-1 gap-5 p-2 px-4 md:w-full md:grid-cols-2 lg:grid-cols-3">
                @foreach ($pinnedForms as $form)
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
                            <p class="pl-2 text-xs font-light">
                                @if($form->document_type === 'terms_of_business')
                                    Terms of Business
                                @elseif($form->document_type === 'photographic_id')
                                    Photographic ID
                                @elseif($form->document_type === 'clinical_license')
                                    Clinical License
                                @elseif($form->document_type === 'public_liability_insurance')
                                    Public Liability Insurance
                                @elseif($form->document_type === 'supervisor_approval_letter')
                                    Supervisor Approval Letter
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $form->document_type)) }}
                                @endif
                            </p>
                        </div>
                        @if($form->document_type === 'clinical_license' && $form->region)
                        <div class="flex flex-row">
                            <p class="text-xs font-light">Region:</p>
                            <p class="pl-2 text-xs font-light">{{ $form->region }}</p>
                        </div>
                        @endif
                        <div class="flex flex-row">
                            {{-- TODO: STYLE THIS --}}
                            <a class="text-lg" href="{{ route('fileEdit', $form->id) }}">View</a>
                        </div>
                        <a href="{{ route('fileEdit', $form->id) }}">
                            <div class="items-center justify-center">
                                @if (Str::contains($form->file_name, '.pdf'))
                                    <embed class="h-64 w-full rounded-md object-cover md:h-[300px] md:w-full"
                                        src="{{ $form->url() }}" type="application/pdf"
                                        alt="{{ $form->file_name }}" />
                                @elseif (Str::contains($form->file_name, '.jpg') ||
                                        Str::contains($form->file_name, '.png') ||
                                        Str::contains($form->file_name, '.jpeg') ||
                                        Str::contains($form->file_name, '.JPEG'))
                                    <img class="h-64 w-full rounded-md object-cover md:h-[300px] md:w-full"
                                        src="{{ $form->url() }}" alt="{{ $form->file_name }}" />
                                @endif
                            </div>
                        </a>

                        <div class="flex w-full flex-row justify-between">
                            <div class="flex w-full flex-row">
                                <div class="flex w-full flex-col">
                                    <div class="">
                                        {{-- <p class="text-xs font-light">Verified:</p>
                                            <p class="pl-2 text-xs font-light">
                                                <input name="verified_{{ $form->id }}}}" type="radio" value="1"
                                                    {{ $form->verified == 1 ? 'checked' : '' }}>
                                                <label for="Yes">Yes</label>
                                                <input name="verified_{{ $form->id }}" type="radio" value="0"
                                                    {{ $form->verified == 0 ? 'checked' : '' }}>
                                                <label for="No">No</label> --}}
                                        @if ($form->verified == 1)
                                            <p class="pl-2 text-xs font-light text-green-500">Document has been Verified
                                            </p>
                                        @else
                                            <p class="pl-2 text-xs font-light text-red-500">Not Verified</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-row">
                                        <p class="text-xs font-light">Date:</p>
                                        {{-- <p class="pl-2 text-xs font-light">{{ $form->date }}</p> --}}
                                        @if ($form->date != null)
                                            <p
                                                class="font-light{{ now() > Carbon\Carbon::parse($form->date)->format('Y-m-d') ? ' text-red-500' : '' }} pl-2 text-xs">
                                                {{ Carbon\Carbon::parse($form->date)->format('Y-m-d') }}
                                            </p>
                                        @else
                                            <p class="pl-2 text-xs font-light">N/A</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col flex-wrap">
                                        <p class="text-xs font-light">Document Type:</p>
                                        <p class="ml-2 text-xs font-light">{{ $form->document_type }}</p>
                                    </div>
                                    <div class="flex w-1/2 flex-col">
                                        <p class="text-xs font-light">Notes:</p>
                                        <p class="pl-2 text-xs font-light">{{ $form->notes }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        </div>

        <section class="mx-auto grid w-5/6 grid-cols-1 gap-5 p-2 px-4 md:w-full md:grid-cols-2 lg:grid-cols-3">
            @foreach ($unPinnedForms as $form)
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
                        <p class="pl-2 text-xs font-light">
                            @if($form->document_type === 'terms_of_business')
                                Terms of Business
                            @elseif($form->document_type === 'photographic_id')
                                Photographic ID
                            @elseif($form->document_type === 'clinical_license')
                                Clinical License
                            @elseif($form->document_type === 'public_liability_insurance')
                                Public Liability Insurance
                            @elseif($form->document_type === 'supervisor_approval_letter')
                                Supervisor Approval Letter
                            @else
                                {{ ucfirst(str_replace('_', ' ', $form->document_type)) }}
                            @endif
                        </p>
                    </div>
                    @if($form->document_type === 'clinical_license' && $form->region)
                    <div class="flex flex-row">
                        <p class="text-xs font-light">Region:</p>
                        <p class="pl-2 text-xs font-light">{{ $form->region }}</p>
                    </div>
                    @endif
                    <div class="flex flex-row">
                        {{-- TODO: STYLE THIS --}}
                        <a class="text-lg" href="{{ route('fileEdit', $form->id) }}">View</a>
                    </div>
                    <a href="{{ route('fileEdit', $form->id) }}">
                        <div class="items-center justify-center">
                            @if (Str::contains($form->file_name, '.pdf'))
                                <embed class="h-64 w-full rounded-md object-cover md:h-[300px] md:w-full"
                                    src="{{ $form->url() }}" type="application/pdf" alt="{{ $form->file_name }}" />
                            @elseif (Str::contains($form->file_name, '.jpg') ||
                                    Str::contains($form->file_name, '.png') ||
                                    Str::contains($form->file_name, '.jpeg') ||
                                    Str::contains($form->file_name, '.JPEG'))
                                <img class="h-64 w-full rounded-md object-cover md:h-[300px] md:w-full"
                                    src="{{ $form->url() }}" alt="{{ $form->file_name }}" />
                            @endif
                        </div>
                    </a>

                    <div class="flex w-full flex-row justify-between">
                        <div class="flex w-full flex-row">
                            <div class="flex w-full flex-col">
                                <div class="">
                                    {{-- <p class="text-xs font-light">Verified:</p>
                                        <p class="pl-2 text-xs font-light">
                                            <input name="verified_{{ $form->id }}}}" type="radio" value="1"
                                                {{ $form->verified == 1 ? 'checked' : '' }}>
                                            <label for="Yes">Yes</label>
                                            <input name="verified_{{ $form->id }}" type="radio" value="0"
                                                {{ $form->verified == 0 ? 'checked' : '' }}>
                                            <label for="No">No</label> --}}
                                    @if ($form->verified == 1)
                                        <p class="pl-2 text-xs font-light text-green-500">Document has been Verified
                                        </p>
                                    @else
                                        <p class="pl-2 text-xs font-light text-red-500">Not Verified</p>
                                    @endif
                                </div>
                                <div class="flex flex-row">
                                    <p class="text-xs font-light">Date:</p>
                                    {{-- <p class="pl-2 text-xs font-light">{{ $form->date }}</p> --}}
                                    @if ($form->date != null)
                                        <p
                                            class="font-light{{ now() > Carbon\Carbon::parse($form->date)->format('Y-m-d') ? ' text-red-500' : '' }} pl-2 text-xs">
                                            {{ Carbon\Carbon::parse($form->date)->format('Y-m-d') }}
                                        </p>
                                    @else
                                        <p class="pl-2 text-xs font-light">N/A</p>
                                    @endif
                                </div>
                                <div class="flex flex-col flex-wrap">
                                    <p class="text-xs font-light">Document Type:</p>
                                    <p class="ml-2 text-xs font-light">{{ $form->document_type }}</p>
                                </div>
                                <div class="flex w-1/2 flex-col">
                                    <p class="text-xs font-light">Notes:</p>
                                    <p class="pl-2 text-xs font-light">{{ $form->notes }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>

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

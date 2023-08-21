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

            <div class="flex">
                <div x-data="{ search: '' }" class="mx-auto">
                    <form x-on:submit.prevent="searchForm">
                        @csrf
                        <input type="text" x-model="search" placeholder="Search for filename" class="p-2.5 text-sm rounded-md">
                        <button type="submit" class="button">Search</button>
                    </form>
                </div>
            </div>

            <div class="w-5/6 px-4 mx-auto md:w-full">
                <div class="flex flex-col px-2">
                    {{-- <button class="w-32 button-secondary">
                        <a href="{{ route('therapist.show', $therapist) }}">{{ $therapist->name }}</a>
                    </button> --}}
                    @if ($user->admin == '1')
                    <button class="w-32 button-secondary">
                        <a href="{{ route('therapist.show', $therapist) }}">{{ $therapist->name }}</a>
                    </button>
                    @else
                    <div class="flex flex-row gap-2">
                        <button class="w-32 button-secondary">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </button>
                        <button class="w-32 button-secondary">
                            <a href="{{ route('profile.show') }}">Profile</a>
                        </button>
                    </div>
                    @endif
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
                <div class="p-4 rounded-md shadow-xl searchable-item">
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
                    {{-- TODO: STYLE THIS --}}
                        <a href="{{ route('fileEdit', $form->id) }}" class="text-lg font-light">View</a>
                    </div>

                    <div class="items-center justify-center">
                        @if (Str::contains($form->file_name, '.pdf'))
                        <embed src="{{ asset('uploads/forms/therapist/' . $form->file_name) }}" class="h-64 w-full rounded-md md:h-[300px] md:w-full object-cover" type="application/pdf" alt="{{ $form->file_name }}" />
                        @elseif (Str::contains($form->file_name, '.jpg') || Str::contains($form->file_name, '.png') || Str::contains($form->file_name, '.jpeg') || Str::contains($form->file_name, '.JPEG'))
                        <img src="{{ asset('uploads/forms/therapist/' . $form->file_path) }}" class="h-64 w-full rounded-md md:h-[300px] md:w-full object-cover" alt="{{ $form->file_name }}" />
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
                                    <p class="ml-2 text-xs font-light">{{ $form->document_type }}</p>
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


    {{-- <script>
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
        });

    </script> --}}

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

{{-- <script>
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
    });

</script> --}}

{{-- <script>
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
    });

</script> --}}

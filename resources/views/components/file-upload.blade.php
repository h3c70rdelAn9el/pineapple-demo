<div class="flex h-full grid-cols-6 flex-col overflow-hidden md:grid">
    <div class="ml-3 mt-10 flex flex-col md:col-span-2 md:ml-0 md:mt-0">
        <h3 class="text-lg">Upload Documents</h3>
        {{-- <p class="text-sm text-gray-600">Upload your documents here</p> --}}
        <div class="text-sm text-gray-600">
            <p class="font-medium">Required Documents:</p>
            <div class="ml-2 font-light">
                <p>Clinical License</p>
                <p>Photographic ID Document</p>
                <p>Public Liability Insurance</p>
                <p>W9/W8BENE/W8BEN</p>
            </div>
        </div>
        {{-- clinical_license_verification_portal --}}
        {{-- <div class="flex flex-col mt-2">
            <x-jet-label for="clinical_license_verification_portal" value="{{ __('Clinical License Verification Portal') }}" />
            <input type="text" class="mt-0.5 mr-1 rounded" id="clinical_license_verification_portal" wire:model.defer="state.clinical_license_verification_portal" autocomplete="clinical_license_verification_portal" />
            <p class="mt-[3px] ml-1 text-xs font-light">(Optional)</p>
            <x-jet-input-error for="clinical_license_verification_portal" class="mt-2" />
        </div> --}}
    </div>
    <div class="h-full overflow-hidden rounded-md border-b border-gray-300 bg-white shadow-md md:col-span-4 md:ml-3">
        <div class="relative -mb-5 flex p-3 pl-5"
            x-data="imageViewer()">
            <div class="mb-2 mt-2 flex">
                <div class="mt-2">
                    <template x-if="imageUrl">
                        <div class="mr-3">
                            <img class="mr-3 rounded-md border border-gray-200 object-cover shadow-md"
                                style="width: 100px; height: 100px;"
                                :src="imageUrl">
                        </div>
                    </template>

                    <template x-if="!imageUrl">
                        <div class="mr-3 rounded-md border border-gray-200 bg-gray-100 shadow-md shadow-blue-100"
                            style="width: 100px; height: 100px;"></div>
                    </template>
                </div>

                <div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form action="{{ route('fileStore') }}"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- file input --}}
                        <div class="mb-3 flex flex-wrap">
                            <input class="mt-2"
                                class="@error('file') is-invalid @enderror"
                                id="file_name"
                                name="file"
                                type="file"
                                accept="image/*, application/pdf"
                                @change="fileChosen"
                                placeholder="">
                            @error('file')
                                <span class="text-red-900">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- document type --}}
                        <div class="mb-5 flex flex-wrap">
                            <div class="relative">
                                <select
                                    class="block w-full appearance-none rounded-md border border-blue-400 bg-white px-3 py-2 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
                                    id="document_type"
                                    name="document_type">
                                    <option value="">Select Document Type</option>
                                    <option value="photographic_id">Photographic ID</option>
                                    <option value="W9">W9</option>
                                    <option value="clinical_license">Clinical License</option>
                                    <option value="public_liability_insurance">Public Liability Insurance</option>
                                    <option value="W8BENE">W8BENE</option>
                                    <option value="W8BEN">W8BEN</option>
                                    <option value="Voided Check">Voided Check</option>
                                    <option value="supervisor_approval_letter">Supervisor Approval Letter</option>
                                    <option value="headshot">Headshot</option>
                                    <option value="Bio">Bio</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-5 flex flex-col">
                            <div class="relative mb-5">
                                <x-jet-label for="file_title"
                                    value="File Title" />
                                <div class="relative">
                                    <x-jet-input class="mt-1 block w-[100%]"
                                        id="file_title"
                                        name="file_title"
                                        type="text"
                                        :value="old('file_title')"
                                        placeholder="File Title" />
                                </div>
                            </div>

                            {{-- date --}}
                            <div class="relative mb-5">
                                <x-jet-label for="date"
                                    value="{{ __('Expiration Date (optional)') }}" />
                                <div class="relative">
                                    <x-jet-input class="mt-1 block w-[100%]"
                                        id="date"
                                        name="date"
                                        type="date"
                                        :value="old('date')"
                                        placeholder="Date" />
                                </div>
                            </div>

                            {{-- note --}}
                            <div class="relative">
                                <x-jet-label for="note"
                                    value="{{ __('Note (optional)') }}" />
                                <textarea
                                    class="block w-full appearance-none rounded border border-blue-300 bg-white px-3 py-2 pr-8 leading-tight text-gray-700 focus:border-gray-500 focus:bg-white focus:outline-none"
                                    id="note"
                                    name="note"
                                    cols="40"
                                    rows="2"
                                    placeholder="Note"></textarea>
                            </div>
{{--
                            <div class="relative mt-4">
                                <x-jet-label for="clinical_license_verification_portal"
                                    value="{{ __('Clinical License Verification Portal') }}" />
                                <x-jet-input class="mr-1 mt-0.5 w-full"
                                    name="clinical_license_verification_portal"
                                    id="clinical_license_verification_portal"
                                    type="text"
                                    wire:model.defer="state.clinical_license_verification_portal"
                                    autocomplete="clinical_license_verification_portal" />
                                <p class="ml-1 mt-[3px] text-xs font-light">(Optional)</p>
                                <x-jet-input-error class="mt-2"
                                    for="clinical_license_verification_portal" />
                            </div> --}}
                        </div>

                        <x-jet-button class="absolute right-0 mb-3 mr-6 mt-9"
                            type="submit">
                            Save
                        </x-jet-button>
                    </form>
                    <div class="mt-5 flex flex-wrap">
                        <div class="relative">
                            <a class="text-blue-500 hover:text-blue-800"
                                href="{{ route('therapist.forms', $user) }}">View Forms</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-16 w-full rounded-b-md bg-gray-50">
        </div>
    </div>
</div>

<script>
    function imageViewer(src = "") {
        return {
            imageUrl: src,
            fileChosen(event) {
                this.fileToDataUrl(event, src => this.imageUrl = src)
            },

            fileToDataUrl(event, callback) {
                if (!event.target.files.length) return

                let file = event.target.files[0],
                    reader = new FileReader()

                reader.readAsDataURL(file)
                reader.onload = e => callback(e.target.result)
            },
        }
    }
</script>

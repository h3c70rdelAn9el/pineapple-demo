<div class="flex flex-col h-full grid-cols-6 overflow-hidden md:grid">
    <div class="flex flex-col mt-10 ml-3 md:col-span-2 md:mt-0 md:ml-0">
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
        {{-- on_vacation --}}
        <div class="flex flex-row mt-2">
            <input type="checkbox" class="mt-0.5 mr-1 rounded" id="clinical_license_verification_portal" wire:model.defer="state.clinical_license_verification_portal" autocomplete="clinical_license_verification_portal" />
            <x-jet-label for="clinical_license_verification_portal" value="{{ __('Clinical License Verification Portal') }}" />
            <p class="mt-[3px] ml-1 text-xs font-light">(Optional)</p>
            <x-jet-input-error for="clinical_license_verification_portal" class="mt-2" />
        </div>
    </div>
    <div class="h-full overflow-hidden bg-white border-b border-gray-300 rounded-md shadow-md md:ml-3 md:col-span-4">
        <div x-data="imageViewer()" class="relative flex p-3 pl-5 -mb-5">
            <div class="flex mt-2 mb-2">
                <div class="mt-2">
                    <template x-if="imageUrl">
                        <div class="mr-3">
                            <img :src="imageUrl" class="object-cover mr-3 border border-gray-200 rounded-md shadow-md" style="width: 100px; height: 100px;">
                        </div>
                    </template>

                    <template x-if="!imageUrl">
                        <div class="mr-3 bg-gray-100 border border-gray-200 rounded-md shadow-md shadow-blue-100" style="width: 100px; height: 100px;"></div>
                    </template>
                </div>

                <div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <form action="{{ route('fileStore') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- file input --}}
                        <div class="flex flex-wrap mb-3">
                            <input class="mt-2" type="file" accept="image/*, application/pdf" id="file_name" name="file" class="@error('file') is-invalid @enderror " @change="fileChosen" placeholder="">
                            @error('file')
                            <span class="text-red-900">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- document type --}}
                        <div class="flex flex-wrap mb-5">
                            <div class="relative">
                                <select name="document_type" id="document_type" class="block w-full px-3 py-2 pr-8 leading-tight text-gray-700 bg-white border border-blue-400 rounded-md appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
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

                        <div class="flex flex-col mb-5">
                            <div class="relative mb-5">
                                <x-jet-label for="file_title" value="File Title" />
                                <div class="relative">
                                    <x-jet-input id="file_title" class="block w-[100%] mt-1" type="text" name="file_title" :value="old('file_title')" placeholder="File Title" />
                                </div>
                            </div>

                            {{-- date --}}
                            <div class="relative mb-5">
                                <x-jet-label for="date" value="{{ __('Expiration Date (optional)') }}" />
                                <div class="relative">
                                    <x-jet-input id="date" class="block w-[100%] mt-1" type="date" name="date" :value="old('date')" placeholder="Date" />
                                </div>
                            </div>

                            {{-- note --}}
                            <div class="relative">
                                <x-jet-label for="note" value="{{ __('Note (optional)') }}" />
                                <textarea name="note" id="note" cols="40" rows="2" class="block w-full px-3 py-2 pr-8 leading-tight text-gray-700 bg-white border border-blue-300 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Note"></textarea>
                            </div>
                        </div>

                        <x-jet-button type="submit" class="absolute right-0 mb-3 mr-6 mt-9">
                            Save
                        </x-jet-button>
                    </form>
                    <div class="flex flex-wrap mt-5">
                        <div class="relative">
                            <a href="{{ route('therapist.forms', $user) }}" class="text-blue-500 hover:text-blue-800">View Forms</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full h-16 bg-gray-50 rounded-b-md">
        </div>
    </div>
</div>

<script>
    function imageViewer(src = "") {
        return {
            imageUrl: src
            , fileChosen(event) {
                this.fileToDataUrl(event, src => this.imageUrl = src)
            },

            fileToDataUrl(event, callback) {
                if (!event.target.files.length) return

                let file = event.target.files[0]
                    , reader = new FileReader()

                reader.readAsDataURL(file)
                reader.onload = e => callback(e.target.result)
            }
        , }
    }

</script>

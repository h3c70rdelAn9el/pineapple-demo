<div class="flex flex-col grid-cols-6 md:grid">
    <div class="flex flex-col md:col-span-2">
        <h3 class="text-lg">Upload Documents</h3>
        <p class="text-sm text-gray-600">Upload your documents here</p>
    </div>
    <div class="h-48 bg-white rounded-md shadow-md md:col-span-4">

        <div x-data="imageViewer()" class="relative flex p-3 pl-5 -mb-5">
            <div class="flex mt-2 mb-2">
                <!-- Show the image -->
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

                        <div class="flex flex-wrap mb-3">
                            <input class="mt-2" type="file" accept="image/*, application/pdf" id="file_name" name="file" class="@error('file') is-invalid @enderror" @change="fileChosen" placeholder="">
                            @error('file')
                            <span class="text-red-900">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-wrap mb-5">
                            <div class="relative">
                                <select name="document_type" id="document_type" class="block w-full px-3 py-2 pr-8 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="">Select Document Type</option>
                                    <option value="W9">W9</option>
                                    <option value="Certificate">Certificate</option>
                                    <option value="License">License</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="absolute right-0 w-full border-b border-b-rounded-md bg-gray-50 h-14 mt-7 align-items-end ">
                            <div class="absolute p-2 my-0 right-4">
                                <x-jet-button type="submit">
                                    Save
                                </x-jet-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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

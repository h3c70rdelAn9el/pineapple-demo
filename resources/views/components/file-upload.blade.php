<div x-data="imageViewer()" class="flex w-1/2 mx-auto rounded-md shadow-lg bg-blue-50 shadow-blue-100">
    <div class="flex mx-auto mt-2 mb-2">
        <!-- Show the image -->
        <template x-if="imageUrl">
            <div class="mr-3">
                <img :src="imageUrl" class="object-cover mr-3 border border-gray-200 rounded-md shadow-md" style="width: 100px; height: 100px;">
            </div>
        </template>

        <template x-if="!imageUrl">
            <div class="mr-3 bg-gray-100 border border-gray-200 rounded-md shadow-md shadow-blue-100" style="width: 100px; height: 100px;"></div>
        </template>

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
                <div class="flex flex-wrap mb-3">
                    <div class="relative">
                        <select name="document_type" id="document_type" class="block w-full px-3 py-2 pr-8 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">Select Document Type</option>
                            <option value="W9">W9</option>
                            <option value="Certificate">Certificate</option>
                        </select>
                        {{-- <label for="document_type"></label>
                        <input type="text" id="document_type"> --}}

                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="w-40 p-2 m-2 text-center transition-all duration-200 ease-in bg-blue-200 rounded-md shadow-md shadow-blue-100 hover:bg-blue-400">
                        Upload
                    </button>
                </div>
            </form>
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

<x-app-layout>
    <div class="panel-body">

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <form action="{{ route('fileStore') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class=""
                    for="inputFile">File:</label>
                <input type="file"
                    name="file"
                    id="inputFile"
                    class="form-control @error('file') is-invalid @enderror">

                @error('file')
                    <span class="text-red-900">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit"
                    class="">
                    Upload
                </button>
            </div>

        </form>

    </div>
</x-app-layout>

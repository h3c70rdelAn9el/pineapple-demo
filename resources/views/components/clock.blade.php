{{-- <div class="flex w-40 h-16 p-4 bg-white shadow-sm rounded-xl "> --}}
 <div   {{ $attributes->merge(['class' => 'block font-medium text-lg']) }}
    {{-- <div class="mx-auto text-lg md:text-xl " --}}
        x-data
        x-timeout:1000="$el.innerText=$moment().format('LTS')"
        x-cloak></div>

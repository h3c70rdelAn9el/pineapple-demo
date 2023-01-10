{{-- <div class="flex w-40 h-16 p-4 bg-white shadow-sm rounded-xl "> --}}
<div {{ $attributes->merge(['class' => 'block font-medium lg:text-lg text-']) }}
    {{-- <div class="mx-auto text-lg md:text-xl " --}}
    x-data
    x-cloak
    x-timeout:1000="$el.innerText=$moment().format('LTS')"></div>

<div class="p-2 pb-12 m-2 bg-blue-100 rounded-md shadow-sm md:w-full border-2 overflow-y-auto border-purple-300 h-full">
    {{-- <div class="{{ $classes ?? '' }}flex flex-row flex-wrap justify-between mx-8 mb-2 text-lg border-b border-gray-100"> --}}
    <div {!! $attributes->merge(['class' => 'flex flex-row flex-wrap justify-between mx-8 mb-2 text-lg border-b border-gray-100']) !!}>
        <p class="font-bold">
            {{ $title }}
        </p>
        <p class="">
            <span class="font-bold">
                {{ $count }}
            </span>
        </p>
    </div>
    <div class="flex flex-col w-full p-2 m-2 mx-auto overflow-x-hidden overflow-y-auto  font-normal h-full">
        {{ $content }}
    </div>
</div>

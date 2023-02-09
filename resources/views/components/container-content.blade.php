<div class="p-2 m-2 bg-blue-100 rounded-md shadow-sm md:w-1/2">
    <div class="flex flex-row flex-wrap justify-between mx-12 mb-2 text-lg border-b border-gray-100">
        <p class="font-bold">
            {{ $title }}
        </p>
        <p class="ml-2">
            <span class="font-bold">
                {{ $count }}
            </span>
        </p>
    </div>
    <div class="flex flex-col w-full p-2 m-2 mx-auto overflow-x-hidden overflow-y-scroll h-96">
        {{ $content }}
    </div>
</div>

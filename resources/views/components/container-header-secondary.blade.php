<section
    class="flex flex-row items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
    <div class="flex flex-col p-4 text-center capitalize md:flex-row text-md md:text-xl">
        <p class="ml-1 font-bold md:ml-0">{{ $user->name }}</p>
    </div>
    <div class="bg-blue-500 md:w-44 min-w-min">
        <x-clock class="text-base font-bold text-white bg-blue-500"></x-clock>
    </div>
</section>

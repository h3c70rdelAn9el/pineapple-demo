<section
    class="flex flex-row items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
    <div class="p-4 text-center capitalize shadow-md sm:rounded-lg">
        <p class="text-lg md:text-xl">Welcome: <span class="font-bold">{{ $user->name }}</span></p>
    </div>
    <div class="bg-blue-500 w-44">
        <x-clock class="text-xl font-bold text-white bg-blue-500"></x-clock>
    </div>

</section>

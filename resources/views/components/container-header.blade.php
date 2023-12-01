<section
    class="mx-auto flex w-full flex-row items-center justify-around rounded-t-md bg-blue-500 text-white md:flex-row">
    <div class="text-md flex flex-col p-4 text-center capitalize md:flex-row md:text-xl">
        <p class="ml-1 font-bold md:ml-0">{{ $user->preferred_name ? $user->preferred_name : $user->name }}</p>
    </div>
    <div class="min-w-min bg-blue-500 md:w-44">
        <x-clock class="bg-blue-500 text-base font-bold text-white"></x-clock>
    </div>
    <div class="flex flex-row">
        <button class="button">
            <a href="/chatify">
                Messenger
            </a>
        </button>
        {{-- TODO: add unseen message count --}}
    </div>
</section>

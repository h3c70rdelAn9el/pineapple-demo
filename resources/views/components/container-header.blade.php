<section
    class="mx-auto flex w-full flex-row items-center justify-around rounded-t-md bg-blue-500 text-white md:flex-row">
    <div class="text-md flex flex-col p-4 text-center capitalize md:flex-row md:text-xl">
        <p class="ml-1 font-bold md:ml-0">{{ $user->preferred_name ? $user->preferred_name : $user->name }}</p>
    </div>
    <div class="min-w-min bg-blue-500 md:w-44">
        <x-clock class="bg-blue-500 text-base font-bold text-white"></x-clock>
    </div>
    <div class="flex flex-row">
        <button class="button relative">
            <a href="/chatify">
                Messenger
            </a>
            @php
                $unreadCount = \App\Models\ChMessage::where('to_id', $user->id)->where('seen', 0)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        </button>
    </div>
</section>

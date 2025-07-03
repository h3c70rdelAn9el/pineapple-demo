<section
    class="flex flex-row items-center justify-around w-full mx-auto text-white bg-blue-500 rounded-t-md md:flex-row">
    <div class="flex flex-col p-4 text-center capitalize text-md md:flex-row md:text-xl">
        <p class="ml-1 font-bold md:ml-0">{{ $user->preferred_name ? $user->preferred_name : $user->name }}</p>
    </div>
    <div class="bg-blue-500 min-w-min md:w-44">
        <x-clock class="text-base font-bold text-white bg-blue-500"></x-clock>
    </div>
    <div class="flex flex-row">
        <button class="relative button">
            <a href="/messages">
                Messenger
            </a>
            @php
                $unreadCount = \App\Models\ChMessage::where('to_id', $user->id)->where('seen', 0)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-2 -right-2">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        </button>
    </div>
</section>

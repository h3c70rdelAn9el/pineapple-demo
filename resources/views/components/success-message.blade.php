<div class="z-50 flex items-center justify-center">
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="fixed top-24 m-4 mx-auto w-1/2 rounded-md bg-green-500 p-4 text-center text-white shadow-sm"
    >
        {{ session('success') }}
    </div>
</div>

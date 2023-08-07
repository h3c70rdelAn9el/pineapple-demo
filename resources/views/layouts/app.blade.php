<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head></x-head>

<body class="font-sans antialiased bg-gray-50">
    <x-jet-banner />

    <div class="">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="p-2">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    <script src="https://unpkg.com/@victoryoalli/alpinejs-moment@1.x.x/dist/moment.min.js"></script>
    <script src="https://unpkg.com/@victoryoalli/alpinejs-timeout@1.x.x/dist/timeout.min.js"></script>
         <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>

</body>

</html>

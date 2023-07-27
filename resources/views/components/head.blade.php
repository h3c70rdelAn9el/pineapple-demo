<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <link rel="stylesheet" href="../../css/intlTelInput.css">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ __('Pineapple') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <link rel="icon"
        href="{{ url('/pineapple.ico') }}" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>


    <!-- Styles -->
    @livewireStyles
</head>

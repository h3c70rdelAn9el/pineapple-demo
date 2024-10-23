<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <link rel="stylesheet" href="../../css/intlTelInput.css">
{{--
    <script src="https://unpkg.com/@victoryoalli/alpinejs-moment@1.x.x/dist/moment.min.js"></script>
    <script src="https://unpkg.com/@victoryoalli/alpinejs-timeout@1.x.x/dist/timeout.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script> --}}

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ __('Pineapple') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <link rel="icon"
        href="{{ url('/pineapple.ico') }}" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script> --}}


    <!-- Styles -->
    @livewireStyles
       <!-- Select2 CSS -->
       <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        @include('components.dashboard.header')
        <div class="grid" style="grid-template-columns: 1fr 5fr;">
            @include('components.dashboard.sidebar')

            @if ($currentRoute === 'dashboard')
                @include('pages.applicant.sections.dashboard')
            @elseif ($currentRoute === 'change')
                @include('pages.applicant.sections.change-password')
            @endif
        </div>
    </body>
</html>

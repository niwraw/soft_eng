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
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="antialiased">
        <div class="flex items-center justify-center w-screen h-screen bg-red-100">
            <div class="w-9/12 px-8 py-4 bg-blue-500 h-4/5 rounded-xl">
                HELLO
            
                <button onclick="history.back()" class="px-4 py-1 text-white bg-gray-700 rounded-lg">
                    Back
                </button>
            </div>
        </div>
    </body>
</html>

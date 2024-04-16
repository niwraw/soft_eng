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
        <header class="flex h-20 px-3 bg-gray-100 border-b-2 border-yellow-400 border-solid">
            <div class="flex w-1/2 h-full">
                <img src="{{ asset('assets/image/school.png') }}" class="h-full">
                <div class="flex flex-col justify-center mx-3">
                    <span class="text-lg font-bold text-yellow-500">Pamantasan ng Lungsod ng Maynila</span>
                    <span class="text-sm">University of the City of Manila</span>
                </div>
            </div>
            <div class="flex items-center w-1/2 h-full justify-evenly">
                <a href="{{ route('welcome.page', ['currentRoute' => 'home' ]) }}">
                    <span>Home</span>
                </a>

                <a href="{{ route('welcome.page', ['currentRoute' => 'colleges' ]) }}">
                    <span>Colleges</span>
                </a>

                <a href="{{ route('welcome.page', ['currentRoute' => 'inquiry' ]) }}">
                    <span>Inquiry</span>
                </a>

                <a href="{{ route('apply') }}">
                    <span>Apply</span>
                </a>
            </div>
        </header>

        <main class="flex h-auto px-5">
            @if ($currentRoute === "home")
                @include('components.landing_page.home')
            @elseif ($currentRoute === "colleges")
                @include('components.landing_page.colleges')
            @elseif ($currentRoute === "inquiry")
                @include('components.landing_page.inquiry')
            @endif
        </main>
        
        <footer class="flex flex-row h-auto gap-3 px-5 py-3 border-t-2 border-yellow-400">
            <div class="flex flex-col w-1/3 gap-5 h-96">
                <div class="flex flex-row items-center h-1/3">
                    <img src="{{ asset('assets/image/school.png') }}" class="h-full">
                    <div class="flex flex-col justify-center mx-3">
                        <span class="text-xl font-bold text-yellow-500">Pamantasan ng Lungsod ng Maynila</span>
                        <span class="text-sm">University of the City of Manila</span>
                    </div>
                </div>

                <div class="h-2/3">
                    <span>About Us:</span>
                    <span>Pamantasan ng Lungsod ng Maynila (PLM) is the first and only charted and autonomous university funded by a city government which is situated inside the historic walled area of Intramuros, Manila, Philippines.</span>
                </div>
            </div>

            <div class="flex flex-col w-1/3 h-96 gap-7">
                <h3>For more information, you may contact the Admission Office.</h3>
                
                <div class="flex flex-row gap-3">
                    <span class="font-medium material-symbols-sharp">email</span>
                    <h4 class="font-semibold">Email:</h4>
                    <p>admission_office@plm.edu.ph</p>
                </div>

                <div class="flex flex-row gap-3">
                    <span class="font-medium material-symbols-sharp">phone</span>
                    <h4 class="font-semibold">Contact Number:</h4>
                    <p>09123456789</p>
                </div>

                <div class="flex flex-row gap-3">
                    <span class="font-medium material-symbols-sharp">explore</span>
                    <h4 class="font-semibold">Address:</h4>
                    <p>Gen. Luna corner Muralla Street, Intramuros Manila, Philippines 1002</p>
                </div>
            </div>

            <div class="w-1/3 h-auto bg-pink-400">
            </div>
        </footer>

        <div class="flex flex-col items-center justify-center pt-4 pb-2 text-white bg-red-800">
            <p>Copyright 1967-2023 Pamantasan ng Lungsod ng Maynila. All Rights Reserved.</p>
            <p>Admission Office</p>
        </div>
    </body>
</html>

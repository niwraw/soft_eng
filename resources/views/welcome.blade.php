<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <a href="#">
                    <span>Home</span>
                </a>

                <a href="#">
                    <span>Colleges</span>
                </a>

                <a href="#">
                    <span>Inquiry</span>
                </a>

                <a href="#">
                    <span>Apply</span>
                </a>
            </div>
        </header>

        <main class="flex h-auto px-5">
            <div class="flex flex-col items-center w-3/4 h-auto gap-4 px-12 py-8 border-r-2 border-yellow-400">
                <span class="text-4xl font-bold text-yellow-500">Welcome to PLM Online Admission</span>

                <img src="{{ asset('assets/image/plm.png') }}" class="w-3/4 h-auto">

                <div class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
                    <span class="text-2xl">About PLM Admission</span>
                    
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
                </div>

                <div class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
                    <span class="text-2xl">Who May Apply</span>
                    
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
                </div>

                <div class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
                    <span class="text-2xl">How To Apply</span>
                    
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
                </div>

                <div class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
                    <span class="text-2xl">Available Programs</span>
                    
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
                </div>
            </div>

            <div class="flex flex-col items-center w-1/4 h-auto px-2 py-8 bg-blue-500">
                <div class="w-11/12 h-12 bg-black">
                </div>

                <div>
                </div>
            </div>
        </main>
        
        <footer class="h-12 border-t-2 border-yellow-400">

        </footer>
    </body>
</html>

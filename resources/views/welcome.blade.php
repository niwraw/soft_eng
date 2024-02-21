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

                <a href="{{ route('register') }}">
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

            <div class="flex flex-col items-center w-1/4 h-auto gap-10 px-2 py-8">
                <div class="w-11/12 h-auto overflow-hidden bg-gray-100 border-2 border-yellow-400 rounded-xl">
                    <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
                        <span class="text-2xl font-bold text-white ">PLM Online Admission</span>
                    </div>

                    <div class="px-5 py-3">
                        <form method="POST" action="">
                            <div class="flex flex-col gap-5">
                                <div class="flex flex-col gap-2">
                                    <label class="block text-gray-700 text-m">Email Address</label>
                                    <div class="mt-1">
                                        <input id="email" name="email" type="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="block text-gray-700 text-m">Password</label>
                                    <div class="mt-1">
                                        <input id="password" name="password" type="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>

                                <a href="#" class="text-gray-700">Forgot your password?</a>

                                <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="w-11/12 h-auto overflow-hidden bg-gray-100 border-2 border-yellow-400 rounded-xl">
                    <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
                        <span class="text-2xl font-bold text-white ">Important Dates</span>
                    </div>
                    
                    <div class="flex flex-col gap-3 px-5 py-3">
                        <div class="flex flex-row gap-3">
                            <span class="font-bold">January 1, 2021:</span>
                            <span>Start of Application</span>
                        </div>
                        
                        <div class="flex flex-row gap-3">
                            <span class="font-bold">January 1, 2021:</span>
                            <span>End of Application</span>
                        </div>
                    </div>
                </div>

                <div class="w-11/12 overflow-hidden bg-gray-100 border-2 border-yellow-400 h-96 rounded-xl">
                    <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
                        <span class="text-2xl font-bold text-white ">Advisory</span>
                    </div>
                    
                    <div class="flex flex-col gap-3 px-5 py-3 overflow-x-hidden overflow-y-scroll h-5/6 ">
                        <?php for ($i = 0; $i < 10; $i++) { ?>
                            <div class="flex flex-col gap-2 pb-3 border-b-2 border-yellow-400">
                                    <h3 class="font-bold">January 1, 2021</h3>
                                    
                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Obcaecati, unde.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
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

        <div class="flex flex-col items-center justify-center pt-4 pb-2 bg-gray-400">
            <p>Copyright 1967-2023 Pamantasan ng Lungsod ng Maynila. All Rights Reserved.</p>
            <p>Admission Office</p>
        </div>
    </body>
</html>

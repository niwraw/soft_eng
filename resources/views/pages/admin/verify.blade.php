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
    <body class="antialiased ">
        <div class="grid w-screen h-screen" style="grid-template-columns: 1fr 2fr;">
            <div class="px-8 py-6 overflow-hidden">
                <h1 class="mb-8 text-2xl font-bold">Verify Applicant No. {{ $applicantId }}</h1>
                
                <div class="flex flex-col gap-5 px-5 py-3 overflow-x-hidden overflow-y-scroll bg-gray-100 border-2 border-gray-600 h-5/6">
                    @include('pages.admin.sections.verify.personalInfo')
                    @include('pages.admin.sections.verify.otherInfo')
                    @include('pages.admin.sections.verify.fatherInfo')
                    @include('pages.admin.sections.verify.motherInfo')
                    @include('pages.admin.sections.verify.guardianInfo')
                    @include('pages.admin.sections.verify.schoolInfo')
                    @include('pages.admin.sections.verify.choice')
                </div>
            </div>
            
            <div class="bg-red-200">
            </div>
        </div>
    </body>
</html>

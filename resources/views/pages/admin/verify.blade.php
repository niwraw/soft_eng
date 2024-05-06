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
            
            <div class="flex flex-col items-center px-8 py-6 bg-red-200">
                <div class="grid w-11/12 mb-8" style="grid-template-columns: 1fr 2fr;">
                    <h1 class="text-2xl font-bold ">Documents of Applicant</h1>

                    <div class="flex justify-end gap-4">
                        <button class="px-5 py-2 text-xs font-medium text-gray-800 transition-colors duration-200 bg-gray-200 sm:text-sm" onclick="changeDocument('{{ asset($documents->birthCert) }}')">
                            Birth Certificate
                        </button>

                        <button class="px-5 py-2 text-xs font-medium text-gray-800 transition-colors duration-200 bg-gray-200 sm:text-sm" onclick="changeDocument('{{ asset($documents->form137) }}')">
                            Form 137
                        </button>
                    </div>
                </div>
                
                <iframe id="documentViewer" src="{{ asset($documents->birthCert) }}" class="w-11/12 border-0 h-5/6"></iframe>
                
                <div class="flex justify-end w-11/12 gap-4 mt-4">
                    <a href=""class="px-5 py-2 mt-4 text-sm font-medium text-white transition-colors duration-200 bg-red-600">
                        Back
                    </a>
                    <button id="showFormButton" class="px-5 py-2 mt-4 text-sm font-medium text-white transition-colors duration-200 bg-green-600">
                        Verify
                    </button>
                </div>
            </div>
        </div>
        <div id="floatingForm" class="hidden">
            <div class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-md">
                <div class="w-3/6 p-8 bg-white rounded-lg shadow-lg">
                    <form action="" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                        </div>
                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                        </div>
                        <div class="flex justify-end w-full gap-4 mt-4">
                            <button type="button" onclick="toggleForm()" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600">Cancel</button>
                            <button type="submit" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    <script>
        function changeDocument(path) {
            const iframe = document.getElementById('documentViewer');
            iframe.src = path;
        }

        function toggleForm() {
            var form = document.getElementById('floatingForm');
            form.classList.toggle('hidden');
        }

        document.getElementById('showFormButton').addEventListener('click', toggleForm);
    </script>
</html>

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
    <body class="">
        <div class="grid px-1 mb-2 h-fit" style="grid-template-columns: 1fr 2fr 1fr;">
            <div class="flex items-center justify-center">
                <img src="{{ asset('assets/image/school.png') }}" class="h-28 w-28">
            </div>

            <div class="flex flex-col items-center justify-center">
                <h1 class="text-lg font-semibold">Pamantasan ng Lungsod ng Maynila</h1>
                <h2 class="text-sm">University of the City of Manila</h2>
                <h2 class="text-sm">Intramuros, Manila</h2>
                <h2 class="mt-4 font-semibold">PLM Applicant Form</h2>
            </div>

            <div class="flex justify-end">
                <div class="flex flex-col items-center justify-center border-2 border-black w-36 h-36">
                    <span class="text-sm">Paste 1.5 X 1.5 ID</span>
                    <span class="text-sm">Picture Here</span>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <span class="text-xs">Applicant ID: 2021-01278</span>
        </div>

        <div class="mb-2">
            <span class="text-xs font-bold border-b border-black">PERSONAL INFORMATION</span>
        </div>

        <div class="grid gap-4" style="grid-template-columns:1fr 2fr 2fr 2fr 2fr;">
            <span class="text-xs ">Full Name:</span>
            
            <span class="text-xs font-semibold text-center border-b border-black">
                John Vincent
            </span>

            <span class="text-xs font-semibold text-center border-b border-black">
                Lo
            </span>

            <span class="text-xs font-semibold text-center border-b border-black">
                Guanco
            </span>

            <span class="text-xs font-semibold text-center border-b border-black">
            </span>
        </div>

        <div class="grid gap-4 mb-2" style="grid-template-columns:1fr 2fr 2fr 2fr 2fr;">
            <span class="text-xs"></span>

            <span class="text-xs text-center">First Name</span>

            <span class="text-xs text-center">Middle Name</span>

            <span class="text-xs text-center">Last Name</span>

            <span class="text-xs text-center">Extension Name</span>
        </div>

        <div class="grid gap-4 mb-2" style="grid-template-columns:1fr 8fr;">
            <span class="text-xs">Address: </span>

            <span class="text-xs font-semibold border-b border-black">
                John Vincenta sda sda sas 
            </span>
        </div>

        <div class="grid gap-4 mb-2" style="grid-template-columns:1fr 8fr;">
            <span class="text-xs">Province: </span>

            <span class="text-xs font-semibold border-b border-black">
                John Vincenta sda sda sas 
            </span>
        </div>

        <div class="grid gap-4 mb-2" style="grid-template-columns:1fr 8fr;">
            <span class="text-xs">Region: </span>

            <span class="text-xs font-semibold border-b border-black">
                John Vincenta sda sda sas 
            </span>
        </div>

        <div class="grid gap-4 mb-2" style="grid-template-columns:1fr 2fr 1fr 2fr 1fr 2fr;">
            <span class="text-xs ">Birth Date:</span>
            
            <span class="text-xs font-semibold text-center border-b border-black">
                January 13, 2003
            </span>

            <span class="text-xs ">Birth Place:</span>
            
            <span class="text-xs font-semibold text-center border-b border-black">
                Kalibo Aklan
            </span>

            <span class="text-xs ">Sex at Birth:</span>
            
            <span class="text-xs font-semibold text-center border-b border-black">
                Male
            </span>
        </div>

        <div class="mb-2">
            <span class="text-xs font-bold border-b border-black">FAMILY INFORMATION</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr 3fr;">
            <span class="text-xs text-center border-t border-b border-l border-r border-black">Particulars</span>

            <span class="text-xs text-center border-t border-b border-r border-black">Father</span>

            <span class="text-xs text-center border-t border-b border-r border-black">Mother</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">Full Name: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>

            <span class="pl-2 text-xs border-b border-r border-black">Mother</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">Address: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>

            <span class="pl-2 text-xs border-b border-r border-black">Mother</span>
        </div>

        

        <div class="grid" style="grid-template-columns:1.1fr 3fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">Contact No.: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>

            <span class="pl-2 text-xs border-b border-r border-black">Mother</span>
        </div>

        <div class="grid mb-2" style="grid-template-columns:1.1fr 3fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">Monthly Income: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>

            <span class="pl-2 text-xs border-b border-r border-black">Mother</span>
        </div>

        <div class="mb-2">
            <span class="text-xs font-bold border-b border-black">SCHOOL INFORMATION</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-t border-b border-l border-r border-black">LRN: </span>

            <span class="pl-2 text-xs border-t border-b border-r border-black">Father</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">STRAND: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">School Name: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">School Address: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">School Email: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">General Weighted Average (GWA): </span>

            <span class="pl-2 text-xs border-b border-r border-black">Grade 11: </span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">Program Choice 1: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">Program Choice 2: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>
        </div>

        <div class="grid" style="grid-template-columns:1.1fr 3fr;">
            <span class="pl-2 text-xs border-b border-l border-r border-black">Program Choice 3: </span>

            <span class="pl-2 text-xs border-b border-r border-black">Father</span>
        </div>

        <div class="flex flex-col gap-24 mt-20">
            <div class="flex gap-10">
                <div>
                    <div class="font-bold border-b border-black w-60"></div>
                    <div class="text-xs text-center">Signature Over Printed Name of Applicant</div>
                </div>

                <div>
                    <div class="font-bold border-b border-black w-44"></div>
                    <div class="text-xs text-center">Date</div>
                </div>
            </div>
            
            <div class="flex gap-10">
                <div>
                    <div class="font-bold border-b border-black w-60"></div>
                    <div class="text-xs text-center">Signature Over Printed Name of Guardian</div>
                </div>

                <div>
                    <div class="font-bold border-b border-black w-44"></div>
                    <div class="text-xs text-center">Date</div>
                </div>
            </div>
        </div>
    </body>
</html>

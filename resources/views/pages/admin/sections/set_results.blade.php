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

        <style>
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            input[type="number"] {
            -moz-appearance: textfield;
            }

            .no-scroll {
                overflow: hidden;
            }
        </style>
    </head>
    <body class="antialiased ">
        <div class="grid w-screen h-screen" style="grid-template-columns: 1fr 2fr;">
            <div class="px-8 py-6 overflow-hidden bg-blue-800 border-r-4 border-yellow-600">
                <h1 class="mb-8 text-2xl font-bold text-yellow-500">Set Result of Applicant No. {{ $applicantId }}</h1>
                
                <div class="flex flex-col gap-5 px-5 py-3 overflow-x-hidden overflow-y-scroll bg-gray-100 border-2 border-gray-600 h-5/6">
                    @include('pages.admin.sections.verify.choice')
                    @include('pages.admin.sections.verify.personalInfo')
                    @include('pages.admin.sections.verify.otherInfo')
                    @include('pages.admin.sections.verify.fatherInfo')
                    @include('pages.admin.sections.verify.motherInfo')
                    
                    @if ($guardianInformation != null)
                        @include('pages.admin.sections.verify.guardianInfo')
                    @endif
                    
                    @include('pages.admin.sections.verify.schoolInfo')
                    
                </div>
            </div>
            
            <div class="flex flex-col px-8 py-6">
                <form action="{{ route('admin.set.result.submit', ['currentRoute' => $currentRoute, 'applicationType' => $applicationType, 'applicantId' => $applicantId]) }}" method="POST" class="flex flex-col gap-7" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-row gap-3 mb-8">
                        <div class="w-1/6">
                            <x-input-label for="remarks" :value="__('Remarks')" />
                            <div>
                                <select name="remarks" id="remarks" class="block w-full mt-1" required>
                                    <option value="" disabled selected>Please select</option>
                                    <option value="with">With Course</option>
                                    <option value="without">Without Course</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row gap-3 mb-8">
                        <div class="w-1/3">
                            <x-input-label for="rank" :value="__('Ranking')" />
                            <x-text-input id="rank" class="block w-full mt-1" type="number" name="rank" required autofocus/>
                            <x-input-error :messages="$errors->get('rank')" class="mt-2" />
                        </div>

                        <div class="w-1/3">
                            <x-input-label for="score" :value="__('Exam Score')" />
                            <x-text-input id="score" class="block w-full mt-1" type="number" name="score" required autofocus/>
                            <x-input-error :messages="$errors->get('score')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-row gap-3 mb-8" id="course_drop">
                        <div class="w-1/2">
                            <x-input-label for="course" :value="__('Course Assignment')" />
                            <div>
                                <select name="course" id="course" class="block w-full mt-1">
                                    <option value="" disabled selected>Please select</option>
                                    <option value="first">{{ $selectionInfo->choice1 }}</option>
                                    <option value="second">{{ $selectionInfo->choice2 }}</option>
                                    <option value="third">{{ $selectionInfo->choice3 }}</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('course')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex justify-end w-full gap-4 mt-4">
                        <a href="{{ route('admin.page', ['currentRoute'=>'result']) }}"class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600">
                            Back
                        </a>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const remarks = document.getElementById('remarks');
            const course_drop = document.getElementById('course_drop');
            const course = document.getElementById('course');

            remarks.addEventListener('change', (e) => {
                if (e.target.value === 'with') {
                    course_drop.style.display = 'flex';
                    course.required = true;
                } else {
                    course_drop.style.display = 'none';
                    course.required = false;
                }
            });
        </script>
    </body>
</html>

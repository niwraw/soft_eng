<div class="w-auto pt-8 pr-8">
    <div class="grid w-auto" style="grid-template-columns: 3fr 1fr;">
        <div class="flex flex-col items-center gap-8 pt-4">
            <div class="grid w-11/12 bg-gray-100 border-2 border-gray-700 h-fit rounded-2xl" style="grid-template-columns: 1fr 1fr;">
                <div class="p-6">
                    <h1 class="mb-4 text-lg font-semibold text-yellow-500">Personal Information</h1>

                    <div class="w-full h-fit">
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Surname:</h3>
                            <p>{{ $personalInfo->lastName }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>First Name:</h3>
                            <p>{{ $personalInfo->firstName }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Middle Name:</h3>
                            <p>{{ $personalInfo->middleName }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Extension Name:</h3>
                            @if($personalInfo->suffix != "None")
                                <p>{{ $personalInfo->suffix }}</p>
                            @else
                                <p></p>
                            @endif
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Email:</h3>
                            <p>{{ $personalInfo->email }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Phone Number:</h3>
                            <p>{{ $personalInfo->contactNum }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h1 class="mb-4 text-lg font-semibold text-yellow-500">School Information</h1>

                    <div class="w-full h-fit">
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>School:</h3>
                            <p>{{ $schoolInfo->school }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>LRN:</h3>
                            <p>{{ $schoolInfo->lrn }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>School Email:</h3>
                            <p>{{ $schoolInfo->schoolEmail }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Program Choice 1:</h3>
                            <p>{{ $selectionInfo->choice1 }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Program Choice 2:</h3>
                            <p>{{ $selectionInfo->choice2 }}</p>
                        </div>
                        <div class="grid mb-4" style="grid-template-columns: 1fr 2fr;">
                            <h3>Program Choice 3:</h3>
                            <p>{{ $selectionInfo->choice3 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-11/12 p-4 bg-gray-100 border-2 border-gray-700 h-fit rounded-2xl">
                <h1 class="mb-4 text-lg font-semibold text-yellow-500">Other Requirements Status</h1>

                <div class="w-full h-fit">
                    <div class="grid gap-6 pb-3 font-semibold text-center" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
                        <h3>Requirement</h3>
                        <h3>Status</h3>
                        <h3>Remarks</h3>
                        <h3>Actions</h3>
                    </div>

                    <div class="grid gap-6 pb-4" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
                        <h4 class="font-medium">Document: Birth Certificate</h4>
                        @if ($document->birthCertStatus == 'pending')
                            <div class="flex items-center justify-center px-1 bg-yellow-500 rounded-2xl h-fit">
                        @elseif ($document->birthCertStatus == 'approved')
                            <div class="flex items-center justify-center px-1 bg-green-500 rounded-2xl h-fit">
                        @elseif ($document->birthCertStatus == 'resubmission')
                            <div class="flex items-center justify-center px-1 bg-red-500 rounded-2xl h-fit">
                        @endif
                            {{ ucfirst($document->birthCertStatus) }}
                        </div>
                        <p>{{ $document->birthCertComment }}</p>
                        @if ($document->birthCertStatus == 'resubmission')
                            <button id="showFormButton1">
                                <div class="flex items-center justify-center px-1 bg-yellow-300 h-fit rounded-2xl">Submit</div>
                            </button>
                        @endif
                    </div>

                    <div class="grid gap-6 pb-4" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
                        <h4 class="font-medium">
                            @if($personalInfo->applicationType == 'SHS')
                                Document: Form137
                            @elseif ($personalInfo->applicationType == 'TRANSFER')
                                Document: TOR
                            @elseif ($personalInfo->applicationType == 'ALS')
                                Document: ALS Certificate
                            @elseif ($personalInfo->applicationType == 'OLD')
                                Document: Approval Letter
                            @endif
                        </h4>
                            @if ($personalInfo->applicationType != 'OLD')
                                @if ($document->othersStatus == 'pending')
                                    <div class="flex items-center justify-center px-1 bg-yellow-500 rounded-2xl h-fit">
                                @elseif ($document->othersStatus == 'approved')
                                    <div class="flex items-center justify-center px-1 bg-green-500 rounded-2xl h-fit">
                                @elseif ($document->othersStatus == 'resubmission')
                                    <div class="flex items-center justify-center px-1 bg-red-500 rounded-2xl h-fit">
                                @endif
                                    {{ ucfirst($document->othersStatus) }}
                            @else
                                @if ($document->approvalLetterStatus == 'pending')
                                    <div class="flex items-center justify-center px-1 bg-yellow-500 rounded-2xl h-fit">
                                @elseif ($document->approvalLetterStatus == 'approved')
                                    <div class="flex items-center justify-center px-1 bg-green-500 rounded-2xl h-fit">
                                @elseif ($document->approvalLetterStatus == 'resubmission')
                                    <div class="flex items-center justify-center px-1 bg-red-500 rounded-2xl h-fit">
                                @endif
                                    {{ ucfirst($document->approvalLetterStatus) }}
                            @endif
                        </div>
                        @if ($personalInfo->applicationType != 'OLD')
                            <p>{{ $document->othersComment }}</p>
                        @else
                            <p>{{ $document->approvalLetterComment }}</p>
                        @endif

                        
                        @if ($personalInfo->applicationType != 'OLD')
                            @if ($document->othersStatus == 'resubmission')
                                <button id="showFormButton2">
                                    <div class="flex items-center justify-center px-1 bg-yellow-300 h-fit rounded-2xl">Submit</div>
                                </button>
                            @endif
                        @else
                            @if ($document->approvalLetterStatus == 'resubmission')
                                <button id="showFormButton2">
                                    <div class="flex items-center justify-center px-1 bg-yellow-300 h-fit rounded-2xl">Submit</div>
                                </button>
                            @endif
                        @endif
                    </div>

                    @if($personalInfo->applicationType == 'OLD')
                        <div class="grid gap-6 pb-4" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
                            <h4 class="font-medium">Document: High School Card</h4>
                            @if ($document->highSchoolCardStatus == 'pending')
                                <div class="flex items-center justify-center px-1 bg-yellow-500 rounded-2xl h-fit">
                            @elseif ($document->highSchoolCardStatus == 'approved')
                                <div class="flex items-center justify-center px-1 bg-green-500 rounded-2xl h-fit">
                            @elseif ($document->highSchoolCardStatus == 'resubmission')
                                <div class="flex items-center justify-center px-1 bg-red-500 rounded-2xl h-fit">
                            @endif
                                {{ ucfirst($document->highSchoolCardStatus) }}
                            </div>
                            <p>{{ $document->highSchoolCardComment }}</p>
                            @if ($document->highSchoolCardStatus == 'resubmission')
                                <button id="showFormButton4">
                                    <div class="flex items-center justify-center px-1 bg-yellow-300 h-fit rounded-2xl">Submit</div>
                                </button>
                            @endif
                        </div>
                    @endif

                    @if ($applicationForm == "Available")
                    <div class="grid gap-6 pb-4" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
                        <h4 class="font-medium">Document: Application Form</h4>
                        @if($appStatus == 'Not Submitted')
                            <div class="flex items-center justify-center px-1 bg-red-500 rounded-2xl h-fit">
                        @elseif ($form->applicationFormStatus == 'pending' && $appStatus == 'Submitted')
                            <div class="flex items-center justify-center px-1 bg-yellow-500 rounded-2xl h-fit">
                        @elseif ($form->applicationFormStatus == 'approved' && $appStatus == 'Submitted')
                            <div class="flex items-center justify-center px-1 bg-green-500 rounded-2xl h-fit">
                        @elseif ($form->applicationFormStatus == 'resubmission' && $appStatus == 'Submitted')
                            <div class="flex items-center justify-center px-1 bg-red-500 rounded-2xl h-fit">
                        @endif
                            @if ($appStatus == 'Submitted')
                                {{ ucfirst($form->applicationFormStatus) }}
                            @else
                                Not Submitted
                            @endif
                        </div>
                        
                        <p>
                            @if($appStatus == 'Submitted')
                                {{ $form->applicationFormComment }}
                            @endif
                        </p>

                        @if ($form == null || $form->applicationFormStatus == 'resubmission')
                            <button id="showFormButton3">
                                <div class="flex items-center justify-center px-1 bg-yellow-300 h-fit rounded-2xl">Submit</div>
                            </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center gap-8 pt-4">
            <div class="w-11/12 p-4 bg-gray-100 border-2 border-gray-700 h-fit rounded-2xl">
                <h1 class="mb-4 text-xl font-semibold text-yellow-500">Documents Status</h1>

                <div class="flex flex-col gap-8">
                    <div class="grid" style="grid-template-columns: 1fr 1fr;">
                        <h3>Requirements:</h3>
                        @if ($personalInfo->status == 'pending')
                            <p class="w-full text-center bg-yellow-500 h-fit rounded-xl">
                        @elseif ($personalInfo->status == 'approved')
                            <p class="w-full text-center bg-green-500 h-fit rounded-xl">
                        @elseif ($personalInfo->status == 'resubmission')
                            <p class="w-full text-center bg-red-500 h-fit rounded-xl">
                        @endif
                            {{ ucfirst($personalInfo->status) }}
                        </p>
                    </div>

                    <div class="grid" style="grid-template-columns: 1fr 1fr;">
                        <h3>Application Form</h3>
                        @if( $applicationForm == "Not Available")
                            <p class="w-full text-center bg-red-500 h-fit rounded-xl">
                        @else
                            <p class="w-full text-center bg-green-500 h-fit rounded-xl">
                        @endif
                            {{ $applicationForm }}
                        </p>
                    </div>

                    @if( $applicationForm != "Not Available")
                        <div class="flex items-center justify-around gap-4 py-4">
                            <a href="{{ route('applicant.generate.application', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" class="w-full h-6 text-center bg-blue-500 rounded-2xl">Download</a>
                        </div>
                    @else
                        <div class="flex items-center justify-around gap-4 py-4">
                            <a href="{{ route('applicant.edit.information', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" class="w-full h-6 text-center bg-blue-500 rounded-2xl">Edit Information</a>
                        </div>
                    @endif
                </div>
            </div>

            @if($form != null && $form->applicationFormStatus == 'approved')
            <div class="w-11/12 p-4 bg-gray-100 border-2 border-gray-700 h-fit rounded-2xl">
                <h1 class="mb-4 text-xl font-semibold text-yellow-500">Exam Details Will Be Provided Soon!</h1>
            </div>
            @endif
        </div>
    </div>
</div>

<div id="floatingForm1" class="hidden">
    <div class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-md">
        <div class="w-3/6 p-8 bg-white rounded-lg shadow-lg h-fit">
            <form action="{{ route('applicant.resubmitBirth', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h1 class="mb-8">Resubmission of Birth Certificate</h1>

                <div class="mb-4">
                    <x-input-label for="birthCert" :value="__('Birth Certificate (PSA)')" />
                    <x-text-input id="birthCert" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="birthCert" required accept=".pdf"/>
                    <x-input-error :messages="$errors->get('birthCert')" class="mt-2" />
                </div>

                @if($errors->any())
                    <script>
                        alert(`{{ implode('\n', $errors->all()) }}`);
                    </script>
                @endif
                
                <div class="flex justify-end w-full gap-4 mt-4">
                    <button type="button" onclick="toggleForm1()" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="floatingForm2" class="hidden">
    <div class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-md">
        <div class="w-3/6 p-8 bg-white rounded-lg shadow-lg h-fit">
            <form action="{{ route('applicant.resubmitForm137', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h1 class="mb-8">
                    @if($personalInfo->applicationType == 'SHS')
                        Resubmission of Form 137
                    @elseif ($personalInfo->applicationType == 'TRANSFER')
                        Resubmission of TOR
                    @elseif ($personalInfo->applicationType == 'ALS')
                        Resubmission of ALS Certificate
                    @elseif ($personalInfo->applicationType == 'OLD')
                        Resubmission of Approval Letter
                    @endif
                </h1>

                <div class="mb-4">
                    @if($personalInfo->applicationType == 'SHS')
                        <x-input-label for="form137" :value="__('Form 137')" />
                    @elseif ($personalInfo->applicationType == 'TRANSFER')
                        <x-input-label for="form137" :value="__('TOR')" />
                    @elseif ($personalInfo->applicationType == 'ALS')
                        <x-input-label for="form137" :value="__('ALS Certificate')" />
                    @elseif ($personalInfo->applicationType == 'OLD')
                        <x-input-label for="form137" :value="__('Approval Letter')" />
                    @endif
                    
                    <x-text-input id="form137" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="form137" required accept=".pdf"/>
                    <x-input-error :messages="$errors->get('form137')" class="mt-2" />
                </div>

                @if($errors->any())
                    <script>
                        alert(`{{ implode('\n', $errors->all()) }}`);
                    </script>
                @endif
                
                <div class="flex justify-end w-full gap-4 mt-4">
                    <button type="button" onclick="toggleForm2()" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="floatingForm3" class="hidden">
    <div class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-md">
        <div class="w-3/6 p-8 bg-white rounded-lg shadow-lg h-fit">
            <form action="{{ route('applicant.upload.application', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h1 class="mb-8">
                    @if($form == null)
                        Submission of Application Form
                    @else
                        Resubmission of Application Form
                    @endif
                </h1>

                <div class="mb-4">
                    <x-input-label for="appform" :value="__('Application Form')" />
                    <x-text-input id="appform" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="appform" required accept=".pdf"/>
                    <x-input-error :messages="$errors->get('appform')" class="mt-2" />
                </div>

                @if($errors->any())
                    <script>
                        alert(`{{ implode('\n', $errors->all()) }}`);
                    </script>
                @endif
                
                <div class="flex justify-end w-full gap-4 mt-4">
                    <button type="button" onclick="toggleForm3()" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="floatingForm4" class="hidden">
    <div class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-md">
        <div class="w-3/6 p-8 bg-white rounded-lg shadow-lg h-fit">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <h1 class="mb-8">Resubmission of High School Card</h1>

                <div class="mb-4">
                    <x-input-label for="card" :value="__('Form High School Card')" />
                    <x-text-input id="card" class="block w-full px-3 py-2 mt-1 border-2 border-gray-500" type="file" name="card" required accept=".pdf"/>
                    <x-input-error :messages="$errors->get('card')" class="mt-2" />
                </div>

                @if($errors->any())
                    <script>
                        alert(`{{ implode('\n', $errors->all()) }}`);
                    </script>
                @endif
                
                <div class="flex justify-end w-full gap-4 mt-4">
                    <button type="button" onclick="toggleForm4()" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($document->birthCertStatus == 'resubmission')
<script>
    function toggleForm1() {
        var form = document.getElementById('floatingForm1');
        form.classList.toggle('hidden');
    }

    document.getElementById('showFormButton1').addEventListener('click', toggleForm1);
</script>
@endif

@if($personalInfo->applicationType != 'OLD')
    @if ($document->othersStatus == 'resubmission')
    <script>
        function toggleForm2() {
            var form = document.getElementById('floatingForm2');
            form.classList.toggle('hidden');
        }

        document.getElementById('showFormButton2').addEventListener('click', toggleForm2);
    </script>
    @endif
@else
    @if ($document->approvalLetterStatus == 'resubmission')
    <script>
        function toggleForm2() {
            var form = document.getElementById('floatingForm2');
            form.classList.toggle('hidden');
        }

        document.getElementById('showFormButton2').addEventListener('click', toggleForm2);
    </script>
    @endif
@endif

@if ( $form == null  || $form->applicationFormStatus == 'resubmission')
<script>
    function toggleForm3() {
        var form = document.getElementById('floatingForm3');
        form.classList.toggle('hidden');
    }

    document.getElementById('showFormButton3').addEventListener('click', toggleForm3);
</script>
@endif

@if ($document->highSchoolCardStatus == 'resubmission')
<script>
    function toggleForm4() {
        var form = document.getElementById('floatingForm4');
        form.classList.toggle('hidden');
    }

    document.getElementById('showFormButton4').addEventListener('click', toggleForm4);
</script>
@endif
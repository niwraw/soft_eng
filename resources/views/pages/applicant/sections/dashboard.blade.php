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
                    <div class="grid gap-4 mb-3 text-center" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
                        <h3>Requirement</h3>
                        <h3>Status</h3>
                        <h3>Remarks</h3>
                        <h3>Actions</h3>
                    </div>

                    <div class="grid gap-4 px-2 mb-4" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
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
                        <p></p>
                        <a href="">
                            <div class="flex items-center justify-center px-1 bg-yellow-300 h-fit rounded-2xl">Submit</div>
                        </a>
                    </div>

                    <div class="grid gap-4 px-2 mb-4" style="grid-template-columns: 2fr 1fr 3fr 1fr;">
                        <h4 class="font-medium">Document: Form137</h4>
                        @if ($document->othersStatus == 'pending')
                            <div class="flex items-center justify-center px-1 bg-yellow-500 rounded-2xl h-fit">
                        @elseif ($document->othersStatus == 'approved')
                            <div class="flex items-center justify-center px-1 bg-green-500 rounded-2xl h-fit">
                        @elseif ($document->othersStatus == 'resubmission')
                            <div class="flex items-center justify-center px-1 bg-red-500 rounded-2xl h-fit">
                        @endif
                            {{ ucfirst($document->othersStatus) }}
                        </div>
                        <p></p>
                        <a href="">
                            <div class="flex items-center justify-center px-1 bg-yellow-300 h-fit rounded-2xl">Submit</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center gap-8 pt-4">
            <div class="w-11/12 p-4 bg-gray-100 border-2 border-gray-700 h-fit rounded-2xl">
                <h1 class="mb-4 text-xl font-semibold text-yellow-500">Documents Status</h1>

                <div class="flex flex-col gap-8">
                    <div class="grid" style="grid-template-columns: 1fr 1fr;">
                        <h3>Requirements:</h3>
                        @if ($overallStatus== 'pending')
                            <p class="w-full text-center bg-yellow-500 h-fit rounded-xl">
                        @elseif ($overallStatus == 'approved')
                            <p class="w-full text-center bg-green-500 h-fit rounded-xl">
                        @elseif ($overallStatus == 'resubmission')
                            <p class="w-full text-center bg-red-500 h-fit rounded-xl">
                        @endif
                            {{ ucfirst($overallStatus) }}
                        </p>
                    </div>

                    <div class="grid" style="grid-template-columns: 1fr 1fr;">
                        <h3>Application Form</h3>
                        <p class="w-full text-center bg-red-500 h-fit rounded-xl">
                            Not Available
                        </p>
                    </div>

                    <div class="flex items-center justify-around gap-4 py-4">
                        <button id="download_app" class="w-full h-6 bg-blue-500 rounded-2xl">Download</button>
                        <button id="submit_app" class="w-full h-6 bg-yellow-500 rounded-2xl">Submit</button>
                    </div>
                </div>
            </div>


            <div class="w-11/12 p-4 bg-gray-100 border-2 border-gray-700 h-fit rounded-2xl">
                <h1 class="mb-4 text-xl font-semibold text-yellow-500">Exam Details</h1>

                <div class="flex items-center justify-between p-2">
                    <h3 class="font-semibold">Exam Date</h3>
                    <p>January 1, 2023</p>
                </div>

                <div class="flex items-center justify-between p-2">
                    <h3 class="font-semibold">Exam Time</h3>
                    <p>13:00-15:00</p>
                </div>

                <div class="flex items-center justify-between p-2">
                    <h3 class="font-semibold">Assigned Building</h3>
                    <p>Gusaling Villegas</p>
                </div>

                <div class="flex items-center justify-between p-2">
                    <h3 class="font-semibold">Assigned Room</h3>
                    <p>310</p>
                </div>

                <div class="flex items-center justify-center w-full mt-4">
                    <button id="download" class="w-10/12 bg-yellow-500 h-fit rounded-2xl">Download Exam Slip</button>
                </div>
                
            </div>
        </div>
    </div>
</div>
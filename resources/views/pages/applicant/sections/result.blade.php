<div class="w-auto pt-8 pr-8">
    @if($examDetails->hasResult == "yes")
        @if($examDetails->confirmed == "no")
            <div class="flex flex-col gap-5">
                <div class="flex flex-col gap-2">
                    <h2 class="text-2xl font-medium">Results of your PLMAT</h2>
                    @if($examDetails->remark == "with")
                        <p class="">We are glad to announce that you have passed the PLMAT for the upcoming school year. The results of your exam are provided below and your assigned course.<br><br>If you wish to continue enrolling for the next school year, please confirm your slot with the button below</p>
                    @elseif($examDetails->remark == "without")
                        <p class="text-sm">We are glad to announce that you have passed the PLMAT the upcoming school year. But you have beed placed as a waitlisted. Please check again next week if the opening of course selection.</p>
                    @else   
                        <p class="text-sm">Your result is not yet out. Please check back later.</p>
                    @endif
                </div>
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-medium">Exam Score</h3>
                        <p class="text-sm">{{ $examDetails->score }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-medium">Overall Ranking</h3>
                        <p class="text-sm">{{ $examDetails->rank }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-medium">Remarks</h3>
                        <p class="text-sm">
                            @if($examDetails->remark == "with")
                                Passed with Offered Course
                            @elseif($examDetails->remark == "without")
                                Waitlisted
                            @endif
                        </p>
                    </div>

                    @if($examDetails->remark == "with")
                        <div class="flex flex-col gap-2">
                            <h3 class="text-lg font-medium">Offered Course</h3>
                            <p class="text-sm">{{ $examDetails->courseOffer }}</p>
                        </div>

                        <a href="{{ route('applicant.confirm.slot', ['currentRoute' => $currentRoute, 'applicantId' => $applicantId]) }}" class="px-4 py-2 text-white bg-red-600 w-fit">Confirm Slot</a>
                    @endif
                    
                </div>
            </div>
        @else
            <div class="flex flex-col gap-2">
                <h2 class="text-2xl font-medium">Congratualtion!</h2>
                <p>You have successfully confirmed your slot for the upcoming school year. Please await for further instructions.</p>
            </div>
        @endif
    @endif
</div>
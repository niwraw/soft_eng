<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ApplicantPersonalInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantSelectionInformation;
use App\Models\CourseModel;

class ApplicantController extends Controller
{
    public function ApplicantPage($currentRoute, $applicantId, Request $request)
    {
        $personalInfo = ApplicantPersonalInformation::where('applicant_id', $applicantId)->first();
        $schoolInfo = ApplicantSchoolInformation::where('applicant_id', $applicantId)->first();
        $selectionInfo = ApplicantSelectionInformation::where('applicant_id', $applicantId)->first();
        
        $course1 = CourseModel::where('course_code', $selectionInfo->choice1)->first();
        $course2 = CourseModel::where('course_code', $selectionInfo->choice2)->first();
        $course3 = CourseModel::where('course_code', $selectionInfo->choice3)->first();

        $selectionInfo->choice1 = $course1->course;
        $selectionInfo->choice2 = $course2->course;
        $selectionInfo->choice3 = $course3->course;

        $routeSegment = request()->segment(1);
        return view('pages.applicant.applicant', compact('currentRoute', 'routeSegment', 'personalInfo', 'selectionInfo', 'schoolInfo'));
    }
}

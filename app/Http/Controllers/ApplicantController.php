<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ApplicantPersonalInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantSelectionInformation;
use App\Models\DocumentALS;
use App\Models\DocumentOLD;
use App\Models\DocumentSHS;
use App\Models\DocumentTRANSFER;
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

        if ($personalInfo->applicationType == 'SHS'){
            $document = DocumentSHS::where('applicant_id', $applicantId)->first();
        } elseif ($personalInfo->applicationType == 'ALS'){
            $document = DocumentALS::where('applicant_id', $applicantId)->first();
        } elseif ($personalInfo->applicationType == 'TRANSFER'){
            $document = DocumentTRANSFER::where('applicant_id', $applicantId)->first();
        } elseif ($personalInfo->applicationType == 'OLD'){
            $document = DocumentOLD::where('applicant_id', $applicantId)->first();
        }

        if($document->birthCertStatus == 'pending' || $document->formStatus == 'pending'){
            $overallStatus = 'pending';
        } else if ($document->birthCertStatus == 'resubmission' || $document->formStatus == 'resubmission') {
            $overallStatus = 'resubmission';
        } else if ($document->birthCertStatus == 'approved' && $document->formStatus == 'approved') {
            $overallStatus = 'approved';
        }

        $routeSegment = request()->segment(1);
        return view('pages.applicant.applicant', compact('currentRoute', 'routeSegment', 'personalInfo', 'selectionInfo', 'schoolInfo', 'document', 'overallStatus'));
    }
}

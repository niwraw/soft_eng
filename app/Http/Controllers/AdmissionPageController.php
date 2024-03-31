<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantList;
use App\Models\ApplicantOtherInformation;

class AdmissionPageController extends Controller
{
    public function AdmissionDashboard($currentRoute)
    {
        $shsApplicants = ApplicantList::where('applicationType', 'SHS')->where('activity', 'active')->get();
        $alsApplicants = ApplicantList::where('applicationType', 'ALS')->where('activity', 'active')->get();
        $oldApplicants = ApplicantList::where('applicationType', 'OLD')->where('activity', 'active')->get();
        $transferApplicants = ApplicantList::where('applicationType', 'TRANSFER')->where('activity', 'active')->get();

        $totalApplicants = $shsApplicants->count() + $alsApplicants->count() + $oldApplicants->count() + $transferApplicants->count();

        $maleApplicants = ApplicantList::where('gender', 'male')->where('activity', 'active')->count();
        $femaleApplicants = ApplicantList::where('gender', 'female')->where('activity', 'active')->count();

        $count= [
            'SHS' => count($shsApplicants),
            'ALS' => count($alsApplicants),
            'OLD' => count($oldApplicants),
            'TRANSFER' => count($transferApplicants),
        ];

        $status = [
            'approved' => ApplicantList::where('status', 'approved')->where('activity', 'active')->count(),
            'pending' => ApplicantList::where('status', 'pending')->where('activity', 'active')->count(),
            'resubmission' => ApplicantList::where('status', 'pending')->where('activity', 'active')->count(),
        ];

        $regions = [
            'I' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region I (Ilocos Region)')->where('activity', 'active')->count(),
            'II' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region II (Cagayan Valley)')->where('activity', 'active')->count(),
            'III' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region III (Central Luzon)')->where('activity', 'active')->count(),
            'IV-A' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region IV-A (CALABARZON)')->where('activity', 'active')->count(),
            'MIMAROPA' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'MIMAROPA')->where('activity', 'active')->count(),
            'V' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region V (Bicol Region)')->where('activity', 'active')->count(),
            'VI' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region VI (Western Visayas)')->where('activity', 'active')->count(),
            'VII' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region VII (Central Visayas)')->where('activity', 'active')->count(),
            'VIII' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region VIII (Eastern Visayas)')->where('activity', 'active')->count(),
            'IX' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region IX (Zamboanga Peninsula)')->where('activity', 'active')->count(),
            'X' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region X (Northern Mindanao)')->where('activity', 'active')->count(),
            'XI' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region XI (Davao Region)')->where('activity', 'active')->count(),
            'XII' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region XII (SOCCSKSARGEN)')->where('activity', 'active')->count(),
            'XIII' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region XIII (Caraga)')->where('activity', 'active')->count(),
            'ARMM' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Autonomous Region in Muslim Mindanao (ARMM)')->where('activity', 'active')->count(),
            'CAR' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Cordillera Administrative Region (CAR)')->where('activity', 'active')->count(),
            'NCR' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'National Capital Region (NCR)')->where('activity', 'active')->count(),
        ];

        $manilaRatio = [
            'manila' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('province', 'Ncr, City of Manila, First District')->where('activity', 'active')->count(),
            'nonManila' => ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('province', '!=', 'Ncr, City of Manila, First District')->where('activity', 'active')->count(),
        ];

        $routeSegment = request()->segment(1);
        return view('pages.admin.admission', compact('routeSegment', 'currentRoute', 'totalApplicants', 'maleApplicants', 'femaleApplicants', 'count', 'status', 'regions', 'manilaRatio'));
    }
}

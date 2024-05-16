<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantList;
use App\Models\ApplicantOtherInformation;
use App\Models\ApplicantFatherInformation;
use App\Models\ApplicantMotherInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantProgramInformation;
use App\Models\ApplicantGuardianInformation;
use App\Models\DocumentSHS;
use App\Models\CourseModel;
use App\Models\Regions;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\Barangays;
use App\Models\StartEnd;
use App\Models\Announcement;
use Carbon\Carbon;

class AdmissionPageController extends Controller
{
    public function AdmissionDashboard($currentRoute, Request $request)
    {
        $shsApplicants = ApplicantList::where('applicationType', 'SHS')->where('activity', 'active')->get();
        $alsApplicants = ApplicantList::where('applicationType', 'ALS')->where('activity', 'active')->get();
        $oldApplicants = ApplicantList::where('applicationType', 'OLD')->where('activity', 'active')->get();
        $transferApplicants = ApplicantList::where('applicationType', 'TRANSFER')->where('activity', 'active')->get();

        $type = $request->query('type', 'all');
        $statusType = $request->query('statusType', 'all');
        $searchApplicant = $request->query('searchApplicant', '');
        $query = ApplicantList::where('activity', 'active');

        if ($type !== 'all') {
            $query =  $query->where('applicationType', $type);
        }

        if ($statusType !== 'all') {
            $query =  $query->where('status', $statusType);
        }

        if (!empty($searchApplicant)) {
            $query = $query->where(function ($query) use ($searchApplicant) {
                $query->where('firstName', 'like', "%{$searchApplicant}%")
                      ->orWhere('lastName', 'like', "%{$searchApplicant}%")
                      ->orWhere('email', 'like', "%{$searchApplicant}%");
            });
        }

        $applicants = $query->paginate(8);

        $totalApplicants = $shsApplicants->count() + $alsApplicants->count() + $oldApplicants->count() + $transferApplicants->count();

        $maleApplicants = ApplicantList::where('gender', 'male')->where('activity', 'active')->count();
        $femaleApplicants = ApplicantList::where('gender', 'female')->where('activity', 'active')->count();

        $count= [
            'SHS' => count($shsApplicants),
            'ALS' => count($alsApplicants),
            'OLD' => count($oldApplicants),
            'TRANSFER' => count($transferApplicants),
        ];

        $approved = ApplicantList::where('status', 'approved')->where('activity', 'active')->count();
        $pending = ApplicantList::where('status', 'pending')->where('activity', 'active')->count();
        $resubmission = ApplicantList::where('status', 'resubmission')->where('activity', 'active')->count();

        $status = [
            'approved' => $approved,
            'pending' => $pending,
            'resubmission' => $resubmission,
        ];

        $region1 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region I (Ilocos Region)')->where('activity', 'active')->count();
        $region2 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region II (Cagayan Valley)')->where('activity', 'active')->count();
        $region3 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region III (Central Luzon)')->where('activity', 'active')->count();
        $region4A = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region IV-A (CALABARZON)')->where('activity', 'active')->count();
        $mimaropa = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'MIMAROPA')->where('activity', 'active')->count();
        $region5 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region V (Bicol Region)')->where('activity', 'active')->count();
        $region6 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region VI (Western Visayas)')->where('activity', 'active')->count();
        $region7 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region VII (Central Visayas)')->where('activity', 'active')->count();
        $region8 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region VIII (Eastern Visayas)')->where('activity', 'active')->count();
        $region9 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region IX (Zamboanga Peninsula)')->where('activity', 'active')->count();
        $region10 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region X (Northern Mindanao)')->where('activity', 'active')->count();
        $region11 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region XI (Davao Region)')->where('activity', 'active')->count();
        $region12 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region XII (SOCCSKSARGEN)')->where('activity', 'active')->count();
        $region13 = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Region XIII (Caraga)')->where('activity', 'active')->count();
        $armm = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Autonomous Region in Muslim Mindanao (ARMM)')->where('activity', 'active')->count();
        $car = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'Cordillera Administrative Region (CAR)')->where('activity', 'active')->count();
        $ncr = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('region', 'National Capital Region (NCR)')->where('activity', 'active')->count();

        $regions = [
            'I' => $region1,
            'II' => $region2,
            'III' => $region3,
            'IV-A' => $region4A,
            'MIMAROPA' => $mimaropa,
            'V' => $region5,
            'VI' => $region6,
            'VII' => $region7,
            'VIII' => $region8,
            'IX' => $region9,
            'X' => $region10,
            'XI' => $region11,
            'XII' => $region12,
            'XIII' => $region13,
            'ARMM' => $armm,
            'CAR' => $car,
            'NCR' => $ncr,
        ];

        $manila = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('province', 'Ncr, City of Manila, First District')->where('activity', 'active')->count();
        $nonManila = ApplicantOtherInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_other_information.applicant_id')->where('province', '!=', 'Ncr, City of Manila, First District')->where('activity', 'active')->count();

        $manilaRatio = [
            'manila' => $manila,
            'nonManila' => $nonManila,
        ];

        $inactive = ApplicantList::where('activity', 'inactive')->count();

        $abm = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'ABM')->where('activity', 'active')->count();
        $humss = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'HUMSS')->where('activity', 'active')->count();
        $stem = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'STEM')->where('activity', 'active')->count();
        $gas = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'GAS')->where('activity', 'active')->count();
        $tvl = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'TVL')->where('activity', 'active')->count();
        $sports = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'SPORTS')->where('activity', 'active')->count();
        $adt = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'ADT')->where('activity', 'active')->count();
        $pbm = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'PBM')->where('activity', 'active')->count();

        $strands = [
            'ABM' => $abm,
            'HUMSS' => $humss,
            'STEM' => $stem,
            'GAS' => $gas,
            'TVL' => $tvl,
            'SPORTS' => $sports,
            'ADT' => $adt,
            'PBM' => $pbm,
        ];

        // $manilaPublic = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->join('applicant_other_information', 'applicant_other_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('province', 'Ncr, City of Manila, First District')->where('schoolType', 'public')->where('activity', 'active')->count();

        // $manilaPrivate = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->join('applicant_other_information', 'applicant_other_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('province', 'Ncr, City of Manila, First District')->where('schoolType', 'private')->where('activity', 'active')->count();

        // $manilaSchoolType = [
        //     'public' => $manilaPublic,
        //     'private' => $manilaPrivate,
        // ];

        // $otherPublic = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->join('applicant_other_information', 'applicant_other_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('province', '!=', 'Ncr, City of Manila, First District')->where('schoolType', 'public')->where('activity', 'active')->count();

        // $otherPrivate = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->join('applicant_other_information', 'applicant_other_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('province', '!=', 'Ncr, City of Manila, First District')->where('schoolType', 'private')->where('activity', 'active')->count();

        $startDate = StartEnd::where('status', 'start')->first();
        $endDate = StartEnd::where('status', 'end')->first();

        $startDate->date = Carbon::parse($startDate->date)->format('F j, Y');
        $endDate->date = Carbon::parse($endDate->date)->format('F j, Y');

        $announcements = Announcement::paginate(6);

        $announcements->each(function ($annoucement) {
            $annoucement->date = Carbon::parse($annoucement->date)->format('F j, Y');
        });

        $routeSegment = request()->segment(1);
        return view('pages.admin.admission', compact('routeSegment', 'currentRoute', 'totalApplicants', 'maleApplicants', 'femaleApplicants', 'count', 'status', 'regions', 'manilaRatio', 'inactive', 'strands', 'applicants', 'type', 'statusType', 'searchApplicant', 'startDate', 'endDate', 'announcements'));
    }

    public function AdmissionApplicantVerify($currentRoute, $applicationType , $applicantId, Request $request)
    {
        if($applicationType == 'SHS') {
            $documents = DocumentSHS::where('applicant_id', $applicantId)->first();
        }

        $personalInformation = ApplicantList::where('applicant_id', $applicantId)->first();
        $fatherInformation = ApplicantFatherInformation::where('applicant_id', $applicantId)->first();
        $motherInformation = ApplicantMotherInformation::where('applicant_id', $applicantId)->first();
        $schoolInformation = ApplicantSchoolInformation::where('applicant_id', $applicantId)->first();
        $programInformation = ApplicantProgramInformation::where('applicant_id', $applicantId)->first();
        $exist = ApplicantGuardianInformation::find($applicantId);

        if($exist) {
            $guardianInformation = ApplicantGuardianInformation::where('applicant_id', $applicantId)->first();
        } else {
            $guardianInformation = null;
        }

        $selectionInfo = ApplicantProgramInformation::where('applicant_id', $applicantId)->first();

        $course1 = CourseModel::where('course_code', $selectionInfo->choice1)->first();
        $course2 = CourseModel::where('course_code', $selectionInfo->choice2)->first();
        $course3 = CourseModel::where('course_code', $selectionInfo->choice3)->first();

        $selectionInfo->choice1 = $course1->course;
        $selectionInfo->choice2 = $course2->course;
        $selectionInfo->choice3 = $course3->course;

        $otherInformation = ApplicantOtherInformation::where('applicant_id', $applicantId)->first();

        $otherInformation->birthDate = Carbon::parse($otherInformation->birthDate)->format('F j, Y');

        $region = Regions::where('region_code', $otherInformation->region)->first();
        $province = Provinces::where('province_code', $otherInformation->province)->first();
        $city = Cities::where('city_code', $otherInformation->city)->first();
        $barangay = Barangays::where('brgy_code', $otherInformation->barangay)->first();

        $otherInformation->region = $region->region_name;
        $otherInformation->province = $province->province_name;
        $otherInformation->city = $city->city_name;
        $otherInformation->barangay = $barangay->brgy_name;

        if($applicationType == "SHS"){
            $applicationType = "Senior High School";
        } else if($applicationType == "ALS"){
            $applicationType = "Alternative Learning System";
        } else if($applicationType == "OLD"){
            $applicationType = "Old Curriculum";
        } else if($applicationType == "TRANSFER"){
            $applicationType = "Transfer Student";
        }

        return view('pages.admin.verify', compact('applicantId','documents', 'applicationType', 'currentRoute', 'personalInformation', 'otherInformation', 'fatherInformation', 'motherInformation', 'schoolInformation', 'selectionInfo', 'guardianInformation'));
    }

    public function AdmissionVerify($currentRoute, $applicationType , $applicantId, Request $request)
    {
        $validated = $request->validate([
            'birthCert' => 'required',
            'birthCertComment' => 'nullable',
            'others' => 'required',
            'othersComment' => 'nullable',
        ]);

        DocumentSHS::where('applicant_id', $applicantId)->first()->update([
            'birthCertStatus' => $validated['birthCert'],
            'birthCertComment' => $validated['birthCertComment'],
            'othersStatus' => $validated['others'],
            'othersComment' => $validated['othersComment'],
        ]);

        $overallStatus = ApplicantList::where('applicant_id', $applicantId)->first();

        if($validated['birthCert'] == 'approved' && $validated['others'] == 'approved') {
            $overallStatus->update([
                'status' => 'approved',
            ]);
        } else {
            $overallStatus->update([
                'status' => 'resubmission',
            ]);
        }

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute]);
        // return dd($validated, $currentRoute, $applicationType , $applicantId);
    }

    public function AdmissionChangeDate($currentRoute, Request $request)
    {
        $validated = $request->validate([
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        StartEnd::where('status', 'start')->first()->update([
            'date' => $validated['startDate'],
        ]);

        StartEnd::where('status', 'end')->first()->update([
            'date' => $validated['endDate'],
        ]);

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute])->with('changed', 'Dates has been changed successfully.');
    }

    public function AdmissionDeleteAnnouncement($currentRoute, $announcementId)
    {
        Announcement::where('id', $announcementId)->delete();

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute])->with('deleted', 'Announcement has been deleted successfully.');
    }

    public function AdmissionEditAnnouncement($currentRoute, $announcementId)
    {
        $announcement = Announcement::where('id', $announcementId)->first();

        return view('pages.admin.sections.edit_announcement', compact('currentRoute', 'announcement'));
    }
}

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
use App\Models\DocumentALS;
use App\Models\DocumentOLD;
use App\Models\DocumentTRANSFER;
use App\Models\ApplicationForm;
use App\Models\CourseModel;
use App\Models\Regions;
use App\Models\Provinces;
use App\Models\Cities;
use App\Models\Barangays;
use App\Models\StartEnd;
use App\Models\Announcement;
use App\Models\ApplicantSelectionInformation;
use App\Models\ExamSchedule;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportData;
use App\Exports\ApplicantListReport;
use App\Exports\ApplicationFormReport;
use App\Exports\ResultReport;

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

        $applicants = $query->paginate(7);

        $statusAppForm = $request->query('statusType', 'all');
        $searchAppForm = $request->query('search', '');
        $appFormQuery = ApplicantList::join('applicant_application_form', 'applicant_application_form.applicant_id', '=', 'applicant_personal_information.applicant_id')->where('activity', 'active');
        
        if ($statusAppForm !== 'all') {
            $appFormQuery =  $appFormQuery->where('applicationFormStatus', $statusAppForm);
        }

        if(!empty($searchAppForm)) {
            $appFormQuery = $appFormQuery->where(function ($query) use ($searchAppForm) {
                $query->where('firstName', 'like', "%{$searchAppForm}%")
                      ->orWhere('lastName', 'like', "%{$searchAppForm}%")
                      ->orWhere('email', 'like', "%{$searchAppForm}%");
            });
        }

        $appFormList = $appFormQuery->paginate(7);

        $resultType = $request->query('type', 'no');
        $searchResultApplicant = $request->query('searchResultApplicant', '');
        $resultApplicantQuery = ApplicantList::join('exam_schedules', 'exam_schedules.applicant_id', '=', 'applicant_personal_information.applicant_id')->where('hasResult', $resultType);

        $resultList = $resultApplicantQuery->paginate(7);

        foreach($resultList as $result){
            if ($result->courseOffer != null){
                if($result->courseOffer == 'first'){
                    $result->courseOffer = ApplicantSelectionInformation::where('applicant_id', $result->applicant_id)->first()->choice1;
                } else if ($result->courseOffer == 'second'){
                    $result->courseOffer = ApplicantSelectionInformation::where('applicant_id', $result->applicant_id)->first()->choice2;
                } else if ($result->courseOffer == 'third'){
                    $result->courseOffer = ApplicantSelectionInformation::where('applicant_id', $result->applicant_id)->first()->choice3;
                }
        
                $result->courseOffer = CourseModel::where('course_code', $result->courseOffer)->first()->course;
            }
        }

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

        $startDate = StartEnd::where('status', 'start')->first();
        $endDate = StartEnd::where('status', 'end')->first();

        $startDBDate = $startDate->date;
        $endDBDate = $endDate->date;

        $startDate->date = Carbon::parse($startDate->date)->format('F j, Y');
        $endDate->date = Carbon::parse($endDate->date)->format('F j, Y');

        $announcements = Announcement::paginate(5);

        $announcements->each(function ($annoucement) {
            $annoucement->date = Carbon::parse($annoucement->date)->format('F j, Y');
        });

        $withExam = ApplicationForm::where('exam', 'with')->where('applicationFormStatus', 'approved')->count();
        $withoutExam = ApplicationForm::where('exam', 'without')->where('applicationFormStatus', 'approved')->count();

        $routeSegment = request()->segment(1);

        $publicCount = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('schoolType', 'public')->where('activity', 'active')->count();
        $privateCount = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('schoolType', 'private')->where('activity', 'active')->count();

        return view('pages.admin.admission', compact('routeSegment', 'currentRoute', 'totalApplicants', 'maleApplicants', 'femaleApplicants', 'count', 'status', 'regions', 'manilaRatio', 'inactive', 'strands', 'applicants', 'type', 'statusType', 'searchApplicant', 'startDate', 'endDate', 'announcements', 'startDBDate', 'endDBDate', 'appFormList', 'withExam', 'withoutExam', 'resultType', 'searchResultApplicant', 'resultList', 'publicCount', 'privateCount'));
    }

    public function AdmissionApplicantVerify($currentRoute, $applicationType , $applicantId, Request $request)
    {
        if($applicationType == 'SHS') {
            $documents = DocumentSHS::where('applicant_id', $applicantId)->first();
        }
        else if ($applicationType == 'ALS') {
            $documents = DocumentALS::where('applicant_id', $applicantId)->first();
        }
        else if ($applicationType == 'OLD') {
            $documents = DocumentOLD::where('applicant_id', $applicantId)->first();
        }
        else if ($applicationType == 'TRANSFER') {
            $documents = DocumentTRANSFER::where('applicant_id', $applicantId)->first();
        }

        $abvAppType = $applicationType;

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

        $schoolInformation->schoolRegion = Regions::where('region_code', $schoolInformation->schoolRegion)->first()->region_name;
        $schoolInformation->schoolProvince = Provinces::where('province_code', $schoolInformation->schoolProvince)->first()->province_name;
        $schoolInformation->schoolCity = Cities::where('city_code', $schoolInformation->schoolCity)->first()->city_name;
        
        if($schoolInformation->strand == "ABM"){
            $schoolInformation->strand = "Accountancy, Business, and Management";
        } else if($schoolInformation->strand == "HUMSS"){
            $schoolInformation->strand = "Humanities and Social Sciences";
        } else if($schoolInformation->strand == "STEM"){
            $schoolInformation->strand = "Science, Technology, Engineering, and Mathematics";
        } else if($schoolInformation->strand == "GAS"){
            $schoolInformation->strand = "General Academic Strand";
        } else if($schoolInformation->strand == "TVL"){
            $schoolInformation->strand = "Technical-Vocational-Livelihood";
        } else if($schoolInformation->strand == "SPORTS"){
            $schoolInformation->strand = "Sports Track";
        } else if($schoolInformation->strand == "ADT"){
            $schoolInformation->strand = "Arts and Design Track";
        } else if($schoolInformation->strand == "PBM"){
            $schoolInformation->strand = "Personal Development Track";
        }

        return view('pages.admin.verify', compact('applicantId','documents', 'applicationType', 'currentRoute', 'personalInformation', 'otherInformation', 'fatherInformation', 'motherInformation', 'schoolInformation', 'selectionInfo', 'guardianInformation', 'abvAppType'));
    }

    public function AdmissionApplicationFormVerify($currentRoute, $applicationType , $applicantId, Request $request)
    {
        $applicationForm = ApplicationForm::where('applicant_id', $applicantId)->first();

        $abvAppType = $applicationType;

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

        $schoolInformation->schoolRegion = Regions::where('region_code', $schoolInformation->schoolRegion)->first()->region_name;
        $schoolInformation->schoolProvince = Provinces::where('province_code', $schoolInformation->schoolProvince)->first()->province_name;
        $schoolInformation->schoolCity = Cities::where('city_code', $schoolInformation->schoolCity)->first()->city_name;
        
        if($schoolInformation->strand == "ABM"){
            $schoolInformation->strand = "Accountancy, Business, and Management";
        } else if($schoolInformation->strand == "HUMSS"){
            $schoolInformation->strand = "Humanities and Social Sciences";
        } else if($schoolInformation->strand == "STEM"){
            $schoolInformation->strand = "Science, Technology, Engineering, and Mathematics";
        } else if($schoolInformation->strand == "GAS"){
            $schoolInformation->strand = "General Academic Strand";
        } else if($schoolInformation->strand == "TVL"){
            $schoolInformation->strand = "Technical-Vocational-Livelihood";
        } else if($schoolInformation->strand == "SPORTS"){
            $schoolInformation->strand = "Sports Track";
        } else if($schoolInformation->strand == "ADT"){
            $schoolInformation->strand = "Arts and Design Track";
        } else if($schoolInformation->strand == "PBM"){
            $schoolInformation->strand = "Personal Development Track";
        }

        return view('pages.admin.application_form_verify', compact('applicantId','applicationForm', 'applicationType', 'currentRoute', 'personalInformation', 'otherInformation', 'fatherInformation', 'motherInformation', 'schoolInformation', 'selectionInfo', 'guardianInformation', 'abvAppType'));
    }

    public function AdmissionVerify($currentRoute, $applicationType, $applicantId, Request $request)
    {
        $validated = $request->validate([
            'birthCert' => 'required',
            'birthCertComment' => 'nullable',
            'others' => 'nullable',
            'othersComment' => 'nullable',
            'approval' => 'nullable',
            'approvalComment' => 'nullable',
            'highSchool' => 'nullable',
            'highSchoolComment' => 'nullable',
        ]);


        if($applicationType == 'SHS'){
            DocumentSHS::where('applicant_id', $applicantId)->first()->update([
                'birthCertStatus' => $validated['birthCert'],
                'birthCertComment' => $validated['birthCertComment'],
                'othersStatus' => $validated['others'],
                'othersComment' => $validated['othersComment'],
            ]);
        }
        else if($applicationType == 'ALS'){
            DocumentALS::where('applicant_id', $applicantId)->first()->update([
                'birthCertStatus' => $validated['birthCert'],
                'birthCertComment' => $validated['birthCertComment'],
                'othersStatus' => $validated['others'],
                'othersComment' => $validated['othersComment'],
            ]);
        }
        else if($applicationType == 'OLD'){
            DocumentOLD::where('applicant_id', $applicantId)->first()->update([
                'birthCertStatus' => $validated['birthCert'],
                'birthCertComment' => $validated['birthCertComment'],
                'approvalLetterStatus' => $validated['approval'],
                'approvalLetterComment' => $validated['approvalComment'],
                'highSchoolStatus' => $validated['highSchool'],
                'highSchoolComment' => $validated['highSchoolComment'],
            ]);
        }
        else if($applicationType == 'TRANSFER'){
            DocumentTRANSFER::where('applicant_id', $applicantId)->first()->update([
                'birthCertStatus' => $validated['birthCert'],
                'birthCertComment' => $validated['birthCertComment'],
                'othersStatus' => $validated['others'],
                'othersComment' => $validated['othersComment'],
            ]);
        }

        $overallStatus = ApplicantList::where('applicant_id', $applicantId)->first();

        if($applicationType != 'OLD'){
            if($validated['birthCert'] == 'approved' && $validated['others'] == 'approved') {
                $overallStatus->update([
                    'status' => 'approved',
                ]);
            } else {
                $overallStatus->update([
                    'status' => 'resubmission',
                ]);
            }
        }
        else {
            if($validated['birthCert'] == 'approved' && $validated['approval'] == 'approved' && $validated['highSchool'] == 'approved') {
                $overallStatus->update([
                    'status' => 'approved',
                ]);
            } else {
                $overallStatus->update([
                    'status' => 'resubmission',
                ]);
            }
        }
        

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute]);
        // return dd($validated, $currentRoute, $applicationType , $applicantId);
    }

    public function AdmissionApplicationFormConfirm($currentRoute, $applicationType, $applicantId, Request $request)
    {
        $validated = $request->validate([
            'application' => 'required',
            'comment' => 'nullable',
        ]);


        ApplicationForm::where('applicant_id', $applicantId)->first()->update([
            'applicationFormStatus' => $validated['application'],
            'applicationFormComment' => $validated['comment'],
        ]);
        

        return redirect()->route('admin.page', ['currentRoute' => 'application-form']);
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

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute])->with('deleted', 'Advisory has been deleted successfully.');
    }

    public function AdmissionEditAnnouncement($currentRoute, $announcementId)
    {
        $announcement = Announcement::where('id', $announcementId)->first();

        $date = $announcement->date;

        $announcement->date = Carbon::parse($announcement->date)->format('F j, Y');

        return view('pages.admin.sections.edit_announcement', compact('currentRoute', 'announcement', 'date'));
    }

    public function AdmissionUpdateAnnouncement($currentRoute, $announcementId, Request $request)
    {
        $validated = $request->validate([
            'date' => 'nullable',
            'announcement' => 'nullable'
        ]);

        $announcement = Announcement::where('id', $announcementId)->first();

        if($validated['date'] != null) {
            $announcement->update([
                'date' => $validated['date'],
            ]);
        }

        if($validated['announcement'] != null) {
            $announcement->update([
                'announcement' => $validated['announcement'],
            ]);
        }

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute])->with('changed', 'Advisory has been changed successfully.');
    }

    public function AdmissionAddAnnouncement($currentRoute, Request $request)
    {
        $validated = $request->validate([
            'advisory' => 'required|max:200',
        ]);

        Announcement::create([
            'date' => Carbon::now(),
            'announcement' => $validated['advisory'],
        ]);

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute])->with('add', 'Advisory has been changed successfully.');
    }

    public function AllocateApplicantExamSchedule(Request $request)
    {
        $validated = $request->validate([
            'buildingExam' => 'required',
            'roomExam' => 'required',
            'dateExam' => 'required',
            'timeExam' => 'required',
            'capacity' => 'required',
        ]);

        $applicants = ApplicationForm::where('exam', 'without')->where('applicationFormStatus', 'approved')->limit($validated['capacity'])->get();

        foreach($applicants as $applicant) {
            ExamSchedule::create([
                'applicant_id' => $applicant->applicant_id,
                'building' => $validated['buildingExam'],
                'room' => $validated['roomExam'],
                'date' => $validated['dateExam'],
                'time' => $validated['timeExam'],
            ]);

            ApplicationForm::where('applicant_id', $applicant->applicant_id)->first()->update([
                'exam' => 'with',
            ]);
        }

        return redirect()->route('admin.page', ['currentRoute' => 'exam'])->with('addExam', 'Applicant exam schedule has been added successfully.');
    }

    public function GetViewResult($currentRoute, $applicationType, $applicantId, Request $request) 
    {
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

        $schoolInformation->schoolRegion = Regions::where('region_code', $schoolInformation->schoolRegion)->first()->region_name;
        $schoolInformation->schoolProvince = Provinces::where('province_code', $schoolInformation->schoolProvince)->first()->province_name;
        $schoolInformation->schoolCity = Cities::where('city_code', $schoolInformation->schoolCity)->first()->city_name;
        
        if($schoolInformation->strand == "ABM"){
            $schoolInformation->strand = "Accountancy, Business, and Management";
        } else if($schoolInformation->strand == "HUMSS"){
            $schoolInformation->strand = "Humanities and Social Sciences";
        } else if($schoolInformation->strand == "STEM"){
            $schoolInformation->strand = "Science, Technology, Engineering, and Mathematics";
        } else if($schoolInformation->strand == "GAS"){
            $schoolInformation->strand = "General Academic Strand";
        } else if($schoolInformation->strand == "TVL"){
            $schoolInformation->strand = "Technical-Vocational-Livelihood";
        } else if($schoolInformation->strand == "SPORTS"){
            $schoolInformation->strand = "Sports Track";
        } else if($schoolInformation->strand == "ADT"){
            $schoolInformation->strand = "Arts and Design Track";
        } else if($schoolInformation->strand == "PBM"){
            $schoolInformation->strand = "Personal Development Track";
        }

        return view('pages.admin.sections.set_results', compact('currentRoute', 'personalInformation', 'otherInformation', 'fatherInformation', 'motherInformation', 'schoolInformation', 'selectionInfo', 'guardianInformation', 'applicationType', 'applicantId'));
    }

    public function SetResult($currentRoute, $applicationType, $applicantId, Request $request) 
    {
        $validated = $request->validate([
            'remarks' => 'required',
            'rank' => 'required',
            'score' => 'required',
            'course' => 'nullable',
        ]);

        ExamSchedule::where('applicant_id', $applicantId)->first()->update([
            'hasResult' => 'yes',
            'remark' => $validated['remarks'],
            'rank' => $validated['rank'],
            'score' => $validated['score'],
        ]);

        if($validated['remarks'] == "with") {
            ExamSchedule::where('applicant_id', $applicantId)->first()->update([
                'courseOffer' => $validated['course'],
            ]);
        }

        return redirect()->route('admin.page', ['currentRoute' => $currentRoute])->with('setResult', 'Applicant result has been set successfully.');
    }

    public function ExportReport(Request $request)
    {
        $validate = $request->validate([
            'select' => 'required',
        ]);

        if($validate['select'] == 'first') {
            return Excel::download(new ReportData($validate['select']), 'first_report.xlsx');
        } else if ($validate['select'] == 'second') {
            return Excel::download(new ReportData($validate['select']), 'second_report.xlsx');
        }   else if ($validate['select'] == 'third') {
            return Excel::download(new ReportData($validate['select']), 'third_report.xlsx');
        }
    }

    public function ExportApplicants()
    {
        return Excel::download(new ApplicantListReport, 'applicant-list.xlsx');
    }

    public function ExportApplicantForms()
    {
        return Excel::download(new ApplicationFormReport, 'applicant-form-list.xlsx');
    }

    public function ExportResult()
    {
        return Excel::download(new ResultReport, 'result-list.xlsx');
    }
}

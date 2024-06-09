<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use App\Models\ApplicantList;
use App\Models\ApplicantOtherInformation;
use App\Models\ApplicantSchoolInformation;

class ReportData implements FromView, ShouldAutoSize
{
    use Exportable;

    private $select;
    private $approved;
    private $pending;
    private $resubmission;
    private $shsApplicants;
    private $alsApplicants;
    private $oldApplicants;
    private $transferApplicants;
    private $male;
    private $female;
    private $regions;
    private $manilaRatio;
    private $strands;
    private $publicCount;
    private $privateCount;

    public function __construct($validated)
    {
        $this->select = $validated;

        $this->approved = ApplicantList::where('status', 'approved')->where('activity', 'active')->count();
        $this->pending = ApplicantList::where('status', 'pending')->where('activity', 'active')->count();
        $this->resubmission = ApplicantList::where('status', 'resubmission')->where('activity', 'active')->count();

        $this->shsApplicants = ApplicantList::where('applicationType', 'SHS')->where('activity', 'active')->count();
        $this->alsApplicants = ApplicantList::where('applicationType', 'ALS')->where('activity', 'active')->count();
        $this->oldApplicants = ApplicantList::where('applicationType', 'OLD')->where('activity', 'active')->count();
        $this->transferApplicants = ApplicantList::where('applicationType', 'TRANSFER')->where('activity', 'active')->count();

        $this->male = ApplicantList::where('gender', 'male')->where('activity', 'active')->count();
        $this->female = ApplicantList::where('gender', 'female')->where('activity', 'active')->count();

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

        $this->regions = [
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

        $this->manilaRatio = [
            'manila' => $manila,
            'nonManila' => $nonManila,
        ];

        $abm = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'ABM')->where('activity', 'active')->count();
        $humss = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'HUMSS')->where('activity', 'active')->count();
        $stem = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'STEM')->where('activity', 'active')->count();
        $gas = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'GAS')->where('activity', 'active')->count();
        $tvl = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'TVL')->where('activity', 'active')->count();
        $sports = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'SPORTS')->where('activity', 'active')->count();
        $adt = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'ADT')->where('activity', 'active')->count();
        $pbm = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('strand', 'PBM')->where('activity', 'active')->count();

        $this->publicCount = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('schoolType', 'public')->where('activity', 'active')->count();
        $this->privateCount = ApplicantSchoolInformation::join('applicant_personal_information', 'applicant_personal_information.applicant_id', '=', 'applicant_school_information.applicant_id')->where('schoolType', 'private')->where('activity', 'active')->count();

        $this->strands = [
            'ABM' => $abm,
            'HUMSS' => $humss,
            'STEM' => $stem,
            'GAS' => $gas,
            'TVL' => $tvl,
            'SPORTS' => $sports,
            'ADT' => $adt,
            'PBM' => $pbm,
        ];
    }

    public function view() : View
    {
        return view('documents.report',[
            'select' => $this->select,
            'approved' => $this->approved,
            'pending' => $this->pending,
            'resubmission' => $this->resubmission,
            'shsApplicants' => $this->shsApplicants,
            'alsApplicants' => $this->alsApplicants,
            'oldApplicants' => $this->oldApplicants,
            'transferApplicants' => $this->transferApplicants,
            'male' => $this->male,
            'female' => $this->female,
            'regions' => $this->regions,
            'manilaRatio' => $this->manilaRatio,
            'strands' => $this->strands,
            'publicCount' => $this->publicCount,
            'privateCount' => $this->privateCount,
        ]);
    }
}

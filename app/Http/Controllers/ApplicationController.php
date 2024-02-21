<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ApplicantFatherInformation;
use App\Models\ApplicantOtherInformation;
use App\Models\ApplicantPersonalInformation;
use App\Models\ApplicantMotherInformation;
use App\Models\ApplicantSchoolInformation;
use App\Models\ApplicantSelectionInformation;
use App\Models\ApplicantGuardianInformation;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Helper\Helper;

class ApplicationController extends Controller
{
    public function create(): View
    {
        return view('pages.application');
    }

    public function store(Request $request): RedirectResponse
    {
        $year = date('Y');

        $student_id = Helper::IDGenerator(new ApplicantPersonalInformation, 'applicant_id', 5, $year);
        $user = new ApplicantPersonalInformation();

        $user->applicant_id = $student_id;

        $user->lastName = $request->lastName;
        $user->firstName = $request->firstName;
        $user->middleName = $request->middleName;
        $user->suffix = $request->suffix;
        $user->email = $request->email;
        $user->contactNum = $request->contactNum;
        $user->applicationType = $request->applicationType;
        $user->gender = $request->gender;

        $other = new ApplicantOtherInformation();

        $other->applicant_id = $student_id;
        $other->maidenName = $request->maidenName;
        $other->birthDate = $request->birthDate;
        $other->birthPlace = $request->birthPlace;
        $other->address = $request->address;
        $other->region = $request->region;
        $other->city = $request->city;
        $other->barangay = $request->barangay;
        $other->zip = $request->zip;

        $father = new ApplicantFatherInformation();

        $father->applicant_id = $student_id;
        $father->fatherLast = $request->fatherLast;
        $father->fatherFirst = $request->fatherFirst;
        $father->fatherMiddle = $request->fatherMiddle;
        $father->fatherSuffix = $request->fatherSuffix;
        $father->fatherAddress = $request->fatherAddress;
        $father->fatherContact = $request->fatherContact;
        $father->fatherJob = $request->fatherJob;
        $father->fatherIncome = $request->fatherIncome;

        $mother = new ApplicantMotherInformation();

        $mother->applicant_id = $student_id;
        $mother->motherLast = $request->motherLast;
        $mother->motherFirst = $request->motherFirst;
        $mother->motherMiddle = $request->motherMiddle;
        $mother->motherSuffix = $request->motherSuffix;
        $mother->motherAddress = $request->motherAddress;
        $mother->motherContact = $request->motherContact;
        $mother->motherJob = $request->motherJob;
        $mother->motherIncome = $request->motherIncome;

        $guardian = new ApplicantGuardianInformation();

        $guardian->applicant_id = $student_id;
        $guardian->guardianLast = $request->guardianLast;
        $guardian->guardianFirst = $request->guardianFirst;
        $guardian->guardianMiddle = $request->guardianMiddle;
        $guardian->guardianSuffix = $request->guardianSuffix;
        $guardian->guardianAddress = $request->guardianAddress;
        $guardian->guardianContact = $request->guardianContact;
        $guardian->guardianJob = $request->guardianJob;
        $guardian->guardianIncome = $request->guardianIncome;

        $school = new ApplicantSchoolInformation();

        $school->applicant_id = $student_id;
        $school->lrn = $request->lrn;
        $school->school = $request->school;
        $school->schoolEmail = $request->schoolEmail;
        $school->schoolType = $request->schoolType;
        $school->strand = $request->strand;
        $school->gwa = $request->gwa;

        $selection = new ApplicantSelectionInformation();

        $selection->applicant_id = $student_id;
        $selection->choice1 = $request->choice1;
        $selection->choice2 = $request->choice2;
        $selection->choice3 = $request->choice3;

        $user->save();
        $other->save();
        $father->save();
        $mother->save();
        $guardian->save();
        $school->save();
        $selection->save();

        return redirect(RouteServiceProvider::HOME);
    }
}

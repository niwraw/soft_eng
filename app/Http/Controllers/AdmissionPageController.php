<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantList;

class AdmissionPageController extends Controller
{
    public function AdmissionDashboard($currentRoute)
    {
        $shsApplicants = ApplicantList::where('applicationType', 'SHS')->get();
        $alsApplicants = ApplicantList::where('applicationType', 'ALS')->get();
        $oldApplicants = ApplicantList::where('applicationType', 'OLD')->get();
        $transferApplicants = ApplicantList::where('applicationType', 'TRANSFER')->get();

        $totalApplicants = $shsApplicants->count() + $alsApplicants->count() + $oldApplicants->count() + $transferApplicants->count();

        $shsUsersWithGender = $shsApplicants->map(function ($user) {
            $user['gender'] = $user->gender;
            return $user;
        });

        $alsUsersWithGender = $alsApplicants->map(function ($user) {
            $user['gender'] = $user->gender;
            return $user;
        });

        $transfereeUsersWithGender = $transferApplicants->map(function ($user) {
            $user['gender'] = $user->gender;
            return $user;
        });

        $oldUsersWithGender = $oldApplicants->map(function ($user) {
            $user['gender'] = $user->gender;
            return $user;
        });

        $shsMaleCount = $shsUsersWithGender->where('gender', 'male')->count();
        $shsFemaleCount = $shsUsersWithGender->where('gender', 'female')->count();

        $alsMaleCount = $alsUsersWithGender->where('gender', 'male')->count();
        $alsFemaleCount = $alsUsersWithGender->where('gender', 'female')->count();

        $transfereeMaleCount = $transfereeUsersWithGender->where('gender', 'male')->count();
        $transfereeFemaleCount = $transfereeUsersWithGender->where('gender', 'female')->count();

        $oldMaleCount = $oldUsersWithGender->where('gender', 'male')->count();
        $oldFemaleCount = $oldUsersWithGender->where('gender', 'female')->count();

        $maleApplicants = $shsMaleCount + $alsMaleCount + $transfereeMaleCount + $oldMaleCount;
        $femaleApplicants = $shsFemaleCount + $alsFemaleCount + $transfereeFemaleCount + $oldFemaleCount;

        $count= [
            'SHS' => count($shsApplicants),
            'ALS' => count($alsApplicants),
            'OLD' => count($oldApplicants),
            'TRANSFER' => count($transferApplicants),
        ];


        $routeSegment = request()->segment(1);
        return view('pages.admin.admission', compact('routeSegment', 'currentRoute', 'totalApplicants', 'maleApplicants', 'femaleApplicants', 'count'));
    }
}

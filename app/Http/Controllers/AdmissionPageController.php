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

        $routeSegment = request()->segment(1);
        return view('pages.admin.admission', compact('routeSegment', 'currentRoute', 'totalApplicants', 'maleApplicants', 'femaleApplicants', 'count', 'status'));
    }
}

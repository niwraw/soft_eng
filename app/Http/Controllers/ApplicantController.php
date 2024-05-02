<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantController extends Controller
{
    public function ApplicantPage($currentRoute, Request $request)
    {
        $routeSegment = request()->segment(1);
        return view('pages.applicant.applicant', compact('currentRoute', 'routeSegment'));
    }
}

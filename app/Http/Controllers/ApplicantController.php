<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantController extends Controller
{
    public function create(): View
    {
        return view('pages.applicant.dashboard');
    }
}

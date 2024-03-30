<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function create(): View
    {
        return view('pages.admin.dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    public function index($currentRoute)
    {
        return view('welcome', compact('currentRoute'));
    }
}

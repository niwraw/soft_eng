<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;

class ApplicationController extends Controller
{
    public function create(): View
    {
        return view('pages.application');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = new User();

        $user->lastName = $request->lastName;
        $user->firstName = $request->firstName;
        $user->middleName = $request->middleName;
        $user->suffix = $request->suffix;
        $user->email = $request->email;
        $user->contactNum = $request->contactNum;
        $user->applicationType = $request->applicationType;
        $user->gender = $request->gender;

        $user->save();

        return redirect(RouteServiceProvider::HOME);
    }
}

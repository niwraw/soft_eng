<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $emailDomain = substr(strrchr($request->email, "@"), 1);

        if ($emailDomain == 'plm.edu.ph') {
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->intended('/admin/dashboard');
            }
        } else {
            if (Auth::attempt($credentials)) {
                $applicantId = Auth::user()->applicant_id;
                return redirect()->intended('/applicant/dashboard/'. $applicantId);
            }
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/home');
    }
}

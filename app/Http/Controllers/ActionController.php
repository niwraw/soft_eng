<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantList;

class ActionController extends Controller
{
    public function restore()
    {
        $applicants = ApplicantList::where('activity', 'inactive')->get();
        foreach ($applicants as $applicant) {
            $applicant->update(['activity' => 'active']);
        }
        return redirect()->back()->with('success', 'Applicants restored successfully.');
    }

    public function archive()
    {
        $applicants = ApplicantList::where('status', 'resubmission')->get();
        foreach ($applicants as $applicant) {
            $applicant->update(['activity' => 'inactive']);
        }
        return redirect()->back()->with('success', 'Applicants archived successfully.');
    }

    public function delete()
    {
        $applicants = ApplicantList::where('activity', 'inactive')->get();
        foreach ($applicants as $applicant) {
            $applicant->delete();
        }
        return redirect()->back()->with('success', 'Applicants deleted successfully.');
    }
}

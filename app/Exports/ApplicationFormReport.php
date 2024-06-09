<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use App\Models\ApplicantList;

class ApplicationFormReport implements FromView, ShouldAutoSize
{
    use Exportable;
    
    private $applicants;

    public function __construct()
    {
        $this->applicants = ApplicantList::join('applicant_application_form', 'applicant_application_form.applicant_id', '=', 'applicant_personal_information.applicant_id')->where('activity', 'active');
    }

    public function view(): View
    {
        return view('documents.applicant-form-list', [
            'applicants' => $this->applicants->get()
        ]);
    }
}

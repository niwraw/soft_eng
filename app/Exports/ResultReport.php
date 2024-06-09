<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use App\Models\ApplicantList;

class ResultReport implements FromView, ShouldAutoSize
{
    use Exportable;
    
    private $applicants;

    public function __construct()
    {
        $this->applicants = ApplicantList::join('exam_schedules', 'exam_schedules.applicant_id', '=', 'applicant_personal_information.applicant_id')->where('hasResult', 'yes');
    }

    public function view(): View
    {
        return view('documents.result', [
            'applicants' => $this->applicants->get()
        ]);
    }
}

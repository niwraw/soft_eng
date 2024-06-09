<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use App\Models\ApplicantList;

class ApplicantListReport implements FromView, ShouldAutoSize
{
    use Exportable;
    
    private $applicants;

    public function __construct()
    {
        $this->applicants = ApplicantList::where('activity', 'active');
    }

    public function view(): View
    {
        return view('documents.applicant-list', [
            'applicants' => $this->applicants->get()
        ]);
    }
}

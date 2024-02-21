<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantOtherInformation extends Model
{
    use HasFactory;

    protected $table = 'applicant_other_information';
    protected $guarded = [];
}

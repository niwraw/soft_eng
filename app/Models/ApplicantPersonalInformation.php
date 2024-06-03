<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantPersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'applicant_personal_information';
    protected $guarded = [];
}

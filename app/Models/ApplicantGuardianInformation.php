<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantGuardianInformation extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicant_id';
    protected $keyType = 'string';
    protected $table = 'applicant_guardian_information';
    protected $guarded = [];
}

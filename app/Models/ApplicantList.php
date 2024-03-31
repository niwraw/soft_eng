<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantList extends Model
{
    use HasFactory;

    protected $table = 'applicant_personal_information';
    protected $guarded = [];
}

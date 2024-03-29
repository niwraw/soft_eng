<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantLoginCreds extends Model
{
    use HasFactory;

    protected $table = 'applicant_accounts';
    protected $guarded = [];
}

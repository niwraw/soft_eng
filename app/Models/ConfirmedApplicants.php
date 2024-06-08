<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmedApplicants extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicant_id';
    protected $keyType = 'string';
    protected $table = 'confirmed_applicant';
    protected $guarded = [];
}

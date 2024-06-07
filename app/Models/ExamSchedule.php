<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicant_id';
    protected $keyType = 'string';
    protected $table = 'exam_schedules';
    protected $guarded = [];
}

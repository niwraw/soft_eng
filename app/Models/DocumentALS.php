<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentALS extends Model
{
    use HasFactory;

    protected $table = 'applicant_document_ALS';
    protected $guarded = [];
}
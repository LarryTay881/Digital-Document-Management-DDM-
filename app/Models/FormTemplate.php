<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_name',
        'upload_by', 
        'date_time', 
        'form_data', 
    ];
}

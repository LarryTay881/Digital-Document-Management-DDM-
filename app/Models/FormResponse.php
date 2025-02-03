<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'upload_by', 
        'date_time', 
        'form_response',
        'template_id',
    ];
}

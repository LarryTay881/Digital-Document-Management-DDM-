<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_value',
        'language_name',
        'language_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'description',
        'meta_keywords',
        'meta_description',
        'google_map',
    ];
}

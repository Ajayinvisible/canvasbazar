<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'status'
    ];
}

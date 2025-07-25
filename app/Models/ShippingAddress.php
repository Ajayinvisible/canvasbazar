<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'country',
        'province',
        'city',
        'address',
        'is_default',
    ];
}

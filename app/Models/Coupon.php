<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'start_date',
        'end_date',
        'status',
        'one_time',
    ];

    public function usersUsed()
    {
        return $this->belongsToMany(User::class)->withPivot('used_at')->withTimestamps();
    }
}

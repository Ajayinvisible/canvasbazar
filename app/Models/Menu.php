<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
        'menu_position',
    ];

    public function pages(): HasOne
    {
        return $this->hasOne(Page::class);
    }
}

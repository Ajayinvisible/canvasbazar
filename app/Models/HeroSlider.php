<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    protected $fillable = [
        'title_blue',
        'title_black',
        'text',
        'image',
        'button_text',
        'button_link',
        'order_by',
        'status',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallary extends Model
{
    protected $fillable = [
        'product_id',
        'images',
    ];


    protected $casts = [
        'images' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_intro',
        'description',
        'thumbnail',
        'meta_keywords',
        'meta_description',
        'status',
        'is_featured',
        'is_tranding',
        'is_custom',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function gallery(): HasOne
    {
        return $this->hasOne(ProductGallary::class);
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class, 'product_variant');
    }
}

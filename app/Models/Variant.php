<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variant extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'is_custom',
    ];

    public function sizes(): HasMany
    {
        return $this->hasMany(VariantSize::class);
    }

    public function canvas(): HasMany
    {
        return $this->hasMany(Canvas::class);
    }
}

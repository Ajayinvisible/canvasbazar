<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantSize extends Model
{
    protected $fillable = [
        'variant_id',
        'size_label',
        'price',
        'stock',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}

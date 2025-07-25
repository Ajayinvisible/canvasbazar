<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function branding():HasOne
    {
        return $this->hasOne(CompanyBranding::class);
    }

    public function contact(): HasMany
    {
        return $this->hasMany(CompanyBranding::class);
    }

    public function social(): HasMany
    {
        return $this->hasMany(SocialMedia::class);
    }
}

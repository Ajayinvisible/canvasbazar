<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyBranding extends Model
{
    protected $fillable = [
        'company_id',
        'logo',
        'favicon',
        'copyright'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

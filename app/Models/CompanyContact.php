<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyContact extends Model
{
    protected $fillable = [
        'company_id',
        'icon',
        'number',
        'status',
        'type'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;

class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'image',
        'status',
        'password',
    ];

    /**
     * Allow this Admin model to access Filament panel.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true; // ✅ Or add logic like: return $this->status === 'active';
    }
}

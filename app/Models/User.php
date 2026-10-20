<?php

namespace App\Models;

use App\Traits\HasUlid;
use App\Traits\HasDatatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasUlid, HasDatatable;

    protected $fillable = ['name', 'email', 'password', 'role_id', 'profile', 'status'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return (int) $this->status === 1;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper to get permissions
    public function permissions()
    {
        return $this->role && $this->role->permissions
            ? (is_array($this->role->permissions) ? $this->role->permissions : json_decode($this->role->permissions, true))
            : [];
    }
}

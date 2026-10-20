<?php

namespace App\Models;

use App\Traits\HasUlid;
use App\Traits\HasDatatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUlid, HasDatatable;

    protected $fillable = ['name', 'is_superadmin', 'permissions'];

    protected $casts = [
        'permissions' => 'array', // Automatically decode JSON to array
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

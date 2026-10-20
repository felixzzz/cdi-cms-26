<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($perPage = 10)
    {
        $search = request('search');
        return User::query()
        ->join("roles", "roles.id", "users.role_id")
        ->where(function ($q) use ($search) {
            $q->where("users.name", "LIKE", "%$search%");
            $q->orWhere("users.email", "LIKE", "%$search%");
            $q->orWhere("roles.name", "LIKE", "%$search%");
        })
        ->select([
            'users.*',
            'roles.name as role'
        ])
        ->datatable($perPage, "users.created_at");
    }
}

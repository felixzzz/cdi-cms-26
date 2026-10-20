<?php

namespace App\Repositories\Utility;

use App\Models\Utility\Inbox;

class InboxRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($type, $perPage = 10)
    {
        $search = request('search');
        return Inbox::query()
        ->with([
            'country',
            'topic'
        ])
        ->where("type", $type)
        ->where(function ($q) use ($search) {
            $q->where("first_name", "LIKE", "%$search%");
            $q->orWhere("last_name", "LIKE", "%$search%");
            $q->orWhere("email", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function findDetail($id)
    {
        return Inbox::whereUlid($id)->firstOrFail();
    }
}

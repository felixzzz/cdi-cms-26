<?php

namespace App\Repositories\Data;

use App\Models\Data\Team;

class TeamRepository
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
        return Team::query()
        ->where(function ($q) use ($search) {
            $q->where("name", "LIKE", "%$search%");
            $q->orWhere("position", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function get($type)
    {
        return Team::query()
        ->where("type", $type)
        ->orderBy("created_at", "asc")
        ->get();
    }

    public function find($id)
    {
        $data = Team::query()->where("ulid", $id)->firstOrFail();

        $data->description = $data->description;
        return $data;
    }
}

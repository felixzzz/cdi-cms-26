<?php

namespace App\Repositories\AboutUs;

use App\Models\AboutUs\Milestone;

class MilestoneRepository
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
        $query = Milestone::query()
        ->where(function ($q) use ($search) {
            $q->where("year", "LIKE", "%$search%");
        });

        if (!request('filter_column')) {
            $query->orderBy("year", "asc")->orderBy("priority", "asc");
            return $query->paginate($perPage);
        }

        return $query->datatable($perPage, "year", "asc");
    }

    public function get()
    {
        return Milestone::query()
        ->orderBy("year", "asc")
        ->orderBy("priority", "asc")
        ->get()
        ->map(function ($row) {
            $row->content = $row->content;
            return $row;
        });
    }
}

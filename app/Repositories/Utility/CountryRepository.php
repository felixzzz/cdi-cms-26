<?php

namespace App\Repositories\Utility;

use App\Models\Utility\Country;

class CountryRepository
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
        return Country::query()
        ->where(function ($q) use ($search) {
            $q->where("name", "LIKE", "%$search%");
            $q->orWhere("code", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }


    public function list()
    {
        return Country::query()
        ->select('id', 'name')
        ->orderBy("name", "asc")->get();
    }

}

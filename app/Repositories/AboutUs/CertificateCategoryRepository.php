<?php

namespace App\Repositories\AboutUs;

use App\Models\AboutUs\CertificateCategory;

class CertificateCategoryRepository
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
        return CertificateCategory::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function list($sort = "name_en")
    {
        return CertificateCategory::query()
        ->orderBy($sort, "asc")->get();
    }
}

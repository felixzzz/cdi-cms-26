<?php

namespace App\Repositories\AboutUs;

use App\Enums\AdditionalFileType;
use App\Models\AboutUs\OurHistory;
use App\Models\Utility\AdditionalFile;

class CompanyProfileRepository
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
        return AdditionalFile::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
        })
        ->where("type", AdditionalFileType::CompanyProfile)
        ->datatable($perPage, "created_at");
    }
}

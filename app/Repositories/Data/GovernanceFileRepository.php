<?php

namespace App\Repositories\Data;

use App\Enums\AdditionalFileType;
use App\Models\Utility\AdditionalFile;

class GovernanceFileRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($perPage = 10, $type)
    {
        $type = str_replace("-", "_", $type);
        $search = request('search');
        return AdditionalFile::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
        })
        ->where("type", $type)
        ->orderBy("sort", "ASC")->paginate($perPage);
    }
}

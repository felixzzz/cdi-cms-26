<?php

namespace App\Repositories\Governance;

use App\Models\Governance\GovernanceCommitte;
use Illuminate\Support\Facades\App;

class GovernanceCommitteRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable()
    {
        return GovernanceCommitte::query()
        ->orderBy("sort", "asc")
        ->get();
    }

    public function list()
    {
        return GovernanceCommitte::query()
        ->where("is_show", 1)
        ->orderBy("sort", "asc")
        ->get()->map(function ($row) {
            $row->image = $row->image ? previewFile($row->image) : '';
            $row->tab_title = $row->tab_title;
            $row->title = $row->title;
            $row->content = $row->content;
            return $row;
        });;
    }

    public function check()
    {
        $data = GovernanceCommitte::query()
        ->where("is_show", 1)->first();

        return $data ? true : false;
    }
}

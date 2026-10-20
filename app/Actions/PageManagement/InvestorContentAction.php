<?php

namespace App\Actions\PageManagement;

use App\Enums\PreferenceKey;
use Illuminate\Http\Request;

class InvestorContentAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request)
    {
        $keys = PreferenceKey::getAllInvestorKey();

        (new PageManagementAction())->store($request, $keys, 'page-management/home');
    }
}

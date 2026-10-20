<?php

namespace App\Actions\PageManagement;

use App\Enums\PreferenceKey;
use App\Enums\PreferenceType;
use App\Helpers\StorageFile;
use App\Models\Utility\Preference;
use Illuminate\Http\Request;

class HomeContentAction
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
        $keys = PreferenceKey::getAllHomeKey();

        (new PageManagementAction())->store($request, $keys, 'page-management/home');

    }
}

<?php

namespace App\Actions\PageManagement;

use App\Enums\PreferenceKey;
use App\Enums\PreferenceType;
use App\Helpers\StorageFile;
use App\Models\Utility\Preference;
use Illuminate\Http\Request;

class AboutUsContentAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request, $key)
    {
        $keys = PreferenceKey::getAllAboutUsKey($key);

        (new PageManagementAction())->store($request, $keys, 'page-management/about-us');

    }
}

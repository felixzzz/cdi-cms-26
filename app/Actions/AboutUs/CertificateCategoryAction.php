<?php

namespace App\Actions\AboutUs;

use App\Models\AboutUs\CertificateCategory;
use Illuminate\Http\Request;

class CertificateCategoryAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request){
        $data = [
            ...$request->only(['name_en', 'name_id'])
        ];
        return CertificateCategory::create($data);
    }

    public function update(Request $request, $ulid){
        $data = [
            ...$request->only(['name_en', 'name_id'])
        ];
        return CertificateCategory::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return CertificateCategory::where('ulid', $ulid)->delete();
    }
}

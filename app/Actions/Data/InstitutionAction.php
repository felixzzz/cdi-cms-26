<?php

namespace App\Actions\Data;

use App\Http\Requests\Data\InstitutionRequest;
use App\Models\Data\Institution;

class InstitutionAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(InstitutionRequest $request)
    {
        $mainData = [
            'location_name_en' => $request->location_en,
            'location_name_id' => $request->location_id,
            'address_en' => $request->address_en,
            'address_id' => $request->address_id,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ];

        $branches = [];
        if ($request->has('branch_phone')) {
            foreach ($request->branch_phone as $index => $phone) {
                $branches[] = [
                    'location_name_en' => $request->branch_location_en[$index] ?? null,
                    'location_name_id' => $request->branch_location_id[$index] ?? null,
                    'address_en' => $request->branch_address_en[$index] ?? null,
                    'address_id' => $request->branch_address_id[$index] ?? null,
                    'phone' => $phone,
                    'fax' => $request->branch_fax[$index] ?? null,
                ];
            }
        }

        Institution::create([
            'name' => $request->name,
            'main' => $mainData,
            'branchs' => $branches
        ]);

    }

    public function update(InstitutionRequest $request, $ulid)
    {
        $mainData = [
            'location_name_en' => $request->location_en,
            'location_name_id' => $request->location_id,
            'address_en' => $request->address_en,
            'address_id' => $request->address_id,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ];

        $branches = [];
        if ($request->has('branch_phone')) {
            foreach ($request->branch_phone as $index => $phone) {
                $branches[] = [
                    'location_name_en' => $request->branch_location_en[$index] ?? null,
                    'location_name_id' => $request->branch_location_id[$index] ?? null,
                    'address_en' => $request->branch_address_en[$index] ?? null,
                    'address_id' => $request->branch_address_id[$index] ?? null,
                    'phone' => $phone,
                    'fax' => $request->branch_fax[$index] ?? null,
                ];
            }
        }

        Institution::whereUlid($ulid)->update([
            'name' => $request->name,
            'main' => $mainData,
            'branchs' => $branches
        ]);

    }

    public function delete($ulid){
        return Institution::where('ulid', $ulid)->delete();
    }
}

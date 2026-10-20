<?php

namespace App\Actions\Data;

use App\Http\Requests\Data\OfficeRequest;
use App\Models\Data\Office;

class OfficeAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(OfficeRequest $request)
    {
        $offices = Office::query()->where("is_main", 1)->count();
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

        if ($request->input("is_main") == 1 && $offices != 0) {
            Office::where("is_main", 1)->update([
                'is_main' => 0
            ]);
        }

        Office::create([
            'name' => $request->name,
            'sub_title_en' => $request->sub_title_en,
            'sub_title_id' => $request->sub_title_id,
            'main' => $mainData,
            'branchs' => $branches,
            'is_main' => $offices == 0 ? 1 : $request->input("is_main")
        ]);

    }

    public function update(OfficeRequest $request, $ulid)
    {
        $offices = Office::query()->where("is_main", 1)->where("ulid", "!=", $ulid)->count();

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

        if ($request->input("is_main") == 1 && $offices != 0) {
            Office::where("is_main", 1)->update([
                'is_main' => 0
            ]);
        }

        Office::whereUlid($ulid)->update([
            'name' => $request->name,
            'sub_title_en' => $request->sub_title_en,
            'sub_title_id' => $request->sub_title_id,
            'main' => $mainData,
            'branchs' => $branches,
            'is_main' => $offices == 0 ? 1 : $request->input("is_main")
        ]);

    }

    public function delete($ulid){
        return Office::where('ulid', $ulid)->delete();
    }
}

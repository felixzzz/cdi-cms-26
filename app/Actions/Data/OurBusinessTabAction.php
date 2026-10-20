<?php

namespace App\Actions\Data;

use App\Helpers\StorageFile;
use App\Models\OurBusiness\OurBusiness;
use App\Models\OurBusiness\OurBusinessTab;
use App\Repositories\Data\OurBusinessRepository;
use Illuminate\Http\Request;

class OurBusinessTabAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request, $id){
        $business = OurBusiness::whereUlid($id)->first();
        $data = [
            ...$request->only(['title_en', 'title_id', 'sub_title_en', 'sub_title_id', 'description_en', 'description_id']),
            'our_business_id' => $business->id
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'our-business/tabs');
        }

        OurBusinessTab::create($data);
        (new OurBusinessRepository())->resetCache();
    }

    public function update(Request $request, $id, $ulid){
        $data = [
            ...$request->only(['title_en', 'title_id', 'sub_title_en', 'sub_title_id', 'description_en', 'description_id']),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'our-business/tabs');
        }

        if ($request->delete_image == 'yes') {
            $data['image'] = null;
        }

        OurBusinessTab::whereUlid($ulid)->update($data);
        (new OurBusinessRepository())->resetCache();
    }

    public function delete($ulid){
        OurBusinessTab::where('ulid', $ulid)->delete();
        (new OurBusinessRepository())->resetCache();
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            OurBusinessTab::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
        (new OurBusinessRepository())->resetCache();
    }
}

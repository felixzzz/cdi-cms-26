<?php

namespace App\Actions\Data;

use App\Helpers\StorageFile;
use Illuminate\Http\Request;
use App\Models\OurBusiness\OurBusinessContent;
use App\Models\OurBusiness\OurBusinessTab;
use App\Repositories\Data\OurBusinessRepository;

class OurBusinessTabContentAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request, $id, $tabId){
        $tab = OurBusinessTab::whereUlid($tabId)->first();
        $data = [
            ...$request->only([
                'name',
                'heading_en',
                'heading_id',
                'heading_position',
                'tagline_en',
                'tagline_id',
                'title_en',
                'title_id',
                'description_en',
                'description_id',
                'align'
            ]),
            'our_business_id' => $tab->our_business_id,
            'our_business_tab_id' => $tab->id
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'our-business/contents');
        }

        OurBusinessContent::create($data);
        (new OurBusinessRepository())->resetCache();
    }

    public function update(Request $request, $id, $tabId, $ulid){
        $data = [
            ...$request->only([
                'name',
                'heading_en',
                'heading_id',
                'heading_position',
                'tagline_en',
                'tagline_id',
                'title_en',
                'title_id',
                'description_en',
                'description_id',
                'align'
            ]),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'our-business/contents');
        }

        if ($request->delete_image == 'yes') {
            $data['image'] = null;
        }

        OurBusinessContent::whereUlid($ulid)->update($data);
        (new OurBusinessRepository())->resetCache();
    }

    public function delete($ulid){
        OurBusinessContent::where('ulid', $ulid)->delete();
        (new OurBusinessRepository())->resetCache();
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            OurBusinessContent::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }

        (new OurBusinessRepository())->resetCache();
    }
}

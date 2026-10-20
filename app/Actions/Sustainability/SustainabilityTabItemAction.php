<?php

namespace App\Actions\Sustainability;

use App\Helpers\StorageFile;
use App\Models\Sustainability\SustainabilityTab;
use Illuminate\Http\Request;
use App\Models\Sustainability\SustainabilityTabItem;

class SustainabilityTabItemAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request, $tabId){
        $tab = SustainabilityTab::whereUlid($tabId)->first();
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
                'content_en',
                'content_id',
                'align'
            ]),
            'sustainability_tab_id' => $tab->id
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'sustainability/tabs');
        }

        return SustainabilityTabItem::create($data);
    }

    public function update(Request $request, $ulid, $tabId){
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
                'content_en',
                'content_id',
                'align'
            ]),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'sustainability/tabs');
        }

        SustainabilityTabItem::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return SustainabilityTabItem::where('ulid', $ulid)->delete();
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            SustainabilityTabItem::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }
}

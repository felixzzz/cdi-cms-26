<?php

namespace App\Actions\AboutUs;

use App\Helpers\StorageFile;
use Illuminate\Http\Request;
use App\Models\AboutUs\OurHistory;
use App\Http\Requests\AboutUs\OurHistoryRequest;

class OurHistoryAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(OurHistoryRequest $request){
        $data = [
            ...$request->only([
                'title_en',
                'title_id',
                'content_en',
                'content_id',
                'tagline_en',
                'tagline_id'
            ])
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'aboutus/ourhistory');
        }

        return OurHistory::create($data);
    }

    public function update(OurHistoryRequest $request, $ulid){
        $data = [
            ...$request->only([
                'title_en',
                'title_id',
                'content_en',
                'content_id',
                'tagline_en',
                'tagline_id'
            ])
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'aboutus/ourhistory');
        }

        return OurHistory::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return OurHistory::where('ulid', $ulid)->delete();
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            OurHistory::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }
}

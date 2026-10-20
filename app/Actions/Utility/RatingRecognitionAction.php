<?php

namespace App\Actions\Utility;

use App\Helpers\StorageFile;
use App\Http\Requests\RatingRecognitionRequest;
use App\Models\Sustainability\RatingRecognition;
use Illuminate\Http\Request;

class RatingRecognitionAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(RatingRecognitionRequest $request){
        $data = [
            ...$request->only(['name_en', 'name_id', 'type', 'content_en', 'content_id'])
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'ratings');
        }

        return RatingRecognition::create($data);
    }

    public function update(RatingRecognitionRequest $request, $ulid){
        $data = [
            ...$request->only(['name_en', 'name_id', 'type', 'content_en', 'content_id'])
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'ratings');
        }

        return RatingRecognition::whereUlid($ulid)->update($data);
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            RatingRecognition::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }

    public function delete($ulid){
        return RatingRecognition::where('ulid', $ulid)->delete();
    }
}

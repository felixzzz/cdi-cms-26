<?php

namespace App\Actions\AboutUs;

use App\Helpers\StorageFile;
use App\Http\Requests\AboutUs\AwardRequest;
use App\Models\AboutUs\Award;

class AwardAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(AwardRequest $request){
        $data = [
            ...$request->only([
                'name_en',
                'name_id',
                'awarder_en',
                'awarder_id',
                'date'
            ]),
            'content_en' => $request->content_en ?? '',
            'content_id' => $request->content_id ?? '',
        ];

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::upload($request->file('file'), 'aboutus/awards');
        }

        return Award::create($data);
    }

    public function update(AwardRequest $request, $ulid){
        $data = [
            ...$request->only([
                'name_en',
                'name_id',
                'awarder_en',
                'awarder_id',
                'date'
            ]),
            'content_en' => $request->content_en ?? '',
            'content_id' => $request->content_id ?? '',
        ];

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::upload($request->file('file'), 'aboutus/awards');
        }

        return Award::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return Award::where('ulid', $ulid)->delete();
    }
}

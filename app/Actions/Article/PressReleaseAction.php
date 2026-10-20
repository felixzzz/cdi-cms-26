<?php

namespace App\Actions\Article;

use App\Helpers\StorageFile;
use App\Http\Requests\Article\PressReleaseRequest;
use App\Models\Article\PressRelease;

class PressReleaseAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(PressReleaseRequest $request){
        $data = [
            ...$request->only(['datetime', 'name_en', 'name_id', 'status'])
        ];

        if ($request->hasFile('file_en')) {
            $data['file_en'] = StorageFile::uploadWithDetails($request->file('file_en'), 'article/press-releases/en');
        }

        if ($request->hasFile('file_id')) {
            $data['file_id'] = StorageFile::uploadWithDetails($request->file('file_id'), 'article/press-releases/id');
        }

        return PressRelease::create($data);
    }

    public function update(PressReleaseRequest $request, $ulid){
        $data = [
            ...$request->only(['datetime', 'name_en', 'name_id', 'status'])
        ];


        if ($request->hasFile('file_en')) {
            $data['file_en'] = StorageFile::uploadWithDetails($request->file('file_en'), 'article/press-releases/en');
        }

        if ($request->hasFile('file_id')) {
            $data['file_id'] = StorageFile::uploadWithDetails($request->file('file_id'), 'article/press-releases/id');
        }

        return PressRelease::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return PressRelease::where('ulid', $ulid)->delete();
    }
}

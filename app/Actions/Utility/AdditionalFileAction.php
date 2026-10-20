<?php

namespace App\Actions\Utility;

use App\Helpers\StorageFile;
use Illuminate\Http\Request;
use App\Models\Utility\AdditionalFile;
use App\Http\Requests\Utility\AdditionalFileRequest;

class AdditionalFileAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(AdditionalFileRequest $request, $type = null){
        $data = [
            ...$request->only(['name_en', 'name_id']),
            'show_on_governance' => $request->input("show_on_governance", 0),
            'type' => $type ?? $request->type,
            'unique_key' => request('unique_key')
        ];

        if ($request->hasFile('file_en')) {
            $data['file_en'] = StorageFile::uploadWithDetails($request->file('file_en'), 'additional-file/en');
        }

        if ($request->hasFile('file_id')) {
            $data['file_id'] = StorageFile::uploadWithDetails($request->file('file_id'), 'additional-file/id');
        }

        return AdditionalFile::create($data);
    }

    public function update(AdditionalFileRequest $request, $ulid, $type = null){
        $data = [
            ...$request->only(['name_en', 'name_id']),
            'show_on_governance' => $request->input("show_on_governance", 0),
            'type' => $type ?? $request->type
        ];


        if ($request->hasFile('file_en')) {
            $data['file_en'] = StorageFile::uploadWithDetails($request->file('file_en'), 'additional-file/en');
        }

        if ($request->hasFile('file_id')) {
            $data['file_id'] = StorageFile::uploadWithDetails($request->file('file_id'), 'additional-file/id');
        }

        return AdditionalFile::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return AdditionalFile::where('ulid', $ulid)->delete();
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            AdditionalFile::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }
}

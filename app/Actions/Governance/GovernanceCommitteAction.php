<?php

namespace App\Actions\Governance;

use App\Helpers\StorageFile;
use App\Models\Governance\GovernanceCommitte;
use Illuminate\Http\Request;

class GovernanceCommitteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request){
        $data = [
            ...$request->only([
                'tab_title_en',
                'tab_title_id',
                'title_en',
                'title_id',
                'content_en',
                'content_id',
                'file_name',
                'is_show'
            ])
        ];

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::uploadWithDetails($request->file('file'), 'governance-committes');
        }

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'aboutus/ourhistory');
        }

        return GovernanceCommitte::create($data);
    }

    public function update(Request $request, $ulid){
        $data = [
            ...$request->only([
                'tab_title_en',
                'tab_title_id',
                'title_en',
                'title_id',
                'content_en',
                'content_id',
                'file_name',
                'is_show'
            ])
        ];

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::uploadWithDetails($request->file('file'), 'governance-committes');
        }

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'aboutus/ourhistory');
        }

        return GovernanceCommitte::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return GovernanceCommitte::where('ulid', $ulid)->delete();
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            GovernanceCommitte::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }
}

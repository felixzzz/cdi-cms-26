<?php

namespace App\Actions\Utility;

use Illuminate\Http\Request;
use App\Models\Utility\QuickLink;
use App\Http\Requests\QuickLinkRequest;

class QuickLinkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(QuickLinkRequest $request){
        $data = [
            ...$request->only(['name_en', 'name_id', 'category', 'url'])
        ];
        return QuickLink::create($data);
    }

    public function update(QuickLinkRequest $request, $ulid){
        $data = [
            ...$request->only(['name_en', 'name_id', 'category', 'url'])
        ];
        return QuickLink::whereUlid($ulid)->update($data);
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            QuickLink::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }

    public function delete($ulid){
        return QuickLink::where('ulid', $ulid)->delete();
    }
}

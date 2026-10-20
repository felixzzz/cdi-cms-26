<?php

namespace App\Actions\Sustainability;

use App\Models\Sustainability\SustainabilityTab;
use Illuminate\Http\Request;

class SustainabilityTabAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request, $category){
        $data = [
            ...$request->only(['title_en', 'title_id']),
            'category' => $category
        ];

        return SustainabilityTab::create($data);
    }

    public function update(Request $request, $ulid, $category){
        $data = [
            ...$request->only(['title_en', 'title_id']),
            'category' => $category
        ];

        return SustainabilityTab::whereUlid($ulid)->update($data);
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            SustainabilityTab::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }

    public function delete($ulid){
        return SustainabilityTab::where('ulid', $ulid)->delete();
    }
}

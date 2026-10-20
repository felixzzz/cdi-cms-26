<?php

namespace App\Actions\Sustainability;

use App\Helpers\StorageFile;
use App\Models\Sustainability\SustainabilityReport;
use Illuminate\Http\Request;

class SustainabilityReportAction
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
                'title_en',
                'title_id',
                'type',
                'description_en',
                'description_id',
                'author',
                'publisher',
                'release_year',
                'pages',
                'format',
            ])
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'reports');
        }

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::uploadWithDetails($request->file('file'), 'reports');
        }

        return SustainabilityReport::create($data);
    }

    public function update(Request $request, $ulid){
        $data = [
            ...$request->only([
                'title_en',
                'title_id',
                'type',
                'description_en',
                'description_id',
                'author',
                'publisher',
                'release_year',
                'pages',
                'format',
            ])
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'reports');
        }

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::uploadWithDetails($request->file('file'), 'reports');
        }

        return SustainabilityReport::whereUlid($ulid)->update($data);
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            SustainabilityReport::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }

    public function delete($ulid){
        return SustainabilityReport::where('ulid', $ulid)->delete();
    }
}

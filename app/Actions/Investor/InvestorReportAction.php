<?php

namespace App\Actions\Investor;

use App\Helpers\StorageFile;
use App\Http\Requests\Investor\InvestorReportRequest;
use App\Models\Investor\InvestorReport;

class InvestorReportAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(InvestorReportRequest $request){
        $data = [
            ...$request->only(['name_en', 'name_id', 'type', 'datetime'])
        ];

        if ($request->hasFile('file_en')) {
            $data['file_en'] = StorageFile::uploadWithDetails($request->file('file_en'), 'article/press-releases/en');
        }

        if ($request->hasFile('file_id')) {
            $data['file_id'] = StorageFile::uploadWithDetails($request->file('file_id'), 'article/press-releases/id');
        }

        return InvestorReport::create($data);
    }

    public function update(InvestorReportRequest $request, $ulid){
        $data = [
            ...$request->only(['name_en', 'name_id', 'type', 'datetime'])
        ];


        if ($request->hasFile('file_en')) {
            $data['file_en'] = StorageFile::uploadWithDetails($request->file('file_en'), 'article/press-releases/en');
        }

        if ($request->hasFile('file_id')) {
            $data['file_id'] = StorageFile::uploadWithDetails($request->file('file_id'), 'article/press-releases/id');
        }

        return InvestorReport::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return InvestorReport::where('ulid', $ulid)->delete();
    }
}

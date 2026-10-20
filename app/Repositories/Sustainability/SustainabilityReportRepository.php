<?php

namespace App\Repositories\Sustainability;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Sustainability\SustainabilityReport;

class SustainabilityReportRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($perPage = 10)
    {
        $search = request('search');
        return SustainabilityReport::query()
        ->where(function ($q) use ($search) {
            $q->where("title_en", "LIKE", "%$search%");
            $q->orWhere("title_id", "LIKE", "%$search%");
            $q->orWhere("type", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function findPaginated(Request $request, $type)
    {
        $maxLimit = 15;
        $limit = $request->get('limit', $maxLimit);

        $data = SustainabilityReport::query()
            ->where("type", $type)
            ->orderBy('created_at','desc')
            ->orderBy('id','desc')
            ->paginate($limit);
        return [
            'links' => Helper::makePagination($data),
            'meta' => Helper::metaPagination($data),
            'items' => collect($data->items())
                ->reverse()
                ->take($maxLimit)
                ->reverse()
                ->map(function ($row) {
                        $row->title = $row->title;
                        $row->description = $row->description;
                        $row->image = previewFile($row->image);
                        return $row;
                })->values()
        ];

    }

}

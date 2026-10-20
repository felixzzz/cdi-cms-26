<?php

namespace App\Repositories\AboutUs;

use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\AboutUs\Membership;

class MembershipRepository
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
        return Membership::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function findPaginated(Request $request)
    {
        $maxLimit = 15;
        $limit = $request->get('limit', $maxLimit);

        $data = Membership::query()
            ->orderBy('date','desc')
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
                        $row->name = $row->name;
                        $row->content = $row->content;
                        $row->image = previewFile($row->file);
                        $row->year = Carbon::parse($row->date)->translatedFormat("Y");
                        return $row;
                })->values()
        ];
    }
}

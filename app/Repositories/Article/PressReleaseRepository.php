<?php

namespace App\Repositories\Article;

use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Article\PressRelease;
use Illuminate\Support\Facades\App;

class PressReleaseRepository
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
        return PressRelease::query()
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
        $search = $request->search;
        $locale = App::currentLocale();

        $data = PressRelease::query()
            ->where("status", 1)
            ->when($search, fn ($q) => $q->where("name_{$locale}", "LIKE", "%$search%"))
            ->orderBy('datetime','desc')
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
                        $row->name_slug = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name);
                        $row->name_slug_id = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_id);
                        $row->name_slug_en = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_en);
                        $row->file = json_decode($row->file);
                        $row->date = Carbon::parse($row->datetime)->translatedFormat("d F Y");
                        return $row;
                })->values()
        ];

    }
}

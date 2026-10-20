<?php

namespace App\Repositories\Sustainability;

use Illuminate\Support\Facades\App;
use App\Models\Sustainability\SustainabilityContent;

class SustainabilityContentRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($category)
    {
        return SustainabilityContent::query()
        ->when($category, fn ($q) => $q->where("category", $category))
        ->orderBy("sort", "asc")
        ->paginate(15);
    }

    public function detail($type)
    {
        $locale = App::currentLocale();
        return SustainabilityContent::where("category", $type)
        ->where("is_show", 1)
        ->get()->map(function ($row) use ($locale) {
            $row->title = $row->title;
            $row->content = $row->content;

            $contentJson = $locale == 'en' ? $row->content_json_en : $row->content_json_id;
            if (is_array($contentJson)) {
                $contentJson = array_map(function ($item) {
                    if (is_array($item) && !empty($item['icon'])) {
                        $item['icon'] = previewFile($item['icon']);
                    }
                    return $item;
                }, $contentJson);
            }
            $row->content_json = $contentJson;

            $row->image = $row->image ? previewFile($row->image) : '';
            $row->file_information = $locale == 'en' ? $row->file_information_en : $row->file_information_id;
            return $row;
        });
    }
}

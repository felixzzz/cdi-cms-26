<?php

namespace App\Actions\Sustainability;

use App\Helpers\StorageFile;
use Illuminate\Http\Request;
use App\Models\Sustainability\SustainabilityContent;

class SustainabilityContentAction
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
            ...$request->only([
                'name',
                'title_en',
                'title_id',
                'content_en',
                'content_id',
                'type',
                'background',
                'grid_pattern',
                'grid_direction',
                'align',
                'is_show'
            ]),
            'category' => $category,
            'grid_type' => $request->type == 'grid' ? $request->grid_type : ''
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'sustainability/contents');
        }

        $contentJsonEn = [];
        $contentJsonId = [];

        if ($request->type == 'grid' && $request->has('content_json_title_en')) {
            foreach ($request->content_json_title_en as $index => $value) {
                $itemEn = [
                    'icon' => '',
                    'title' => $request->content_json_title_en[$index] ?? null,
                    'description' => $request->content_json_description_en[$index] ?? null
                ];

                $itemId = [
                    'icon' => '',
                    'title' => $request->content_json_title_id[$index] ?? null,
                    'description' => $request->content_json_description_id[$index] ?? null
                ];

                if ($request->hasFile("content_json_icon.{$index}")) {
                    $itemEn['icon'] = StorageFile::upload($request->file("content_json_icon.{$index}"), 'sustainability/contents');
                    $itemId['icon'] = StorageFile::upload($request->file("content_json_icon.{$index}"), 'sustainability/contents');
                }

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }

            $data['content_json_en'] = $contentJsonEn;
            $data['content_json_id'] = $contentJsonId;
        }

        if ($request->type == 'swiper' && $request->has('content_json_swiper_title_en')) {
            foreach ($request->content_json_swiper_title_en as $index => $value) {
                $itemEn = [
                    'icon' => '',
                    'title' => $request->content_json_swiper_title_en[$index] ?? null,
                    'description' => $request->content_json_swiper_description_en[$index] ?? null
                ];

                $itemId = [
                    'icon' => '',
                    'title' => $request->content_json_swiper_title_id[$index] ?? null,
                    'description' => $request->content_json_swiper_description_id[$index] ?? null
                ];

                if ($request->hasFile("content_json_swiper_icon.{$index}")) {
                    $itemEn['icon'] = StorageFile::upload($request->file("content_json_swiper_icon.{$index}"), 'sustainability/contents');
                    $itemId['icon'] = StorageFile::upload($request->file("content_json_swiper_icon.{$index}"), 'sustainability/contents');
                }

                $itemEn['number'] = $request->content_json_swiper_number[$index] ?? null;
                $itemId['number'] = $request->content_json_swiper_number[$index] ?? null;

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }

            $data['content_json_en'] = $contentJsonEn;
            $data['content_json_id'] = $contentJsonId;
        }

        if ($request->type == 'list_information' && $request->has('content_json_list_title_en')) {
            foreach ($request->content_json_list_title_en as $index => $value) {
                $itemEn = [
                    'title' => $request->content_json_list_title_en[$index] ?? null,
                    'description' => $request->content_json_list_description_en[$index] ?? null
                ];

                $itemId = [
                    'title' => $request->content_json_list_title_id[$index] ?? null,
                    'description' => $request->content_json_list_description_id[$index] ?? null
                ];

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }

            $data['content_json_en'] = $contentJsonEn;
            $data['content_json_id'] = $contentJsonId;
        }

        if ($request->type == 'simple_text_information' && $request->has('content_json_simple_title_en')) {
            foreach ($request->content_json_simple_title_en as $index => $value) {
                $itemEn = [
                    'title' => $request->content_json_simple_title_en[$index] ?? null,
                    'description' => $request->content_json_simple_description_en[$index] ?? null
                ];

                $itemId = [
                    'title' => $request->content_json_simple_title_id[$index] ?? null,
                    'description' => $request->content_json_simple_description_id[$index] ?? null
                ];

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }

            $data['content_json_en'] = $contentJsonEn;
            $data['content_json_id'] = $contentJsonId;
        }

        if ($request->type == 'file_information') {
            // EN
            $fileInformationEn = [];
            if ($request->type == 'file_information' && $request->hasFile("file_information_en_file")) {
                $fileDetail = StorageFile::uploadWithDetails($request->file("file_information_en_file"), "sustainability/contents");
                $fileInformationEn = $fileDetail;
            }
            $fileInformationEn['title'] = $request->file_information_en_title;

            $data['file_information_en'] = $fileInformationEn;

            // ID
            $fileInformationId = [];
            if ($request->type == 'file_information' && $request->hasFile("file_information_id_file")) {
                $fileDetail = StorageFile::uploadWithDetails($request->file("file_information_id_file"), "sustainability/contents");
                $fileInformationId = $fileDetail;
            }
            $fileInformationId['title'] = $request->file_information_id_title;

            $data['file_information_id'] = $fileInformationId;
        }

        return SustainabilityContent::create($data);
    }

    public function update(Request $request, $ulid, $category){
        $sustainability = SustainabilityContent::whereUlid($ulid)->first();
        $data = [
            ...$request->only([
                'name',
                'title_en',
                'title_id',
                'content_en',
                'content_id',
                'type',
                'background',
                'grid_pattern',
                'grid_direction',
                'align',
                'is_show'
            ]),
            'category' => $category,
            'grid_type' => $request->type == 'grid' ? $request->grid_type : ''
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'sustainability/contents');
        }

        $contentJsonEn = [];
        $contentJsonId = [];

        if ($request->type == 'grid' && $request->has('content_json_title_en')) {
            foreach ($request->content_json_title_en as $index => $value) {
                $itemEn = [
                    'icon' => $request->content_json_icon_existing[$index] ?? null,
                    'title' => $request->content_json_title_en[$index] ?? null,
                    'description' => $request->content_json_description_en[$index] ?? null
                ];

                $itemId = [
                    'icon' => $request->content_json_icon_existing[$index] ?? null,
                    'title' => $request->content_json_title_id[$index] ?? null,
                    'description' => $request->content_json_description_id[$index] ?? null
                ];

                if ($request->hasFile("content_json_icon.{$index}")) {
                    $itemEn['icon'] = StorageFile::upload($request->file("content_json_icon.{$index}"), 'sustainability/contents');
                    $itemId['icon'] = StorageFile::upload($request->file("content_json_icon.{$index}"), 'sustainability/contents');
                }

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }
        }

        if ($request->type == 'swiper' && $request->has('content_json_swiper_title_en')) {
            foreach ($request->content_json_swiper_title_en as $index => $value) {
                $itemEn = [
                    'icon' => $request->content_json_swiper_icon_existing[$index] ?? null,
                    'title' => $request->content_json_swiper_title_en[$index] ?? null,
                    'description' => $request->content_json_swiper_description_en[$index] ?? null
                ];

                $itemId = [
                    'icon' => $request->content_json_swiper_icon_existing[$index] ?? null,
                    'title' => $request->content_json_swiper_title_id[$index] ?? null,
                    'description' => $request->content_json_swiper_description_id[$index] ?? null
                ];

                if ($request->hasFile("content_json_swiper_icon.{$index}")) {
                    $itemEn['icon'] = StorageFile::upload($request->file("content_json_swiper_icon.{$index}"), 'sustainability/contents');
                    $itemId['icon'] = StorageFile::upload($request->file("content_json_swiper_icon.{$index}"), 'sustainability/contents');
                }

                $itemEn['number'] = $request->content_json_swiper_number[$index] ?? null;
                $itemId['number'] = $request->content_json_swiper_number[$index] ?? null;

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }
        }

        if ($request->type == 'list_information' && $request->has('content_json_list_title_en')) {
            foreach ($request->content_json_list_title_en as $index => $value) {
                $itemEn = [
                    'title' => $request->content_json_list_title_en[$index] ?? null,
                    'description' => $request->content_json_list_description_en[$index] ?? null
                ];

                $itemId = [
                    'title' => $request->content_json_list_title_id[$index] ?? null,
                    'description' => $request->content_json_list_description_id[$index] ?? null
                ];

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }
        }

        if ($request->type == 'simple_text_information' && $request->has('content_json_simple_title_en')) {
            foreach ($request->content_json_simple_title_en as $index => $value) {
                $itemEn = [
                    'title' => $request->content_json_simple_title_en[$index] ?? null,
                    'description' => $request->content_json_simple_description_en[$index] ?? null
                ];

                $itemId = [
                    'title' => $request->content_json_simple_title_id[$index] ?? null,
                    'description' => $request->content_json_simple_description_id[$index] ?? null
                ];

                $contentJsonEn[] = $itemEn;
                $contentJsonId[] = $itemId;
            }

            $data['content_json_en'] = $contentJsonEn;
            $data['content_json_id'] = $contentJsonId;
        }

        $data['content_json_en'] = $contentJsonEn;
        $data['content_json_id'] = $contentJsonId;

        if ($request->type == 'file_information') {
            // EN
            $fileInformationEn = $sustainability->file_information_en ?? [];
            if ($request->type == 'file_information' && $request->hasFile("file_information_en_file")) {
                $fileDetail = StorageFile::uploadWithDetails($request->file("file_information_en_file"), "sustainability/contents");
                $fileInformationEn = $fileDetail;
            }
            $fileInformationEn['title'] = $request->file_information_en_title;

            $data['file_information_en'] = $fileInformationEn;

            // ID
            $fileInformationId = $sustainability->file_information_id ?? [];
            if ($request->type == 'file_information' && $request->hasFile("file_information_id_file")) {
                $fileDetail = StorageFile::uploadWithDetails($request->file("file_information_id_file"), "sustainability/contents");
                $fileInformationId = $fileDetail;
            }
            $fileInformationId['title'] = $request->file_information_id_title;

            $data['file_information_id'] = $fileInformationId;
        }

        return SustainabilityContent::whereUlid($ulid)->update($data);
    }

    public function updateSort(Request $request)
    {
        $data = $request->input('order');

        foreach ($data as $item) {
            SustainabilityContent::where('id', $item['id'])->update(['sort' => $item['sort']]);
        }
    }

    public function delete($ulid){
        return SustainabilityContent::where('ulid', $ulid)->delete();
    }
}

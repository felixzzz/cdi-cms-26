<?php

namespace App\Repositories\Data;

use App\Helpers\Optimize;
use Illuminate\Support\Facades\App;
use App\Models\OurBusiness\OurBusiness;
use App\Models\OurBusiness\OurBusinessTab;
use App\Models\OurBusiness\OurBusinessContent;

class OurBusinessRepository
{
    protected $detailKey = "our-business-detail-";
    protected $listKey = "our-business-list";
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
        return OurBusiness::query()
        ->where(function ($q) use ($search) {
            $q->where("title_en", "LIKE", "%$search%");
            $q->orWhere("title_id", "LIKE", "%$search%");
        })
        ->orderBy("id", "asc")->paginate($perPage);
    }

    public function tabsDatatable($ulid)
    {
        $search = request('search');
        return OurBusinessTab::query()
        ->join("our_businesses", "our_businesses.id", "our_business_tabs.our_business_id")
        ->where(function ($q) use ($search) {
            $q->where("our_business_tabs.title_en", "LIKE", "%$search%");
            $q->orWhere("our_business_tabs.title_id", "LIKE", "%$search%");
        })
        ->where("our_businesses.ulid", $ulid)
        ->select("our_business_tabs.*")
        ->orderBy("our_business_tabs.sort", "asc")->paginate(10);
    }

    public function contentsDatatable($ulid, $tabId)
    {
        $search = request('search');
        return OurBusinessContent::query()
        ->join("our_businesses", "our_businesses.id", "our_business_contents.our_business_id")
        ->join("our_business_tabs", "our_business_tabs.id", "our_business_contents.our_business_tab_id")
        ->where(function ($q) use ($search) {
            $q->where("our_business_contents.name", "LIKE", "%$search%");
        })
        ->where("our_businesses.ulid", $ulid)
        ->where("our_business_tabs.ulid", $tabId)
        ->select("our_business_contents.*")
        ->orderBy("our_business_contents.sort", "asc")->paginate(15);
    }

    public function getOverviewList()
    {
        $locale = App::currentLocale();
        return Optimize::cache($this->listKey."_".$locale, function () {
            return OurBusiness::with(["tabs"])
            ->get()->map(function ($row) {
                $row->tabs = $row->tabs->map(function ($tab) {
                    $tab->title = $tab->title;
                    return $tab;
                });

                $route = '';
                if($row->type == 'energy') $route = route('our-business.power');
                if($row->type == 'water') $route = route('our-business.water');
                if($row->type == 'port_storage') $route = route('our-business.ports-and-storage');
                if($row->type == 'logistic') $route = route('our-business.logistics');

                $row->route = $route;
                $row->image = previewFile($row->image);
                $row->title = $row->title;
                $row->description = $row->description;
                return $row;
            });
        }, config('cache.content_lifetime'));
    }

    public function detailByType($type)
    {
        $businessType = ($type === 'power') ? 'energy' : $type;
        $locale = App::currentLocale();

        return Optimize::cache($this->detailKey."_".$locale."_"."$type", function () use ($businessType) {
            $data = OurBusiness::with(["tabs", "tabs.contents"])
                ->where("type", $businessType)
                ->firstOrFail();
            $data->tabs = $data->tabs->map(function ($tab) {
                $tab->title = $tab->title;
                $tab->sub_title = $tab->sub_title;
                $tab->description = $tab->description;
                $tab->image = $tab->image ? previewFile($tab->image) : '';
                $tab->contents = $tab->contents->map(function ($content) {
                    $content->heading = $content->heading;
                    $content->tagline = $content->tagline;
                    $content->title = $content->title;
                    $content->description = $content->description;
                    $content->image = $content->image ? previewFile($content->image) : '';
                    return $content;
                });
                return $tab;
            });

            $data->image = previewFile($data->image);
            $data->title = $data->title;
            $data->description = $data->description;
            $data->heading_tab_title = $data->heading_tab_title;

            $data->banner_image = previewFile($data->banner_image);
            $data->banner_title = $data->banner_title;
            $data->banner_description = $data->banner_description;

            $data->overview_image = $data->overview_image ? previewFile($data->overview_image) : '';
            $data->overview_title = $data->overview_title;
            $data->overview_description = $data->overview_description;
            $data->link_url = $data->link_url ?: '#';
            $data->link_title_en = $data->link_title_en ?: '';
            $data->link_title_id = $data->link_title_id ?: '';

            return $data;

        }, config('cache.content_lifetime'));
    }

    public function resetCache()
    {
        Optimize::delete($this->listKey."_en");
        Optimize::delete($this->detailKey."_en_"."energy");
        Optimize::delete($this->detailKey."_en_"."power");
        Optimize::delete($this->detailKey."_en_"."water");
        Optimize::delete($this->detailKey."_en_"."port_storage");
        Optimize::delete($this->detailKey."_en_"."logistic");

        Optimize::delete($this->listKey."_id");
        Optimize::delete($this->detailKey."_id_"."energy");
        Optimize::delete($this->detailKey."_id_"."power");
        Optimize::delete($this->detailKey."_id_"."water");
        Optimize::delete($this->detailKey."_id_"."port_storage");
        Optimize::delete($this->detailKey."_id_"."logistic");

    }
}

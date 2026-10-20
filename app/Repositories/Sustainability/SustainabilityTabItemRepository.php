<?php

namespace App\Repositories\Sustainability;

use App\Models\Sustainability\SustainabilityTabItem;

class SustainabilityTabItemRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($category, $tabId)
    {
        return SustainabilityTabItem::query()
        ->join("sustainability_tabs", "sustainability_tabs.id", "sustainability_tab_items.sustainability_tab_id")
        ->where('sustainability_tabs.ulid', $tabId)
        ->select("sustainability_tab_items.*")
        ->orderBy("sort", "asc")
        ->paginate(15);
    }
}

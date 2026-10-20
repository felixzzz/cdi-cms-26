<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Data\OurBusinessRepository;
use Illuminate\Http\Request;

class ApiOurBusinessController extends Controller
{
    public function overviewList(OurBusinessRepository $ourBusinessRepository)
    {
        return $ourBusinessRepository->getOverviewList();
    }

    public function detail(OurBusinessRepository $ourBusinessRepository, $type)
    {
        return $ourBusinessRepository->detailByType($type);
    }
}

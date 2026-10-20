<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AboutUs\AwardRepository;
use Illuminate\Http\Request;

class ApiAwardController extends Controller
{
    public function list(Request $request, AwardRepository $awardRepository)
    {
        return $awardRepository->findPaginated($request);
    }

    public function years(AwardRepository $awardRepository)
    {
        return $awardRepository->years();
    }
}

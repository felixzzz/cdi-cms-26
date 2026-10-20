<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Article\PressReleaseRepository;
use Illuminate\Http\Request;

class ApiPressReleaseController extends Controller
{
    public function list(Request $request, PressReleaseRepository $pressReleaseRepository)
    {
        return $pressReleaseRepository->findPaginated($request);
    }
}

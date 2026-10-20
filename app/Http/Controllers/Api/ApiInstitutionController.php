<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Data\InstitutionRepository;
use Illuminate\Http\Request;

class ApiInstitutionController extends Controller
{
    public function list(InstitutionRepository $institutionRepository)
    {
        return $institutionRepository->list();
    }
}

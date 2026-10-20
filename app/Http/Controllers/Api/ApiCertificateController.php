<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AboutUs\CertificateRepository;
use Illuminate\Http\Request;

class ApiCertificateController extends Controller
{
    public function list(Request $request, CertificateRepository $certificateRepository)
    {
        return $certificateRepository->findPaginated($request);
    }
}

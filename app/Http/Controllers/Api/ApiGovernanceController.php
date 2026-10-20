<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Utility\FileRepository;
use Illuminate\Http\Request;

class ApiGovernanceController extends Controller
{
    public function files(FileRepository $fileRepository, $type)
    {
        return $fileRepository->findPaginated($type);
    }
}

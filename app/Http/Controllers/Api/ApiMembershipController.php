<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AboutUs\MembershipRepository;
use Illuminate\Http\Request;

class ApiMembershipController extends Controller
{
    public function list(Request $request, MembershipRepository $membershipRepository)
    {
        return $membershipRepository->findPaginated($request);
    }
}

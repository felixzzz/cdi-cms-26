<?php

namespace App\Http\Controllers\Api;

use App\Enums\InvestorReportType;
use App\Http\Controllers\Controller;
use App\Repositories\Investor\InvestorReportRepository;
use Illuminate\Http\Request;

class ApiInvestorController extends Controller
{
    public function prospectusList(Request $request, InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->findPaginated($request, InvestorReportType::Prospectus);
    }

    public function gmsList(Request $request, InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->findPaginated($request, InvestorReportType::GMS);
    }

    public function earningsList(Request $request, InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->findPaginated($request, InvestorReportType::EarningsUpdate);
    }

    public function disclosureList(Request $request, InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->findPaginated($request, InvestorReportType::Disclosure);
    }

    public function investorList(Request $request, InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->findPaginated($request, InvestorReportType::InvestorUpdate);
    }

    public function calendarList(Request $request, InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->findPaginatedCalendar($request);
    }

    public function years(InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->years();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Enums\RatingRecognitionType;
use App\Http\Controllers\Controller;
use App\Repositories\Sustainability\ResponsibleRepository;
use App\Repositories\Sustainability\SustainabilityContentRepository;
use App\Repositories\Sustainability\SustainabilityReportRepository;
use App\Repositories\Sustainability\SustainabilityTabRepository;
use App\Repositories\Utility\RatingRecognitionRepository;
use Illuminate\Http\Request;

class ApiSustainabilityController extends Controller
{
    public function ratings(RatingRecognitionRepository $ratingRecognitionRepository)
    {
        return $ratingRecognitionRepository->getByCategory(RatingRecognitionType::Rating);
    }

    public function recognitions(RatingRecognitionRepository $ratingRecognitionRepository)
    {
        return $ratingRecognitionRepository->getByCategory(RatingRecognitionType::Recognition);
    }

    public function responsibles(ResponsibleRepository $responsibleRepository)
    {
        return $responsibleRepository->list();
    }

    public function tabContents(SustainabilityTabRepository $sustainabilityTabRepository, $type)
    {
        return $sustainabilityTabRepository->detail($type);
    }

    public function contents(SustainabilityContentRepository $sustainabilityContentRepository, $type)
    {
        return $sustainabilityContentRepository->detail($type);
    }

    public function reports(Request $request, SustainabilityReportRepository $sustainabilityReportRepository, $type)
    {
        return $sustainabilityReportRepository->findPaginated($request, $type);
    }
}

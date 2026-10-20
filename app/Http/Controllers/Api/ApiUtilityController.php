<?php

namespace App\Http\Controllers\Api;

use App\Enums\PreferenceKey;
use App\Enums\QuickLinkCategory;
use App\Enums\TopicType;
use App\Helpers\LlmsDefaultContent;
use App\Http\Controllers\Controller;
use App\Repositories\AboutUs\MilestoneRepository;
use App\Repositories\AboutUs\OurHistoryRepository;
use App\Repositories\Article\ArticleCategoryRepository;
use App\Repositories\Data\OfficeRepository;
use App\Repositories\Data\TeamRepository;
use App\Repositories\Governance\GovernanceCommitteRepository;
use App\Repositories\Investor\InvestorReportRepository;
use App\Repositories\Utility\CountryRepository;
use App\Repositories\Utility\FileRepository;
use App\Repositories\Utility\PreferenceRepository;
use App\Repositories\Utility\QuickLinkRepository;
use App\Repositories\Utility\TopicRepository;
use Illuminate\Http\Request;

class ApiUtilityController extends Controller
{
    public function home(PreferenceRepository $preferenceRepository)
    {
        return $preferenceRepository->getAllContentPage("home");
    }

    public function socialMedia(PreferenceRepository $preferenceRepository)
    {
        return $preferenceRepository->getAllContentPage("", PreferenceKey::getOtherKeys());
    }

    public function governance(PreferenceRepository $preferenceRepository)
    {
        return $preferenceRepository->getAllContentPage("", PreferenceKey::getAllGovernanceKey());
    }

    public function aboutUs(PreferenceRepository $preferenceRepository, $type)
    {
        return $preferenceRepository->getAllContentPage("", PreferenceKey::getAllAboutUsKey($type));
    }

    public function investor(PreferenceRepository $preferenceRepository)
    {
        return $preferenceRepository->getAllContentPage("", PreferenceKey::getAllInvestorKey());
    }

    public function ourBusiness(PreferenceRepository $preferenceRepository)
    {
        return $preferenceRepository->getAllContentPage("", PreferenceKey::getAllOurBusinessKey());
    }

    public function sustainability(PreferenceRepository $preferenceRepository, $type)
    {
        return $preferenceRepository->getAllContentPage("", PreferenceKey::getSustainabilityKey($type));
    }

    public function milestones(MilestoneRepository $milestoneRepository)
    {
        return $milestoneRepository->get();
    }

    public function ourHistories(OurHistoryRepository $ourHistoryRepository)
    {
        return $ourHistoryRepository->get();
    }

    public function quickLink(QuickLinkRepository $quickLinkRepository, $type)
    {
        $category = QuickLinkCategory::Home;
        switch ($type) {
            case 'home':
                $category = QuickLinkCategory::Home;
                break;
            case 'governance':
                $category = QuickLinkCategory::Governance;
                break;
            case 'about-us':
                $category = QuickLinkCategory::AboutUs;
                break;

            default:
                return [];
                break;
        }
        return $quickLinkRepository->getByCategory($category);
    }

    public function additionalPage(PreferenceRepository $preferenceRepository, $type)
    {
        return $preferenceRepository->find(str_replace('-', '_', $type));
    }

    public function additionalFile(FileRepository $fileRepository, $type)
    {
        return $fileRepository->getByType($type);
    }

    public function teams(TeamRepository $teamRepository, $type)
    {
        return $teamRepository->get($type);
    }

    public function latestReports(InvestorReportRepository $investorReportRepository)
    {
        return $investorReportRepository->latestReport();
    }

    public function mainOffice(OfficeRepository $officeRepository)
    {
        return $officeRepository->getMain();
    }

    public function otherOffices(OfficeRepository $officeRepository)
    {
        return $officeRepository->getOthers();
    }

    public function categories(ArticleCategoryRepository $articleCategoryRepository)
    {
        return $articleCategoryRepository->list("created_at");
    }

    public function countries(CountryRepository $countryRepository)
    {
        return $countryRepository->list();
    }

    public function contactUsTopics(TopicRepository $topicRepository)
    {
        return $topicRepository->list(TopicType::ContactUs);
    }

    public function whistleblowingTopics(TopicRepository $topicRepository)
    {
        return $topicRepository->list(TopicType::Whistleblowing);
    }

    public function governanceCommittes(GovernanceCommitteRepository $governanceCommitteRepository)
    {
        return $governanceCommitteRepository->list();
    }

    public function hasGovernanceCommittes(GovernanceCommitteRepository $governanceCommitteRepository)
    {
        return $governanceCommitteRepository->check();
    }

    public function llms(PreferenceRepository $preferenceRepository)
    {
        $llmsTxt = $preferenceRepository->find(PreferenceKey::llms_txt->value);
        $llmsFullTxt = $preferenceRepository->find(PreferenceKey::llms_full_txt->value);

        return response()->json([
            'llms_txt' => ($llmsTxt && filled($llmsTxt->content_en)) ? $llmsTxt->content_en : LlmsDefaultContent::llmsTxt(),
            'llms_full_txt' => ($llmsFullTxt && filled($llmsFullTxt->content_en)) ? $llmsFullTxt->content_en : LlmsDefaultContent::llmsFullTxt(),
            'raw' => [
                'llms_txt' => $llmsTxt,
                'llms_full_txt' => $llmsFullTxt,
            ],
        ]);
    }

    public function seoMetadata(PreferenceRepository $preferenceRepository)
    {
        return response()->json($preferenceRepository->getAllContentPage("", PreferenceKey::getSeoMetaKeys()));
    }
}

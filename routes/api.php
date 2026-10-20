<?php

use App\Http\Controllers\Api\ApiArticleController;
use App\Http\Controllers\Api\ApiAwardController;
use App\Http\Controllers\Api\ApiCertificateController;
use App\Http\Controllers\Api\ApiGovernanceController;
use App\Http\Controllers\Api\ApiInstitutionController;
use App\Http\Controllers\Api\ApiInvestorController;
use App\Http\Controllers\Api\ApiMembershipController;
use App\Http\Controllers\Api\ApiOurBusinessController;
use App\Http\Controllers\Api\ApiPressReleaseController;
use App\Http\Controllers\Api\ApiSubmissionController;
use App\Http\Controllers\Api\ApiSustainabilityController;
use App\Http\Controllers\Api\ApiUtilityController;
use Illuminate\Support\Facades\Route;

// Rate-limited form submissions
Route::post('contact-us/store', [ApiSubmissionController::class, 'storeContactUs'])
    ->middleware('throttle:10,1')
    ->name('contact-us.storeContacUsApi');

Route::post('governance/whistleblowing/store', [ApiSubmissionController::class, 'storeWhistleblowing'])
    ->middleware('throttle:10,1')
    ->name('governance.apiWhistleblowingStore');

// Read-only CMS API endpoints
Route::as('api.')->group(function () {
    Route::controller(ApiUtilityController::class)
        ->as('utility.')
        ->prefix('utility')
        ->group(function () {
            Route::get('/home', 'home')->name('home');
            Route::get('/social-media', 'socialMedia')->name('social-media');
            Route::get('/governance', 'governance')->name('governance');
            Route::get('/investor', 'investor')->name('investor');
            Route::get('/our-business', 'ourBusiness')->name('our-business');
            Route::get('/about-us/{type}', 'aboutUs')->name('about-us.index')->whereIn('type', ['award', 'management', 'who-we-are']);
            Route::get('/sustainability/{type}', 'sustainability')->name('sustainability.index')->whereIn('type', ['overview', 'environment', 'social', 'governance', 'report', 'action']);
            Route::get('/quick-link/{type}', 'quickLink')->name('quick-link')->whereIn('type', ['home', 'governance', 'about-us']);

            Route::get('/our-histories', 'ourHistories')->name('our-histories');
            Route::get('/milestones', 'milestones')->name('milestones');
            Route::get('/latest-reports', 'latestReports')->name('latest-reports');
            Route::get('/main-office', 'mainOffice')->name('main-office');
            Route::get('/other-offices', 'otherOffices')->name('other-offices');
            Route::get('/categories', 'categories')->name('categories');
            Route::get('/countries', 'countries')->name('countries');
            Route::get('/whistleblowing-topics', 'whistleblowingTopics')->name('whistleblowing-topics');
            Route::get('/contact-us-topics', 'contactUsTopics')->name('contact-us-topics');
            Route::get('/governance-committes', 'governanceCommittes')->name('governance-committes');
            Route::get('/has-governance-committes', 'hasGovernanceCommittes')->name('has-governance-committes');

            Route::get('/additional-page/{type}', 'additionalPage')->name('additional-page');
            Route::get('/additional-file/{type}', 'additionalFile')->name('additional-file');
            Route::get('/teams/{type}', 'teams')->name('teams');
            Route::get('/llms', 'llms')->name('llms');
            Route::get('/seo-metadata', 'seoMetadata')->name('seo-metadata');
        });

    Route::get('press-releases/list', [ApiPressReleaseController::class, 'list'])->name('press-releases.list');

    Route::controller(ApiArticleController::class)
        ->as('article.')
        ->prefix('article')
        ->group(function () {
            Route::get('blog-status', 'blogStatus')->name('blog-status');
            Route::get('list/{type}', 'list')->name('list');
            Route::get('detail/{type}/{slug}', 'detail')->name('detail');
            Route::get('list-sustainability', 'listSustainability')->name('list-sustainability');
            Route::get('latest', 'latest')->name('latest');
            Route::get('latest-media', 'latestMedia')->name('latest-media');
            Route::get('latest-sustainability', 'latestSustainability')->name('latest-sustainability');
            Route::get('relates/{ulid}', 'relates')->name('relates');
        });

    Route::controller(ApiAwardController::class)
        ->as('awards.')
        ->prefix('awards')
        ->group(function () {
            Route::get('list', 'list')->name('list');
            Route::get('years', 'years')->name('years');
        });

    Route::controller(ApiCertificateController::class)
        ->as('certificates.')
        ->prefix('certificates')
        ->group(function () {
            Route::get('list', 'list')->name('list');
        });

    Route::get('memberships/list', [ApiMembershipController::class, 'list'])->name('memberships.list');

    Route::controller(ApiOurBusinessController::class)
        ->as('business.')
        ->prefix('business')
        ->group(function () {
            Route::get('overview-list', 'overviewList')->name('overview-list');
            Route::get('detail/{type}', 'detail')->name('detail');
        });

    Route::controller(ApiInvestorController::class)
        ->as('investor.')
        ->prefix('investor')
        ->group(function () {
            Route::get('prospectus/list', 'prospectusList')->name('prospectus.list');
            Route::get('gms/list', 'gmsList')->name('gms.list');
            Route::get('earnings/list', 'earningsList')->name('earnings.list');
            Route::get('disclosure/list', 'disclosureList')->name('disclosure.list');
            Route::get('investor-update/list', 'investorList')->name('investor.list');
            Route::get('calendar/list', 'calendarList')->name('calendar.list');
            Route::get('calendar/years', 'years')->name('calendar.years');
        });

    Route::get('institutions/list', [ApiInstitutionController::class, 'list'])->name('institutions.list');
    Route::get('governances/files/{type}', [ApiGovernanceController::class, 'files'])
        ->name('governances.files')
        ->whereIn('type', ['policy', 'code-of-conduct', 'she-regulation', 'risk-management']);

    Route::controller(ApiSustainabilityController::class)
        ->as('sustainability.')
        ->prefix('sustainability')
        ->group(function () {
            Route::get('ratings', 'ratings')->name('ratings');
            Route::get('recognitions', 'recognitions')->name('recognitions');
            Route::get('responsibles', 'responsibles')->name('responsibles');
            Route::get('tab-contents/{type}', 'tabContents')->name('tab-contents');
            Route::get('contents/{type}', 'contents')->name('contents');
            Route::get('reports/{type}', 'reports')->name('reports');
        });
});

<?php

use App\Helpers\LlmsDefaultContent;
use App\Http\Controllers\FileStorageController;
use App\Repositories\Utility\PreferenceRepository;
use Illuminate\Support\Facades\Route;

// Redirect root to Filament Admin
Route::get('/', function () {
    return redirect('/admin');
})->name('home');

// Legacy Named Web Routes (for route() helper compatibility in repositories/models)
Route::get('/contact-us', fn () => redirect('/admin'))->name('contact-us');

Route::prefix('governance')->as('governance.')->group(function () {
    Route::get('/', fn () => redirect('/admin'))->name('index');
    Route::get('/whistleblowing', fn () => redirect('/admin'))->name('whistleblowing');
    Route::get('/{type}', fn () => redirect('/admin'))->name('type');
});

Route::prefix('media')->as('media.')->group(function () {
    Route::get('/{type}', fn () => redirect('/admin'))->name('index');
    Route::get('/{type}/{id}', fn () => redirect('/admin'))->name('detail');
});

Route::prefix('investor')->as('investor.')->group(function () {
    Route::get('/report', fn () => redirect('/admin'))->name('report');
    Route::get('/financial-information', fn () => redirect('/admin'))->name('financial-information');
    Route::get('/shares-information', fn () => redirect('/admin'))->name('shares-information');
    Route::get('/publications-for-investors', fn () => redirect('/admin'))->name('publications-for-investors');
});

Route::prefix('about-us')->as('about-us.')->group(function () {
    Route::get('/', fn () => redirect('/admin'))->name('who-we-are');
    Route::get('/awards', fn () => redirect('/admin'))->name('awards');
    Route::get('/management', fn () => redirect('/admin'))->name('management');
    Route::get('/management/team/{team}', fn () => redirect('/admin'))->name('team');
});

Route::prefix('our-business')->as('our-business.')->group(function () {
    Route::get('/', fn () => redirect('/admin'))->name('what-we-do');
    Route::get('/logistics', fn () => redirect('/admin'))->name('logistics');
    Route::get('/water', fn () => redirect('/admin'))->name('water');
    Route::get('/power', fn () => redirect('/admin'))->name('power');
    Route::get('/energy', fn () => redirect('/admin'))->name('energy');
    Route::get('/ports-and-storage', fn () => redirect('/admin'))->name('ports-and-storage');
});

Route::prefix('sustainability')->as('sustainability.')->group(function () {
    Route::get('/', fn () => redirect('/admin'))->name('overview');
    Route::get('/sustainability-in-action', fn () => redirect('/admin'))->name('sustainability-in-action');
    Route::get('/report-and-publication', fn () => redirect('/admin'))->name('report-and-publication');
    Route::get('/environment', fn () => redirect('/admin'))->name('environment');
    Route::get('/social', fn () => redirect('/admin'))->name('social');
    Route::get('/governance', fn () => redirect('/admin'))->name('governance');
});

Route::get('/privacy-policy', fn () => redirect('/admin'))->name('privacy-policy');
Route::get('/cookies-notice', fn () => redirect('/admin'))->name('cookies-notice');
Route::get('/terms-and-conditions', fn () => redirect('/admin'))->name('terms-and-conditions');
Route::get('/disclaimer', fn () => redirect('/admin'))->name('disclaimer');
Route::get('/switch-lang/{locale}', fn () => redirect('/admin'))->name('switch-lang');

// File delivery routes for media and documents
Route::get('/file-storage/{file?}', [FileStorageController::class, 'preview'])->name('preview.storage');
Route::get('/file-download/{file?}', [FileStorageController::class, 'download'])->name('preview.download');
Route::get('/file/preview/{lang?}/{type?}/{key?}/{name?}', [FileStorageController::class, 'filePreview'])->name('file.preview');
Route::get('/file/download/{lang?}/{type?}/{key?}/{name?}', [FileStorageController::class, 'fileDownload'])->name('file.download');

// LLMS discovery endpoints
Route::get('/llms.txt', function (PreferenceRepository $preferenceRepository) {
    $pref = $preferenceRepository->find(\App\Enums\PreferenceKey::llms_txt->value);
    $content = ($pref && filled($pref->content_en)) ? $pref->content_en : LlmsDefaultContent::llmsTxt();

    return response($content, 200)->header('Content-Type', 'text/plain; charset=utf-8');
})->name('llms.txt');

Route::get('/llms-full.txt', function (PreferenceRepository $preferenceRepository) {
    $pref = $preferenceRepository->find(\App\Enums\PreferenceKey::llms_full_txt->value);
    $content = ($pref && filled($pref->content_en)) ? $pref->content_en : LlmsDefaultContent::llmsFullTxt();

    return response($content, 200)->header('Content-Type', 'text/plain; charset=utf-8');
})->name('llms-full.txt');

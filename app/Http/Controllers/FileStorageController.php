<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\StorageFile;
use Illuminate\Http\Request;
use App\Models\Article\PressRelease;
use App\Models\Utility\AdditionalFile;
use App\Models\Investor\InvestorReport;
use App\Models\Governance\GovernanceCommitte;
use App\Models\Sustainability\SustainabilityContent;
use App\Repositories\Investor\InvestorReportRepository;

class FileStorageController extends Controller
{
    public function preview(Request $request, $file)
    {
        if (!$file) return null;
        try {
            $file = str_replace(['.webp', '.webm', '.mp4'], '', $file);
            $file = Helper::shortDecrypt($file);
            return StorageFile::preview($file);
        } catch (\Exception $e) {
        }
        return null;
    }

    public function download(Request $request, $file)
    {
        if (!$file) return null;
        try {
            $file = str_replace(['.webp', '.webm', '.mp4'], '', $file);
            $file = Helper::shortDecrypt($file);
            return StorageFile::download($file);
        } catch (\Exception $e) {
        }
        return null;
    }

    public function filePreview($lang = 'default', $type = null, $key = null)
    {
        try {
            if ($type == 'report') {
                $row = InvestorReport::where('ulid', $key)->first();
                if ($lang !=  'default') {
                    $file = $lang == 'id' ? $row->file_id : $row->file_en;
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $file = json_decode($row->file);
                    $file = Helper::shortDecrypt($file->path);
                }
                return StorageFile::preview($file);
            } else if ($type == 'press-release') {
                $row = PressRelease::where('ulid', $key)->first();
                if ($lang !=  'default') {
                    $file = $lang == 'id' ? $row->file_id : $row->file_en;
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $file = json_decode($row->file);
                    $file = Helper::shortDecrypt($file->path);
                }
                return StorageFile::preview($file);
            } else if ($type == 'committe') {
                if ($lang !=  'default') {
                    $field = $lang == 'en' ? 'tab_title_en' : 'tab_title_id';
                    $row = GovernanceCommitte::where($field, $key)->first();
                    $file = $row->file;
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $field = app()->currentLocale() == 'en' ? 'tab_title_en' : 'tab_title_id';
                    $row = GovernanceCommitte::where($field, $key)->first();
                    $file = $row->file;
                    $file = Helper::shortDecrypt($file['path']);
                }
                return StorageFile::preview($file);
            } else if ($type == 'sustainability-content') {
                $row = SustainabilityContent::where('ulid', $key)->first();
                if ($lang !=  'default') {
                    $file = $lang == 'id' ? $row->file_information_id : $row->file_information_en;
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $file = json_decode($row->file_information);
                    $file = Helper::shortDecrypt($file->path);
                }
                return StorageFile::preview($file);
            } else {
                $row = AdditionalFile::where("type", $type)->where("unique_key", $key)->first();
                if ($lang !=  'default') {
                    $file = $lang == 'id' ? $row->file_id : $row->file_en;
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $file = json_decode($row->file);
                    $file = Helper::shortDecrypt($file->path);
                }
                return StorageFile::preview($file);
            }
        } catch (\Exception $e) {
        }
        return null;
    }

    public function fileDownload($lang = 'default', $type = null, $key = null)
    {
        try {
            $fileName = null;
            if ($type == 'report') {
                if ($key == 'all') {
                    return (new InvestorReportRepository())->downloadAllNewestReport();
                }
                $row = InvestorReport::where('ulid', $key)->first();
                if ($lang !=  'default') {
                    $file = $lang == 'id' ? $row->file_id : $row->file_en;
                    $file = Helper::shortDecrypt($file['path']);
                    $fileName = $lang == 'id' ? $row->name_id : $row->name_en;
                } else {
                    $file = json_decode($row->file);
                    $file = Helper::shortDecrypt($file->path);
                    $fileName = $row->name;
                }
            } else if ($type == 'press-release') {
                $row = PressRelease::where('ulid', $key)->first();
                if ($lang !=  'default') {
                    $file = $lang == 'id' ? $row->file_id : $row->file_en;
                    $file = Helper::shortDecrypt($file['path']);
                    $fileName = $lang == 'id' ? $row->name_id : $row->name_en;
                } else {
                    $file = json_decode($row->file);
                    $file = Helper::shortDecrypt($file->path);
                    $fileName = $row->name;
                }
            } else if ($type == 'committe') {
                if ($lang !=  'default') {
                    $field = $lang == 'en' ? 'tab_title_en' : 'tab_title_id';
                    $row = GovernanceCommitte::where($field, $key)->first();
                    $file = $row->file;
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $field = app()->currentLocale() == 'en' ? 'tab_title_en' : 'tab_title_id';
                    $row = GovernanceCommitte::where($field, $key)->first();
                    $file = $row->file;
                    $file = Helper::shortDecrypt($file['path']);
                }
                $fileName = $key;
            } else if ($type == 'sustainability-content') {
                $row = SustainabilityContent::where('ulid', $key)->first();
                if ($lang !=  'default') {
                    $file = $lang == 'id' ? $row->file_information_id : $row->file_information_en;
                    $fileName = $file['title'];
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $file = json_decode($row->file_information);
                    $fileName = $file->title;
                    $file = Helper::shortDecrypt($file->path);
                }
            } else {
                $row = AdditionalFile::where("type", $type)->where("unique_key", $key)->first();
                if ($lang !=  'default') {
                    $fileName = $lang == 'id' ? $row->name_id : $row->name_en;
                    $file = $lang == 'id' ? $row->file_id : $row->file_en;
                    $file = Helper::shortDecrypt($file['path']);
                } else {
                    $fileName = $row->name;
                    $file = json_decode($row->file);
                    $file = Helper::shortDecrypt($file->path);
                }
            }
            return StorageFile::download($file, $fileName);
        } catch (\Exception $e) {
        }
        return null;
    }
}

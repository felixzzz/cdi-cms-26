<?php

namespace App\Actions\AboutUs;

use App\Helpers\Helper;
use App\Helpers\StorageFile;
use App\Models\AboutUs\Certificate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AboutUs\CertificateRequest;

class CertificateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(CertificateRequest $request){
        $data = [
            ...$request->only([
                'certificate_category_id',
                'name_en',
                'name_id',
                'content_en',
                'content_id',
                'awarder_en',
                'awarder_id',
                'date'
            ])
        ];

        if ($request->hasFile('files')) {
            $data['files'] = [];

            foreach ($request->file('files') as $file) {
                $data['files'][] = StorageFile::upload($file, 'aboutus/certificates');
            }
        }

        return Certificate::create($data);
    }

    public function update(CertificateRequest $request, $ulid)
    {
        $certificate = Certificate::whereUlid($ulid)->firstOrFail();

        $data = $request->only([
            'certificate_category_id',
            'name_en',
            'name_id',
            'content_en',
            'content_id',
            'awarder_en',
            'awarder_id',
            'date'
        ]);

        if ($request->hasFile('files')) {
            $data['files'] = $certificate->files ?? [];
            foreach ($request->file('files') as $file) {
                $data['files'][] = StorageFile::upload($file, 'aboutus/certificates');
            }
        }

        return $certificate->update($data);
    }


    public function delete($ulid){
        return Certificate::where('ulid', $ulid)->delete();
    }

    public function deleteImage($request)
    {
        $filePath = $request->file;
        $filePath = Helper::shortDecrypt($filePath);

        $certificate = Certificate::whereUlid($request->ulid)->firstOrFail();

        $files = [];

        foreach ($certificate->files ?? [] as $key => $value) {
            if ($value != $request->file) {
                $files[] = $value;
            }
        }

        $certificate->update(['files' => $files]);

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            return true;
        }

        return false;
    }
}

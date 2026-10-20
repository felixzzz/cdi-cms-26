<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class StorageFile
{
    public static function upload($file, $location = "")
    {
        if (!$file) {
            return null;
        }

        $maxSize = 7 * 1024 * 1024; // 8388608 bytes
        if ($file->getSize() > $maxSize) {
            throw new \Exception('Ukuran file tidak boleh lebih dari 8MB');
        }

        $mimeType = $file->getMimeType();
        $allowedMimeTypes = [
            // Image
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml',
            'image/bmp',
            'image/tiff',
            'image/x-icon',

            // Video
            'video/mp4',
            'video/mpeg',
            'video/ogg',
            'video/webm',
            'video/x-msvideo', // AVI
            'video/quicktime', // MOV
            'video/x-ms-wmv',  // WMV
            'video/3gpp',
            'video/3gpp2',

            // Document
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
        ];

        if (!in_array($mimeType, $allowedMimeTypes)) {
            throw new \Exception('Invalid file type');
        }

        $name = $file->getClientOriginalName();
        if (str_contains($name, '.php')) {
            throw new \Exception('Invalid file type');
        }

        $extension = "." . $file->getClientOriginalExtension();
        $filename = Str::slug(str_replace($extension, "", $name)) . Str::random() . $extension;
        $fileUrl = Storage::disk('local')->putFileAs("{$location}", $file, $filename);


        return Helper::shortEncrypt($fileUrl);
    }

    public static function uploadWithDetails($file, $location = "")
    {
        if (!$file) {
            return null;
        }

        $maxSize = 7 * 1024 * 1024;
        if ($file->getSize() > $maxSize) {
            throw new \Exception('Ukuran file tidak boleh lebih dari 8MB');
        }

        $mimeType = $file->getMimeType();
        $allowedMimeTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp',
            'video/webm',
            'video/mp4',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
        ];

        if (!in_array($mimeType, $allowedMimeTypes)) {
            throw new \Exception('Invalid file type');
        }

        $name = $file->getClientOriginalName();
        if (str_contains($name, '.php')) {
            throw new \Exception('Invalid file type');
        }

        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(pathinfo($name, PATHINFO_FILENAME)) . Str::random() . '.' . $extension;
        $filePath = Storage::disk('local')->putFileAs("{$location}", $file, $filename);
        $fileSize = self::formatSize($file->getSize());

        return [
            'path' => Helper::shortEncrypt($filePath),
            'size' => $fileSize,
            'format' => $extension,
        ];
    }

    //    public static function preview($filename)
    //    {
    //        $disk = 'local';
    //        $cacheTime = 31536000; // 1 tahun
    //
    //        $mimeType = Cache::remember("file_mime_cache_{$filename}", $cacheTime, function () use ($disk, $filename) {
    //            return Storage::disk($disk)->mimeType($filename);
    //        });
    //
    //        $fileBase64 = Cache::remember("file_cache_{$filename}", $cacheTime, function () use ($disk, $filename) {
    //            if (Storage::disk($disk)->exists($filename)) {
    //                $content = Storage::disk($disk)->get($filename);
    //                return base64_encode($content); // Encode binary data
    //            }
    //            return null;
    //        });
    //
    //        if (!$fileBase64) {
    //            abort(404);
    //        }
    //
    //        $fileContent = base64_decode($fileBase64); // Decode to binary
    //
    //        // Ubah ke WebP jika format image (selain SVG)
    //        if (str_contains($mimeType, 'image/') && $mimeType != 'image/svg+xml') {
    //            $mimeType = 'image/webp';
    //        }
    //
    //        $filenames = explode('/', $filename);
    //        $fileName = @$filenames[count($filenames) - 1];
    //
    //        return response($fileContent)
    //            ->withHeaders([
    //                'Content-Type' => $mimeType,
    //                'Cache-Control' => "public, max-age=$cacheTime, immutable",
    //                'Content-disposition' => 'filename="' . $fileName . '"'
    //            ]);
    //    }

    public static function preview($filename)
    {
        $disk = 'local';

        if (!Storage::disk($disk)->exists($filename)) {
            abort(404);
        }

        $mimeType = Storage::disk($disk)->mimeType($filename) ?? 'application/octet-stream';

        $fullPath = Storage::disk($disk)->path($filename);
        $size = Storage::disk($disk)->size($filename);
        $filenames = explode('/', $filename);
        $fileName = end($filenames);

        return response()->stream(function () use ($fullPath) {
            $stream = fopen($fullPath, 'rb');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes', // Wajib untuk video player (seek/forward)
            'Cache-Control' => "public, max-age=86400, immutable",
            // Gunakan 'inline' agar video terputar di browser, bukan langsung otomatis ter-download
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }


    //    public static function preview($filename)
    //    {
    //        $disk = 'local';
    //        $path = ltrim($filename, '/');
    //
    //        if (!Storage::disk($disk)->exists($path)) {
    //            abort(404);
    //        }
    //
    //        $mime = Storage::disk($disk)->mimeType($path) ?? 'video/mp4';
    //        $fullPath = Storage::disk($disk)->path($path);
    //        $size = Storage::disk($disk)->size($path);
    //
    //        return response()->stream(function () use ($fullPath) {
    //            $stream = fopen($fullPath, 'rb');
    //            fpassthru($stream);
    //            fclose($stream);
    //        }, 200, [
    //            'Content-Type' => $mime,
    //            'Content-Length' => $size,
    //            'Accept-Ranges' => 'bytes',
    //            'Cache-Control' => 'public, max-age=86400',
    //            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
    //        ]);
    //
    ////        return response($fileContent)
    ////            ->withHeaders([
    ////                'Content-Type' => $mimeType,
    ////                'Cache-Control' => "public, max-age=$cacheTime, immutable",
    ////                'Content-disposition' => 'filename="' . $fileName . '"'
    ////            ]);
    //    }

    public static function download($filename, $downloadName = null)
    {
        $disk = 'local';

        // Periksa apakah file ada
        if (!Storage::disk($disk)->exists($filename)) {
            abort(404);
        }

        $mimeType = Storage::disk($disk)->mimeType($filename);

        $randomFileName = uniqid('file_', true);

        $downloadFileName = ($downloadName ?? $randomFileName) . '.' . pathinfo($filename, PATHINFO_EXTENSION);


        return response()->download(Storage::disk($disk)->path($filename), $downloadFileName, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000, immutable'
        ]);
    }

    private static function formatSize($size)
    {
        if ($size >= 1048576) { // Lebih dari 1MB
            return round($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) { // Lebih dari 1KB
            return round($size / 1024, 2) . ' KB';
        }
        return $size . ' B'; // Dalam byte
    }
}

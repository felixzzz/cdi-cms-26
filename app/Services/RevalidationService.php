<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RevalidationService
{
    /**
     * Trigger revalidation on the Next.js frontend and clear backend Optimize cache.
     */
    public static function revalidate(?string $tag = null, ?string $path = null, string $type = 'layout'): bool
    {
        // 1. Clear backend cache so fresh API calls get latest data
        try {
            Cache::flush();
        } catch (\Throwable $e) {
            Log::warning('Failed to flush Laravel cache during revalidation: ' . $e->getMessage());
        }

        // 2. Call Next.js ISR Revalidation endpoint
        $baseUrl = rtrim(config('services.nextjs.url'), '/');
        $secret = config('services.nextjs.revalidate_secret');

        if (empty($baseUrl) || empty($secret)) {
            Log::info('Revalidation skipped: NEXTJS_FRONTEND_URL or REVALIDATION_SECRET_TOKEN is not configured.');
            return false;
        }

        try {
            $payload = array_filter([
                'tag' => $tag,
                'path' => $path,
                'type' => $type,
            ]);

            $response = Http::timeout(4)
                ->withHeaders([
                    'x-revalidate-secret' => $secret,
                    'Content-Type' => 'application/json',
                ])
                ->post("{$baseUrl}/api/revalidate", $payload);

            if ($response->successful()) {
                Log::info('Next.js ISR revalidation successful', [
                    'payload' => $payload,
                    'response' => $response->json(),
                ]);
                return true;
            }

            Log::warning('Next.js ISR revalidation returned non-200 status', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::warning('Next.js ISR revalidation connection failed: ' . $e->getMessage(), [
                'target' => "{$baseUrl}/api/revalidate",
            ]);
            return false;
        }
    }

    /**
     * Trigger global revalidation of all layout and CMS data.
     */
    public static function revalidateAll(): bool
    {
        return self::revalidate(tag: null, path: 'all', type: 'layout');
    }

    /**
     * Revalidate specific Next.js tag.
     */
    public static function revalidateTag(string $tag): bool
    {
        return self::revalidate(tag: $tag);
    }

    /**
     * Revalidate specific Next.js page or layout path.
     */
    public static function revalidatePath(string $path, string $type = 'layout'): bool
    {
        return self::revalidate(path: $path, type: $type);
    }
}

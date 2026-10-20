<?php

namespace Tests\Feature;

use App\Models\Utility\Preference;
use App\Services\RevalidationService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RevalidationTest extends TestCase
{
    public function test_revalidation_service_sends_correct_payload(): void
    {
        Http::fake([
            'http://localhost:3000/api/revalidate' => Http::response(['revalidated' => true], 200),
        ]);

        $result = RevalidationService::revalidate(tag: 'cms-data', path: '/media/news');

        $this->assertTrue($result);

        Http::assertSent(function ($request) {
            return $request->url() === 'http://localhost:3000/api/revalidate'
                && $request->hasHeader('x-revalidate-secret', 'cdi-revalidate-secret-token-2026')
                && $request['tag'] === 'cms-data'
                && $request['path'] === '/media/news';
        });
    }

    public function test_content_save_triggers_revalidation_observer(): void
    {
        Http::fake([
            'http://localhost:3000/api/revalidate' => Http::response(['revalidated' => true], 200),
        ]);

        $preference = Preference::first();
        $this->assertNotNull($preference, 'Expected at least one preference in seeded DB');

        $preference->touch();

        Http::assertSent(function ($request) {
            return $request->url() === 'http://localhost:3000/api/revalidate'
                && $request->hasHeader('x-revalidate-secret', 'cdi-revalidate-secret-token-2026');
        });
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    public function test_root_redirects_to_admin(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/admin');
    }

    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_utility_home_endpoint_returns_json(): void
    {
        $response = $this->withHeaders(['lang' => 'en'])->getJson('/api/utility/home');
        $response->assertStatus(200);
        $this->assertIsObject(json_decode($response->getContent()));
    }

    public function test_utility_governance_endpoint_returns_json(): void
    {
        $response = $this->withHeaders(['lang' => 'id'])->getJson('/api/utility/governance');
        $response->assertStatus(200);
    }

    public function test_article_latest_endpoint(): void
    {
        $response = $this->getJson('/api/article/latest?category_id=all');
        $response->assertStatus(200);
        $response->assertJsonStructure([]);
    }

    public function test_business_overview_list(): void
    {
        $response = $this->getJson('/api/business/overview-list');
        $response->assertStatus(200);
    }

    public function test_investor_latest_reports(): void
    {
        $response = $this->getJson('/api/utility/latest-reports');
        $response->assertStatus(200);
    }

    public function test_seo_metadata_endpoint(): void
    {
        $response = $this->getJson('/api/utility/seo-metadata');
        $response->assertStatus(200);
    }

    public function test_llms_txt_endpoints(): void
    {
        $response = $this->get('/llms.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=utf-8');

        $responseFull = $this->get('/llms-full.txt');
        $responseFull->assertStatus(200);
        $responseFull->assertHeader('Content-Type', 'text/plain; charset=utf-8');
    }
}

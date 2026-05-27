<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_can_be_rendered(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }

    public function test_about_page_returns_correct_view(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertViewIs('about');
    }
}

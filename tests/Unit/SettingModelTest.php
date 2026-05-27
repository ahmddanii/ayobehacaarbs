<?php

namespace Tests\Unit;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_uses_guarded_empty_array(): void
    {
        $setting = new Setting();

        $this->assertEquals([], $setting->getGuarded());
    }

    public function test_create_default_creates_setting_with_correct_values(): void
    {
        $setting = Setting::createDefault();

        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'site_name' => 'ayo behacaar',
            'contact_email' => 'ayobehacaar@gmail.com',
        ]);

        $this->assertEquals('ayo behacaar', $setting->site_name);
        $this->assertEquals('ayobehacaar@gmail.com', $setting->contact_email);
        $this->assertNotEmpty($setting->tagline);
        $this->assertNotEmpty($setting->description);
        $this->assertNotEmpty($setting->about_text);
        $this->assertNotEmpty($setting->instagram_url);
        $this->assertNotEmpty($setting->tiktok_url);
        $this->assertNotEmpty($setting->youtube_url);
    }

    public function test_create_default_has_null_hero_images(): void
    {
        $setting = Setting::createDefault();

        $this->assertNull($setting->category_hero_image);
        $this->assertNull($setting->article_hero_image);
        $this->assertNull($setting->about_hero_image);
    }

    public function test_setting_can_be_mass_assigned(): void
    {
        $data = [
            'site_name' => 'Test Site',
            'tagline' => 'Test Tagline',
            'description' => 'Test Description',
            'about_text' => 'Test About',
            'contact_email' => 'test@example.com',
            'instagram_url' => 'https://instagram.com/test',
            'tiktok_url' => 'https://tiktok.com/@test',
            'youtube_url' => 'https://youtube.com/test',
        ];

        $setting = Setting::create($data);

        $this->assertDatabaseHas('settings', $data);
        $this->assertEquals('Test Site', $setting->site_name);
    }
}

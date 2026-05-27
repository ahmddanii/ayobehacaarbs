<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use App\Livewire\Admin\Settings\Index as AdminSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_settings_page_displays_current_settings(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->assertSet('siteName', 'ayo behacaar')
            ->assertSet('contactEmail', 'ayobehacaar@gmail.com');
    }

    public function test_settings_creates_default_if_none_exists(): void
    {
        // No settings in database yet
        $this->assertDatabaseCount('settings', 0);

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->assertSet('siteName', 'ayo behacaar');

        // Default should have been created via mount()
        $this->assertDatabaseCount('settings', 1);
    }

    public function test_can_update_settings_with_valid_data(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('siteName', 'Nama Situs Baru')
            ->set('tagline', 'Tagline Baru')
            ->set('description', 'Deskripsi baru yang sudah diupdate')
            ->set('aboutText', 'About text baru')
            ->set('contactEmail', 'new@example.com')
            ->set('instagramUrl', 'https://instagram.com/new')
            ->set('tiktokUrl', 'https://tiktok.com/@new')
            ->set('youtubeUrl', 'https://youtube.com/new')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('settings', [
            'site_name' => 'Nama Situs Baru',
            'tagline' => 'Tagline Baru',
            'contact_email' => 'new@example.com',
        ]);
    }

    public function test_update_settings_validates_required_site_name(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('siteName', '')
            ->call('save')
            ->assertHasErrors(['siteName' => 'required']);
    }

    public function test_update_settings_validates_required_tagline(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('tagline', '')
            ->call('save')
            ->assertHasErrors(['tagline' => 'required']);
    }

    public function test_update_settings_validates_required_description(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('description', '')
            ->call('save')
            ->assertHasErrors(['description' => 'required']);
    }

    public function test_update_settings_validates_required_about_text(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('aboutText', '')
            ->call('save')
            ->assertHasErrors(['aboutText' => 'required']);
    }

    public function test_update_settings_validates_required_contact_email(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('contactEmail', '')
            ->call('save')
            ->assertHasErrors(['contactEmail' => 'required']);
    }

    public function test_update_settings_validates_email_format(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('contactEmail', 'bukan-email')
            ->call('save')
            ->assertHasErrors(['contactEmail' => 'email']);
    }

    public function test_update_settings_validates_instagram_url_format(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('instagramUrl', 'bukan-url')
            ->call('save')
            ->assertHasErrors(['instagramUrl' => 'url']);
    }

    public function test_update_settings_validates_tiktok_url_format(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('tiktokUrl', 'bukan-url')
            ->call('save')
            ->assertHasErrors(['tiktokUrl' => 'url']);
    }

    public function test_update_settings_validates_youtube_url_format(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('youtubeUrl', 'bukan-url')
            ->call('save')
            ->assertHasErrors(['youtubeUrl' => 'url']);
    }

    public function test_update_settings_allows_nullable_social_urls(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('instagramUrl', '')
            ->set('tiktokUrl', '')
            ->set('youtubeUrl', '')
            ->call('save')
            ->assertHasNoErrors();
    }

    public function test_save_dispatches_success_event(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('swal:alert');
    }

    public function test_site_name_max_length_validation(): void
    {
        Setting::createDefault();

        Livewire::actingAs($this->user)
            ->test(AdminSettings::class)
            ->set('siteName', str_repeat('a', 256))
            ->call('save')
            ->assertHasErrors(['siteName' => 'max']);
    }
}

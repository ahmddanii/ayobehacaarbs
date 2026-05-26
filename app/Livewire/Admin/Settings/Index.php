<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    public int $settingId;
    public string $siteName = '';
    public string $tagline = '';
    public string $description = '';
    public string $aboutText = '';
    public string $contactEmail = '';
    public string $instagramUrl = '';
    public string $tiktokUrl = '';
    public string $youtubeUrl = '';

    public function mount()
    {
        $setting = Setting::first() ?? Setting::createDefault();
        $this->settingId = $setting->id;
        $this->siteName = $setting->site_name;
        $this->tagline = $setting->tagline;
        $this->description = $setting->description;
        $this->aboutText = $setting->about_text;
        $this->contactEmail = $setting->contact_email;
        $this->instagramUrl = $setting->instagram_url;
        $this->tiktokUrl = $setting->tiktok_url;
        $this->youtubeUrl = $setting->youtube_url;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.settings.index');
    }

    public function save()
    {
        $this->validate([
            'siteName' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'aboutText' => 'required|string',
            'contactEmail' => 'required|email|max:255',
            'instagramUrl' => 'nullable|url|max:255',
            'tiktokUrl' => 'nullable|url|max:255',
            'youtubeUrl' => 'nullable|url|max:255',
        ]);

        $setting = Setting::find($this->settingId);
        $setting->update([
            'site_name' => $this->siteName,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'about_text' => $this->aboutText,
            'contact_email' => $this->contactEmail,
            'instagram_url' => $this->instagramUrl,
            'tiktok_url' => $this->tiktokUrl,
            'youtube_url' => $this->youtubeUrl,
        ]);

        $this->dispatch('swal:alert', [
            'title' => 'Berhasil!',
            'text' => 'Pengaturan sistem berhasil diperbarui.',
            'icon' => 'success'
        ]);
    }
}

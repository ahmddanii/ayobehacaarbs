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

    // Hero cover images — now stored as URL strings (Cloudinary)
    public ?string $categoryHeroImage = null;
    public ?string $articleHeroImage = null;
    public ?string $aboutHeroImage = null;

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

        // Load existing image URLs/paths
        $this->categoryHeroImage = $setting->category_hero_image;
        $this->articleHeroImage = $setting->article_hero_image;
        $this->aboutHeroImage = $setting->about_hero_image;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.settings.index');
    }

    public function save()
    {
        $rules = [
            'siteName' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'aboutText' => 'required|string',
            'contactEmail' => 'required|email|max:255',
            'instagramUrl' => 'nullable|url|max:255',
            'tiktokUrl' => 'nullable|url|max:255',
            'youtubeUrl' => 'nullable|url|max:255',
            'categoryHeroImage' => 'nullable|url|max:2048',
            'articleHeroImage' => 'nullable|url|max:2048',
            'aboutHeroImage' => 'nullable|url|max:2048',
        ];

        $this->validate($rules);

        $setting = Setting::find($this->settingId);
        $data = [
            'site_name' => $this->siteName,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'about_text' => $this->aboutText,
            'contact_email' => $this->contactEmail,
            'instagram_url' => $this->instagramUrl,
            'tiktok_url' => $this->tiktokUrl,
            'youtube_url' => $this->youtubeUrl,
        ];

        // Store Cloudinary URLs directly
        if ($this->categoryHeroImage) {
            $data['category_hero_image'] = $this->categoryHeroImage;
        }
        if ($this->articleHeroImage) {
            $data['article_hero_image'] = $this->articleHeroImage;
        }
        if ($this->aboutHeroImage) {
            $data['about_hero_image'] = $this->aboutHeroImage;
        }

        $setting->update($data);

        // Keep local properties updated with database values
        $this->categoryHeroImage = $setting->category_hero_image;
        $this->articleHeroImage = $setting->article_hero_image;
        $this->aboutHeroImage = $setting->about_hero_image;

        $this->dispatch('swal:alert', [
            'title' => 'Berhasil!',
            'text' => 'Pengaturan sistem berhasil diperbarui.',
            'icon' => 'success'
        ]);
    }
}

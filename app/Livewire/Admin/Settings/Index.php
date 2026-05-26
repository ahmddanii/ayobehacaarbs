<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithFileUploads;

    public int $settingId;
    public string $siteName = '';
    public string $tagline = '';
    public string $description = '';
    public string $aboutText = '';
    public string $contactEmail = '';
    public string $instagramUrl = '';
    public string $tiktokUrl = '';
    public string $youtubeUrl = '';

    // Hero cover images
    public $categoryHeroImage = null;
    public $articleHeroImage = null;
    public $aboutHeroImage = null;

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

        // Load existing image paths
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
        ];

        if ($this->categoryHeroImage && !is_string($this->categoryHeroImage)) {
            $rules['categoryHeroImage'] = 'image|max:2048';
        }
        if ($this->articleHeroImage && !is_string($this->articleHeroImage)) {
            $rules['articleHeroImage'] = 'image|max:2048';
        }
        if ($this->aboutHeroImage && !is_string($this->aboutHeroImage)) {
            $rules['aboutHeroImage'] = 'image|max:2048';
        }

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

        // Store new images and update
        if ($this->categoryHeroImage && !is_string($this->categoryHeroImage)) {
            $data['category_hero_image'] = $this->categoryHeroImage->store('settings', 'public');
        }
        if ($this->articleHeroImage && !is_string($this->articleHeroImage)) {
            $data['article_hero_image'] = $this->articleHeroImage->store('settings', 'public');
        }
        if ($this->aboutHeroImage && !is_string($this->aboutHeroImage)) {
            $data['about_hero_image'] = $this->aboutHeroImage->store('settings', 'public');
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

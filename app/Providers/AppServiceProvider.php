<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (config('app.key') && Schema::hasTable('settings')) {
                $settings = Setting::first() ?? Setting::createDefault();
                view()->share('settings', $settings);
            } else {
                $this->shareFallbackSettings();
            }
        } catch (\Exception $e) {
            $this->shareFallbackSettings();
        }
    }

    protected function shareFallbackSettings(): void
    {
        view()->share('settings', new Setting([
            'site_name' => 'ayo behacaar',
            'category_hero_image' => null,
            'article_hero_image' => null,
            'about_hero_image' => null,
            'tagline' => 'Website artikel yang membahas segala hal menarik di masa kini',
            'description' => 'Ayo Behacaar hadir sebagai jembatan intelektual di era digital. Berakar dari nilai-nilai luhur budaya Kalimantan, khususnya Suku Dayak Tunjung, kami membawa semangat belajar yang inklusif dan modern kepada masyarakat luas.',
            'about_text' => 'Sebagai platform yang mengedepankan kualitas konten editorial, Ayo Behacaar berkomitmen untuk menyediakan sumber daya pembelajaran yang terkurasi. Dari literasi teknologi hingga pengembangan diri, kami merancang setiap artikel dan program kami untuk memberikan wawasan yang jernih dan dapat segera dipraktikkan.',
            'contact_email' => 'ayobehacaar@gmail.com',
            'instagram_url' => 'https://www.instagram.com/sainsaa__',
            'tiktok_url' => 'http://www.tiktok.com/@ayobehacaar',
            'youtube_url' => 'https://www.youtube.com/@ayobehacaar',
        ]));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Create default settings if table is empty.
     */
    public static function createDefault()
    {
        return self::create([
            'site_name' => 'ayo behacaar',
            'tagline' => 'Website artikel yang membahas segala hal menarik di masa kini',
            'description' => 'Ayo Behacaar hadir sebagai jembatan intelektual di era digital. Berakar dari nilai-nilai luhur budaya Kalimantan, khususnya Suku Dayak Tunjung, kami membawa semangat belajar yang inklusif dan modern kepada masyarakat luas.',
            'about_text' => 'Sebagai platform yang mengedepankan kualitas konten editorial, Ayo Behacaar berkomitmen untuk menyediakan sumber daya pembelajaran yang terkurasi. Dari literasi teknologi hingga pengembangan diri, kami merancang setiap artikel dan program kami untuk memberikan wawasan yang jernih dan dapat segera dipraktikkan.',
            'contact_email' => 'ayobehacaar@gmail.com',
            'instagram_url' => 'https://www.instagram.com/sainsaa__',
            'tiktok_url' => 'http://www.tiktok.com/@ayobehacaar',
            'youtube_url' => 'https://www.youtube.com/@ayobehacaar',
        ]);
    }
}

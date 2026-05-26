<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'image', 'category_id', 'user_id', 'is_published'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCleanTitleAttribute()
    {
        return $this->stripMarkdown($this->title);
    }

    public function getCleanContentAttribute()
    {
        return $this->stripMarkdown($this->content);
    }

    protected function stripMarkdown($text)
    {
        if (empty($text)) return '';

        // Strip headers like "# ", "## " at the start of a line
        $text = preg_replace('/^\s*#+\s+/m', '', $text);
        
        // Strip images: ![alt](url) -> ""
        $text = preg_replace('/!\[.*?\]\(.*?\)/', '', $text);
        
        // Strip links: [text](url) -> "text"
        $text = preg_replace('/\[(.*?)\]\(.*?\)/', '$1', $text);
        
        // Strip bold/italic/strikethrough: **text** or __text__ or *text* or _text_ or ~~text~~ -> "text"
        $text = preg_replace('/(~~|\*\*|__)(.*?)\1/', '$2', $text);
        $text = preg_replace('/(\*|_)(.*?)\1/', '$2', $text);
        
        // Strip inline code: `code` -> "code"
        $text = preg_replace('/`(.*?)`/', '$1', $text);
        
        // Strip highlights: ==text== -> "text"
        $text = preg_replace('/==(.*?)==/', '$1', $text);
        
        // Strip blockquotes: > text -> "text"
        $text = preg_replace('/^\s*>\s+/m', '', $text);

        return trim($text);
    }
}

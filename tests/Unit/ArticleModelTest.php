<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_has_correct_fillable_attributes(): void
    {
        $article = new Article();

        $this->assertEquals(
            ['title', 'slug', 'content', 'image', 'category_id', 'user_id', 'is_published'],
            $article->getFillable()
        );
    }

    public function test_article_belongs_to_category(): void
    {
        $article = Article::factory()->create();

        $this->assertInstanceOf(Category::class, $article->category);
    }

    public function test_article_belongs_to_user(): void
    {
        $article = Article::factory()->create();

        $this->assertInstanceOf(User::class, $article->user);
    }

    public function test_clean_title_accessor_strips_markdown(): void
    {
        $article = Article::factory()->create([
            'title' => '## **Bold Title**',
        ]);

        $this->assertEquals('Bold Title', $article->clean_title);
    }

    public function test_clean_content_accessor_strips_markdown(): void
    {
        $article = Article::factory()->create([
            'content' => '# Header\n\nSome **bold** content.',
        ]);

        $cleanContent = $article->clean_content;

        $this->assertStringNotContainsString('# ', $cleanContent);
        $this->assertStringNotContainsString('**', $cleanContent);
    }

    public function test_strip_markdown_removes_headers(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, "# Header 1\n## Header 2\n### Header 3");

        $this->assertStringNotContainsString('# ', $result);
        $this->assertStringNotContainsString('## ', $result);
        $this->assertStringNotContainsString('### ', $result);
        $this->assertStringContainsString('Header 1', $result);
        $this->assertStringContainsString('Header 2', $result);
        $this->assertStringContainsString('Header 3', $result);
    }

    public function test_strip_markdown_removes_bold_and_italic(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, '**bold** and *italic* and __underline__');

        $this->assertEquals('bold and italic and underline', $result);
    }

    public function test_strip_markdown_removes_links_but_keeps_text(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, '[Click here](https://example.com)');

        $this->assertEquals('Click here', $result);
    }

    public function test_strip_markdown_removes_images(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, '![Alt text](https://example.com/image.png)');

        $this->assertEquals('', $result);
    }

    public function test_strip_markdown_removes_inline_code(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, 'Use `console.log()` for debugging');

        $this->assertEquals('Use console.log() for debugging', $result);
    }

    public function test_strip_markdown_removes_highlights(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, 'This is ==highlighted== text');

        $this->assertEquals('This is highlighted text', $result);
    }

    public function test_strip_markdown_removes_blockquotes(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, '> This is a quote');

        $this->assertEquals('This is a quote', $result);
    }

    public function test_strip_markdown_handles_empty_string(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, '');

        $this->assertEquals('', $result);
    }

    public function test_strip_markdown_handles_null(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, null);

        $this->assertEquals('', $result);
    }

    public function test_strip_markdown_removes_strikethrough(): void
    {
        $article = new Article();

        $reflection = new \ReflectionMethod($article, 'stripMarkdown');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($article, '~~deleted text~~');

        $this->assertEquals('deleted text', $result);
    }
}

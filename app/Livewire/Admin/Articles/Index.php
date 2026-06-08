<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public string $title = '';
    public string $slug = '';
    public string $content = '';
    public ?string $image = null; // Now stores Cloudinary URL string
    public ?int $categoryId = null;
    public ?int $articleId = null;
    public bool $isEdit = false;
    public bool $isWriting = false;
    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $articles = Article::with('category')
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('livewire.admin.articles.index', compact('articles', 'categories'));
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function create()
    {
        $this->resetFields();
        $this->isWriting = true;
    }

    public function resetFields()
    {
        $this->reset(['title', 'slug', 'content', 'image', 'categoryId', 'articleId', 'isEdit', 'isWriting']);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:articles,slug,' . $this->articleId,
            'content' => 'required',
            'categoryId' => 'required|exists:categories,id',
            'image' => 'nullable|url|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'category_id' => $this->categoryId,
            'user_id' => auth()->id() ?: 1,
        ];

        // Image is now a Cloudinary URL string, store directly
        if ($this->image) {
            $data['image'] = $this->image;
        }

        if ($this->isEdit) {
            Article::find($this->articleId)->update($data);
            $message = 'Perubahan draf artikel berhasil disimpan.';
        } else {
            Article::create($data);
            $message = 'Artikel baru berhasil diterbitkan secara publik.';
        }

        $this->dispatch('swal:alert', [
            'title' => 'Berhasil!',
            'text' => $message,
            'icon' => 'success'
        ]);
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->content = $article->content;
        $this->categoryId = $article->category_id;
        $this->image = $article->image; // Keep current image reference (URL or legacy path)
        $this->isEdit = true;
        $this->isWriting = true;
    }

    public function delete($id)
    {
        Article::find($id)->delete();
        $this->dispatch('swal:alert', [
            'title' => 'Berhasil!',
            'text' => 'Artikel berhasil dihapus secara permanen.',
            'icon' => 'success'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id' => $id,
            'title' => 'Konfirmasi Hapus',
            'text' => 'Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.',
        ]);
    }
}

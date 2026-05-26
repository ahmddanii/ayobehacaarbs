<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithFileUploads, WithPagination;

    public $title, $slug, $content, $image, $categoryId, $articleId;
    public $isEdit = false;
    public $isWriting = false;
    public $search = '';

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
        $this->title = '';
        $this->slug = '';
        $this->content = '';
        $this->image = null;
        $this->categoryId = null;
        $this->articleId = null;
        $this->isEdit = false;
        $this->isWriting = false;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:articles,slug,' . $this->articleId,
            'content' => 'required',
            'categoryId' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'category_id' => $this->categoryId,
            'user_id' => auth()->id() ?: 1,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('articles', 'public');
        }

        if ($this->isEdit) {
            Article::find($this->articleId)->update($data);
            $message = 'Artikel berhasil diperbarui!';
        } else {
            Article::create($data);
            $message = 'Artikel berhasil ditambahkan!';
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
        $this->image = $article->image; // Keep current image reference
        $this->isEdit = true;
        $this->isWriting = true;
    }

    public function delete($id)
    {
        Article::find($id)->delete();
        $this->dispatch('swal:alert', [
            'title' => 'Berhasil!',
            'text' => 'Artikel telah dihapus.',
            'icon' => 'success'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id' => $id,
            'title' => 'Hapus Artikel?',
            'text' => 'Tindakan ini tidak dapat dibatalkan!',
        ]);
    }
}

<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public string $name = '';
    public string $slug = '';
    public ?string $image = null; // Now stores Cloudinary URL string
    public ?int $categoryId = null;
    public bool $isEdit = false;
    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $categories = Category::withCount('articles')
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.categories.index', compact('categories'));
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function resetFields()
    {
        $this->reset(['name', 'slug', 'image', 'categoryId', 'isEdit']);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', \Illuminate\Validation\Rule::unique('categories', 'slug')->ignore($this->categoryId)],
            'image' => 'nullable|url|max:2048',
        ];

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
        ];

        // Image is now a Cloudinary URL string, store directly
        if ($this->image) {
            $data['image'] = $this->image;
        }

        if ($this->isEdit) {
            Category::find($this->categoryId)->update($data);
            $message = 'Perubahan kategori berhasil disimpan.';
        } else {
            Category::create($data);
            $message = 'Kategori baru berhasil diterbitkan.';
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
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->image = $category->image; // Display existing image (URL or legacy path)
        $this->isEdit = true;
        $this->dispatch('open-modal');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        $this->dispatch('swal:alert', [
            'title' => 'Berhasil!',
            'text' => 'Kategori berhasil dihapus secara permanen.',
            'icon' => 'success'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id' => $id,
            'title' => 'Konfirmasi Hapus',
            'text' => 'Apakah Anda yakin ingin menghapus kategori ini beserta seluruh artikel di dalamnya? Tindakan ini tidak dapat dibatalkan.',
        ]);
    }
}

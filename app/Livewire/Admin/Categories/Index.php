<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithFileUploads;

    public $name, $slug, $image, $categoryId;
    public $isEdit = false;
    public $search = '';

    #[Layout('layouts.admin')]
    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
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
        $this->name = '';
        $this->slug = '';
        $this->image = null;
        $this->categoryId = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $this->categoryId,
            'image' => 'nullable|image|max:1024',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('categories', 'public');
        }

        if ($this->isEdit) {
            Category::find($this->categoryId)->update($data);
            $message = 'Kategori berhasil diperbarui!';
        } else {
            Category::create($data);
            $message = 'Kategori berhasil ditambahkan!';
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
        $this->isEdit = true;
        $this->dispatch('open-modal');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        $this->dispatch('swal:alert', [
            'title' => 'Berhasil!',
            'text' => 'Kategori telah dihapus.',
            'icon' => 'success'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id' => $id,
            'title' => 'Hapus Kategori?',
            'text' => 'Seluruh artikel dalam kategori ini akan ikut terhapus!',
        ]);
    }
}

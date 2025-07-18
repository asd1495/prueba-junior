<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CategoryManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Propiedades para el listado
    public $search = '';

    // Propiedades para el formulario
    public $showForm = false;
    public $categoryId;
    public $name, $description, $image, $newImage;

    protected function rules()
    {
        $imageRule = $this->categoryId ? 'nullable|image|max:1024' : 'required|image|max:1024';
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'newImage' => $imageRule,
        ];
    }

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->paginate(5);

        return view('livewire.category-manager', [
            'categories' => $categories,
        ])->layout('components.app-layout');
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->image = $category->image;
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];

        if ($this->newImage) {
            if ($this->categoryId && $this->image) {
                Storage::disk('public')->delete($this->image);
            }
            $data['image'] = $this->newImage->store('categories', 'public');
        }

        Category::updateOrCreate(['id' => $this->categoryId], $data);
        session()->flash('message', $this->categoryId ? 'Categoría actualizada.' : 'Categoría creada.');

        $this->closeForm();
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        session()->flash('message', 'Categoría eliminada.');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['categoryId', 'name', 'description', 'image', 'newImage']);
    }
}

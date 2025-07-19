<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProductManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Propiedades del listado
    public $search = '';
    public $sortBy = 'products.name'; // Columna por defecto para ordenar
    public $sortDirection = 'asc'; // Dirección por defecto

    // Propiedades del formulario
    public $showForm = false;
    public $productId;
    public $name, $description, $price, $quantity, $image, $newImage, $category_id;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'newImage' => 'nullable|image|max:1024',
        ];
    }

    public function render()
    {
        $products = Product::query()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->where('products.name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(5);

        $categories = Category::all();

        return view('livewire.product-manager', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('components.app-layout');
    }
    public function applySort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->quantity = $product->quantity;
        $this->category_id = $product->category_id;
        $this->image = $product->image;
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
        ];

        if ($this->newImage) {
            if ($this->productId && $this->image) {
                Storage::disk('public')->delete($this->image);
            }
            $data['image'] = $this->newImage->store('products', 'public');
        }

        Product::updateOrCreate(['id' => $this->productId], $data);
        session()->flash('message', $this->productId ? 'Producto actualizado.' : 'Producto creado.');

        $this->dispatch('productUpdated');
        $this->closeForm();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        session()->flash('message', 'Producto eliminado.');
        $this->dispatch('productUpdated');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['productId', 'name', 'description', 'price', 'quantity', 'category_id', 'image', 'newImage']);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\On;

class DashboardStats extends Component
{
    public $productCount;
    public $categoryCount;
    public $totalStock;
    public $recentProducts;
    public $lowStockProducts;

    public function mount()
    {
        $this->loadStats();
    }

    #[On('categoryUpdated')]
    #[On('productUpdated')]
    public function loadStats()
    {
        $this->productCount = Product::count();
        $this->categoryCount = Category::count();
        $this->totalStock = Product::sum('quantity');

        // Cargar productos recientes
        $this->recentProducts = Product::with('category')->latest()->take(5)->get();

        // Cargar productos con bajo stock (menos de 10 unidades)
        $this->lowStockProducts = Product::with('category')->orderBy('quantity', 'asc')->where('quantity', '<', 10)->take(5)->get();
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}

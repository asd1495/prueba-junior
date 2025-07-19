<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las categorías para asignar productos
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->info('No hay categorías, por favor ejecuta el CategorySeeder primero.');
            return;
        }

        // Crear 20 productos de ejemplo usando la factory
        Product::factory(20)->make()->each(function ($product) use ($categories) {
            // Asignar una categoría aleatoria a cada producto
            $product->category_id = $categories->random()->id;
            $product->save();
        });
    }
}

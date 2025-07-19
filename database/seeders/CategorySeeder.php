<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un conjunto de categorías predefinidas
        $categories = [
            ['name' => 'Electrónica', 'description' => 'Dispositivos y gadgets tecnológicos.'],
            ['name' => 'Ropa y Accesorios', 'description' => 'Vestimenta, calzado y complementos.'],
            ['name' => 'Hogar y Cocina', 'description' => 'Artículos para el hogar y utensilios de cocina.'],
            ['name' => 'Libros', 'description' => 'Libros de diversos géneros y autores.'],
            ['name' => 'Deportes', 'description' => 'Equipamiento y artículos deportivos.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

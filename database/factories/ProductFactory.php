<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true), // Genera un nombre de 3 palabras
            'description' => $this->faker->sentence(15), // Genera una descripción de 15 palabras
            'price' => $this->faker->randomFloat(2, 10, 200), // Precio decimal entre 10 y 200
            'quantity' => $this->faker->numberBetween(5, 100), // Cantidad entera entre 5 y 100
            // No definimos category_id aquí, ya que lo asignamos aleatoriamente en el seeder.
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-####??')),
            'description' => fake()->optional()->sentence(),
            'price' => fake()->randomFloat(2, 5, 500),
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(80),
            'meta' => fake()->boolean(70) ? [
                'color' => fake()->safeColorName(),
                'warranty_months' => (string) fake()->numberBetween(6, 36),
            ] : null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}

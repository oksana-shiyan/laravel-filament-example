<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'author' => fake()->name(),
            'body' => fake()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        $title = Str::title($name);

        return [
            'name' => [
                'en' => $title,
                'uk' => $title,
            ],
            'slug' => Str::slug($name),
        ];
    }
}

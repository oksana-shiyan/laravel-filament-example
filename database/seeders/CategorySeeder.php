<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Office', 'slug' => 'office'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ] as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']],
            );
        }
    }
}

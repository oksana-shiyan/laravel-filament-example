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
            [
                'slug' => 'electronics',
                'name' => [
                    'en' => 'Electronics',
                    'uk' => 'Електроніка',
                ],
            ],
            [
                'slug' => 'office',
                'name' => [
                    'en' => 'Office',
                    'uk' => 'Офіс',
                ],
            ],
            [
                'slug' => 'accessories',
                'name' => [
                    'en' => 'Accessories',
                    'uk' => 'Аксесуари',
                ],
            ],
        ] as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']],
            );
        }
    }
}

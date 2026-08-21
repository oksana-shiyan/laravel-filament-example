<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::query()->where('slug', 'electronics')->first();
        $office = Category::query()->where('slug', 'office')->first();
        $accessories = Category::query()->where('slug', 'accessories')->first();

        $products = [
            [
                'category_id' => $electronics?->id,
                'name' => 'Wireless Mouse',
                'sku' => 'MOUSE-001',
                'description' => 'Ergonomic wireless mouse with silent clicks.',
                'price' => 29.99,
                'stock' => 42,
                'is_active' => true,
                'meta' => [
                    'color' => 'black',
                    'connectivity' => 'bluetooth',
                ],
            ],
            [
                'category_id' => $electronics?->id,
                'name' => 'USB-C Hub',
                'sku' => 'HUB-004',
                'description' => '7-in-1 USB-C hub for laptops.',
                'price' => 49.50,
                'stock' => 18,
                'is_active' => true,
                'meta' => [
                    'ports' => '7',
                    'material' => 'aluminum',
                ],
            ],
            [
                'category_id' => $office?->id,
                'name' => 'Notebook Set',
                'sku' => 'NOTE-210',
                'description' => 'Pack of three lined notebooks.',
                'price' => 12.00,
                'stock' => 75,
                'is_active' => true,
                'meta' => [
                    'pages' => '80',
                    'size' => 'A5',
                ],
            ],
            [
                'category_id' => $office?->id,
                'name' => 'Desk Lamp',
                'sku' => 'LAMP-018',
                'description' => 'LED desk lamp with adjustable brightness.',
                'price' => 38.00,
                'stock' => 0,
                'is_active' => false,
                'meta' => [
                    'bulb' => 'led',
                    'power' => '12W',
                ],
            ],
            [
                'category_id' => $accessories?->id,
                'name' => 'Laptop Sleeve',
                'sku' => 'SLEEVE-13',
                'description' => 'Padded 13-inch laptop sleeve.',
                'price' => 24.95,
                'stock' => 31,
                'is_active' => true,
                'meta' => [
                    'size' => '13-inch',
                    'color' => 'gray',
                ],
            ],
            [
                'category_id' => $accessories?->id,
                'name' => 'Cable Organizer',
                'sku' => 'CABLE-009',
                'description' => null,
                'price' => 8.50,
                'stock' => 120,
                'is_active' => true,
                'meta' => [
                    'pieces' => '5',
                ],
            ],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['sku' => $product['sku']],
                $product,
            );
        }
    }
}

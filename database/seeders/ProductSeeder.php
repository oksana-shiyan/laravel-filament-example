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
                'name' => [
                    'en' => 'Wireless Mouse',
                    'uk' => 'Бездротова миша',
                ],
                'sku' => 'MOUSE-001',
                'description' => [
                    'en' => 'Ergonomic wireless mouse with silent clicks.',
                    'uk' => 'Ергономічна бездротова миша з тихими кліками.',
                ],
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
                'name' => [
                    'en' => 'USB-C Hub',
                    'uk' => 'USB-C хаб',
                ],
                'sku' => 'HUB-004',
                'description' => [
                    'en' => '7-in-1 USB-C hub for laptops.',
                    'uk' => 'USB-C хаб 7-в-1 для ноутбуків.',
                ],
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
                'name' => [
                    'en' => 'Notebook Set',
                    'uk' => 'Набір блокнотів',
                ],
                'sku' => 'NOTE-210',
                'description' => [
                    'en' => 'Pack of three lined notebooks.',
                    'uk' => 'Набір із трьох зошитів у лінійку.',
                ],
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
                'name' => [
                    'en' => 'Desk Lamp',
                    'uk' => 'Настільна лампа',
                ],
                'sku' => 'LAMP-018',
                'description' => [
                    'en' => 'LED desk lamp with adjustable brightness.',
                    'uk' => 'LED настільна лампа з регулюванням яскравості.',
                ],
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
                'name' => [
                    'en' => 'Laptop Sleeve',
                    'uk' => 'Чохол для ноутбука',
                ],
                'sku' => 'SLEEVE-13',
                'description' => [
                    'en' => 'Padded 13-inch laptop sleeve.',
                    'uk' => 'М’який чохол для ноутбука 13 дюймів.',
                ],
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
                'name' => [
                    'en' => 'Cable Organizer',
                    'uk' => 'Органайзер для кабелів',
                ],
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

<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            'MOUSE-001' => [
                ['author' => 'Alex Rivera', 'body' => 'Comfortable grip and quiet clicks.'],
                ['author' => 'Sam Lee', 'body' => 'Battery lasts longer than expected.'],
            ],
            'HUB-004' => [
                ['author' => 'Jordan Blake', 'body' => 'Solid build and all ports work well.'],
            ],
            'NOTE-210' => [
                ['author' => 'Casey Quinn', 'body' => 'Nice paper quality for daily notes.'],
                ['author' => 'Riley Chen', 'body' => 'Great value for a three-pack.'],
            ],
            'SLEEVE-13' => [
                ['author' => 'Morgan Ellis', 'body' => 'Fits my laptop snugly with room for a charger.'],
            ],
        ];

        foreach ($comments as $sku => $items) {
            $product = Product::query()->where('sku', $sku)->first();

            if (! $product) {
                continue;
            }

            foreach ($items as $item) {
                Comment::query()->firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'author' => $item['author'],
                        'body' => $item['body'],
                    ],
                );
            }
        }
    }
}

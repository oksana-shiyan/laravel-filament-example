<?php

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;

it('creates a product from the factory', function () {
    $product = Product::factory()->create();

    expect($product->exists)->toBeTrue()
        ->and($product->sku)->not->toBeEmpty()
        ->and($product->price)->not->toBeNull()
        ->and($product->stock)->toBeInt()
        ->and($product->is_active)->toBeBool()
        ->and($product->category)->toBeInstanceOf(Category::class);
});

it('stores a unique sku', function () {
    $product = Product::factory()->create(['sku' => 'SKU-UNIQUE']);

    expect(Product::query()->where('sku', 'SKU-UNIQUE')->count())->toBe(1)
        ->and($product->sku)->toBe('SKU-UNIQUE');
});

it('casts meta to an array', function () {
    $product = Product::factory()->create([
        'meta' => [
            'color' => 'red',
            'weight' => '1kg',
        ],
    ]);

    expect($product->meta)
        ->toBeArray()
        ->toMatchArray([
            'color' => 'red',
            'weight' => '1kg',
        ]);
});

it('can have comments', function () {
    $product = Product::factory()
        ->has(Comment::factory()->count(2))
        ->create();

    expect($product->comments)->toHaveCount(2)
        ->and($product->comments->first()->author)->not->toBeEmpty()
        ->and($product->comments->first()->body)->not->toBeEmpty();
});

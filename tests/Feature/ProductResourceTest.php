<?php

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Widgets\CatalogStatsOverview;
use App\Models\Product;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

beforeEach(function () {
    Filament::setCurrentPanel('admin');

    $this->actingAs(User::factory()->create());
});

it('loads the dashboard for an authenticated user', function () {
    $this->get('/')
        ->assertOk();

    Livewire::test(Dashboard::class)
        ->assertOk()
        ->assertSeeLivewire(CatalogStatsOverview::class);
});

it('loads catalog stats cards', function () {
    Product::factory()->count(2)->create(['is_active' => true, 'stock' => 5]);

    Livewire::test(CatalogStatsOverview::class)
        ->assertOk()
        ->assertSee('Products')
        ->assertSee('Low stock')
        ->assertSee('Categories')
        ->assertSee('Comments');
});

it('loads the product list for an authenticated user', function () {
    $products = Product::factory()->count(3)->create();

    Livewire::test(ListProducts::class)
        ->assertOk()
        ->assertCanSeeTableRecords($products);
});

it('loads the create product page for an authenticated user', function () {
    Livewire::test(CreateProduct::class)
        ->assertOk();
});

it('loads the edit product page for an authenticated user', function () {
    $product = Product::factory()->create();

    Livewire::test(EditProduct::class, [
        'record' => $product->getRouteKey(),
    ])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $product->name,
            'sku' => $product->sku,
        ]);
});

it('loads the category list for an authenticated user', function () {
    Livewire::test(ListCategories::class)
        ->assertOk();
});

it('can restock a product from the table action', function () {
    $product = Product::factory()->create(['stock' => 3]);

    Livewire::test(ListProducts::class)
        ->callTableAction('restock', $product, [
            'quantity' => 25,
        ])
        ->assertNotified();

    expect($product->fresh()->stock)->toBe(28);
});

it('validates restock quantity', function () {
    $product = Product::factory()->create(['stock' => 3]);

    Livewire::test(ListProducts::class)
        ->callTableAction('restock', $product, [
            'quantity' => 0,
        ])
        ->assertHasTableActionErrors(['quantity']);

    expect($product->fresh()->stock)->toBe(3);
});

it('can bulk mark products inactive', function () {
    $products = Product::factory()->count(2)->create(['is_active' => true]);

    Livewire::test(ListProducts::class)
        ->callTableBulkAction('markInactive', $products)
        ->assertNotified();

    $products->each(fn (Product $product) => expect($product->fresh()->is_active)->toBeFalse());
});

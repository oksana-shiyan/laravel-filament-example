<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Products\ProductResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CatalogStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Catalog overview';

    protected ?string $description = 'Quick stats for products, categories, and comments.';

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $productCount = Product::query()->count();
        $activeProductCount = Product::query()->where('is_active', true)->count();
        $lowStockCount = Product::query()->where('stock', '<=', 10)->count();
        $categoryCount = Category::query()->count();
        $commentCount = Comment::query()->count();

        return [
            Stat::make('Products', (string) $productCount)
                ->description("{$activeProductCount} active")
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedShoppingBag)
                ->color('primary')
                ->url(ProductResource::getUrl()),
            Stat::make('Low stock', (string) $lowStockCount)
                ->description('10 or fewer units')
                ->descriptionIcon(Heroicon::OutlinedExclamationTriangle)
                ->icon(Heroicon::OutlinedCube)
                ->color($lowStockCount > 0 ? 'warning' : 'success')
                ->url(ProductResource::getUrl()),
            Stat::make('Categories', (string) $categoryCount)
                ->description('Browse categories')
                ->descriptionIcon(Heroicon::OutlinedTag)
                ->icon(Heroicon::OutlinedTag)
                ->color('info')
                ->url(CategoryResource::getUrl()),
            Stat::make('Comments', (string) $commentCount)
                ->description('Across all products')
                ->descriptionIcon(Heroicon::OutlinedChatBubbleLeftRight)
                ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                ->color('gray'),
        ];
    }
}

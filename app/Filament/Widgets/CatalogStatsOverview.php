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
    protected ?string $pollingInterval = null;

    protected function getHeading(): ?string
    {
        return __('catalog.dashboard.heading');
    }

    protected function getDescription(): ?string
    {
        return __('catalog.dashboard.description');
    }

    protected function getStats(): array
    {
        $productCount = Product::query()->count();
        $activeProductCount = Product::query()->where('is_active', true)->count();
        $lowStockCount = Product::query()->where('stock', '<=', 10)->count();
        $categoryCount = Category::query()->count();
        $commentCount = Comment::query()->count();

        return [
            Stat::make(__('catalog.stats.products'), (string) $productCount)
                ->description(__('catalog.stats.products_active', ['count' => $activeProductCount]))
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedShoppingBag)
                ->color('primary')
                ->url(ProductResource::getUrl()),
            Stat::make(__('catalog.stats.low_stock'), (string) $lowStockCount)
                ->description(__('catalog.stats.low_stock_description'))
                ->descriptionIcon(Heroicon::OutlinedExclamationTriangle)
                ->icon(Heroicon::OutlinedCube)
                ->color($lowStockCount > 0 ? 'warning' : 'success')
                ->url(ProductResource::getUrl()),
            Stat::make(__('catalog.stats.categories'), (string) $categoryCount)
                ->description(__('catalog.stats.categories_description'))
                ->descriptionIcon(Heroicon::OutlinedTag)
                ->icon(Heroicon::OutlinedTag)
                ->color('info')
                ->url(CategoryResource::getUrl()),
            Stat::make(__('catalog.stats.comments'), (string) $commentCount)
                ->description(__('catalog.stats.comments_description'))
                ->descriptionIcon(Heroicon::OutlinedChatBubbleLeftRight)
                ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                ->color('gray'),
        ];
    }
}

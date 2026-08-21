<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CatalogStatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?int $navigationSort = -1;

    public function getWidgets(): array
    {
        return [
            CatalogStatsOverview::class,
        ];
    }
}

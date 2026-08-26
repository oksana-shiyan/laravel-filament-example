<?php

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\Enums\Placement;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch): void {
            $switch
                ->locales(['en', 'uk'])
                ->labels([
                    'en' => 'English',
                    'uk' => 'Українська',
                ])
                ->trigger(icon: Heroicon::GlobeAlt)
                ->visible(outsidePanels: true)
                ->outsidePanelPlacement(Placement::TopEnd);
        });
    }
}

<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
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
        // Register GoJS assets
        FilamentAsset::register([
            \Filament\Support\Assets\Js::make('GoJS', asset('js/GoJS/go.js')),
            \Filament\Support\Assets\Js::make('FishboneLayout', asset('js/GoJS/FishboneLayout.js')),
        ]);

        // Modal Juknis Button
        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_NAV_START,
            fn (): string => Blade::render('<livewire:juknis-modal-button />'),
        );

        // Modal Juknis
        FilamentView::registerRenderHook(
            PanelsRenderHook::PAGE_END,
            fn (): string => Blade::render('<livewire:juknis-modal />'),
        );

        // Https on production
        // if (config('app.https_on_production')) {
        //     \Illuminate\Support\Facades\URL::forceScheme('https');
        // }
    }
}

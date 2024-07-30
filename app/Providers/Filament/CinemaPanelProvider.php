<?php

namespace App\Providers\Filament;

use App\Filament\Cinema\Pages\Dashboard;
use App\Http\Middleware\CinemaAuth;
use App\Http\Middleware\CinemaCheckLoginUrl;
use App\Http\Middleware\CinemaGuest;
use App\Http\Middleware\SetLanguageBasedOnCountry;
use App\Livewire\Cinema\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CinemaPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('cinema')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            // ->loginRouteSlug('/')

            ->authGuard('cinema')
            ->login(Login::class)
            ->discoverResources(in: app_path('Filament/Cinema/Resources'), for: 'App\\Filament\\Cinema\\Resources')
            ->discoverPages(in: app_path('Filament/Cinema/Pages'), for: 'App\\Filament\\Cinema\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Cinema/Widgets'), for: 'App\\Filament\\Cinema\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                CinemaCheckLoginUrl::class,
            ])
            ->authMiddleware([
                CinemaAuth::class,
                SetLanguageBasedOnCountry::class
            ])
            ->brandName('Cinema Portal')
            ->domain(config('filament.cinema_portal_url'));
    }
}

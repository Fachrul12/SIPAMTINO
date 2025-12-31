<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Facades\Filament;
use App\Filament\Pages\AdminDashboard;
use App\Filament\Pages\PetugasDashboard;
use App\Filament\Pages\PelangganDashboard;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\CustomLogin;
use Filament\Support\Facades\FilamentView;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->spa()
            ->login(CustomLogin::class)
            ->colors([
                'primary' => Color::Blue,
            ])
            // ->brandLogo(asset('assets/logo.png'))
            ->brandLogo(fn () => view('filament.brand.logo'))
            ->brandName('SIPAMTINO')
            ->favicon(asset('assets/logo.png'))
            ->renderHook(
                'panels::head.end',
                fn (): string => '<link rel="stylesheet" href="' . asset('css/simple-menu-style.css') . '">'
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                AdminDashboard::class,
                PetugasDashboard::class,
                PelangganDashboard::class,
            ])
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
            ])
            ->authMiddleware([
                
                Authenticate::class,
            ])
            ->homeUrl(function () {
                $user = \Illuminate\Support\Facades\Auth::user(); 
            
                $roleId = $user?->role_id;
            
                return match ($roleId) {
                    1 => route('filament.admin.pages.admin-dashboard'),
                    2 => route('petugas.dashboard'),
                    3 => route('pelanggan.dashboard'),
                    default => route('filament.admin.pages.admin-dashboard'), // fallback
                };
            });
            
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\WidgetResource\Widgets\PelangganStatsWidget;
use App\Filament\Resources\WidgetResource\Widgets\PemakaianAirChart;
use App\Filament\Resources\WidgetResource\Widgets\PengaduanTerbaru;
use App\Filament\Resources\WidgetResource\Widgets\TurbidityChart;

class PelangganDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Pelanggan';
    protected static string $routePath = '/pelanggan/dashboard';
    protected static string $view = 'filament.pages.pelanggan-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role_id === 3;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PelangganStatsWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [                
            TurbidityChart::class,      
            PemakaianAirChart::class,
            PengaduanTerbaru::class,             
        ];
    }

}

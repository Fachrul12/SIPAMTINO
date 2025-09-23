<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Periode;
use App\Filament\Resources\WidgetResource\Widgets\PetugasWidget;
use App\Filament\Resources\WidgetResource\Widgets\ProgressPencatatanWidget;
use App\Filament\Resources\WidgetResource\Widgets\PemakaianAirChart;
use App\Filament\Resources\WidgetResource\Widgets\TurbidityChart;
use App\Filament\Resources\WidgetResource\Widgets\PengaduanChart;
use App\Filament\Resources\WidgetResource\Widgets\PengaduanTerbaru;


class PetugasDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Petugas';
    protected static string $routePath = '/petugas/dashboard';
    protected static string $view = 'filament.pages.petugas-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role_id === 2;
    }


    protected function getHeaderWidgets(): array
    {
        return [
            PetugasWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [            
            TurbidityChart::class,
            PemakaianAirChart::class,
            ProgressPencatatanWidget::class,   
            PengaduanChart::class,
            PengaduanTerbaru::class,                       
        ];
    } 

    /**
     * Mount method to pass data to view
     */
    public function mount(): void
    {
        // Data will be available in the view
    }
}

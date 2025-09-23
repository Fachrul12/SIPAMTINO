<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\CalonPelanggan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CalonPelangganWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Calon Pelanggan', CalonPelanggan::count())
                ->description('Semua calon pelanggan')
                ->icon('heroicon-o-user-plus')
                ->color('primary'),
        
            Card::make('Pending', CalonPelanggan::where('status', 'pending')->count())
                ->description('Menunggu verifikasi')
                ->icon('heroicon-o-clock')
                ->color('warning'),
        
            Card::make('Disetujui', CalonPelanggan::where('status', 'approved')->count())
                ->description('Pelanggan disetujui')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        
            Card::make('Ditolak', CalonPelanggan::where('status', 'rejected')->count())
                ->description('Pelanggan ditolak')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ];
        
    }
}

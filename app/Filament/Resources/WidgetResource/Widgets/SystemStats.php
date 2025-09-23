<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Pengaduan;
use App\Models\CalonPelanggan;
use App\Models\Periode;
use App\Models\Pemakaian;

class SystemStats extends BaseWidget
{
    protected function getCards(): array
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();

        return [            
            Card::make('Total Pelanggan', Pelanggan::count())
                ->description('Pelanggan aktif')
                ->icon('heroicon-o-users')
                ->color('info'),

            Card::make('Calon Pelanggan', CalonPelanggan::where('status', 'pending')->count())
                ->description('Pelanggan aktif')
                ->icon('heroicon-o-users')
                ->color('info'),            

            Card::make('Total Pengaduan', Pengaduan::where('status', 'pending')->count())
                ->description('Semua status pengaduan')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('warning'),

            Card::make(
                'Pemakaian Air',
                $periodeAktif
                    ? number_format(Pemakaian::where('periode_id', $periodeAktif->id)->sum('total_pakai')) . ' m³'
                    : '0 m³'
            )
                ->description($periodeAktif ? "Periode: {$periodeAktif->nama_periode}" : 'Tidak ada periode aktif')
                ->icon('heroicon-o-chart-bar')
                ->color('cyan'),                
            
        ];
    }
}

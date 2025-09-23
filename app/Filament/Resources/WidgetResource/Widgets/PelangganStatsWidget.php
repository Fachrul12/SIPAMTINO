<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pemakaian;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Periode;

class PelangganStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();
        if (! $user->pelanggan) {
            return [];
        }

        $pelangganId = $user->pelanggan->id;
        $periodeAktif = Periode::where('status', 'aktif')->first();

        $totalPemakaian = Pemakaian::where('pelanggan_id', $pelangganId)->sum('total_pakai');
        $pemakaianAktif = $periodeAktif
            ? Pemakaian::where('pelanggan_id', $pelangganId)->where('periode_id', $periodeAktif->id)->sum('total_pakai')
            : 0;

        $sudahLunas = Pembayaran::whereHas('pemakaian', fn($q) => $q->where('pelanggan_id', $pelangganId))
            ->where('status', 'lunas')
            ->count();

        $belumLunas = Pembayaran::whereHas('pemakaian', fn($q) => $q->where('pelanggan_id', $pelangganId))
            ->where('status', 'belum_lunas')
            ->count();

        return [
            Card::make('Total Pemakaian', number_format($totalPemakaian) . ' m³')
                ->description('Semua periode')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),

            Card::make('Pemakaian Periode Aktif', number_format($pemakaianAktif) . ' m³')
                ->description($periodeAktif ? $periodeAktif->nama_periode : '-')
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Card::make('Tagihan Lunas', $sudahLunas)
                ->description('Jumlah tagihan dibayar')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Card::make('Tagihan Belum Lunas', $belumLunas)
                ->description('Jumlah tagihan pending')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}

<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pemakaian;
use App\Models\Periode;
use App\Models\Pembayaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class PemakaianWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();
        $periodeAktif = Periode::where('status', 'aktif')->first();

        if (! $periodeAktif) {
            return [
                Card::make('Tidak ada periode aktif', '-')
                    ->description('Harap buat periode terlebih dahulu')
                    ->color('danger')
                    ->icon('heroicon-o-exclamation-circle'),
            ];
        }

        // === Jika Admin (role_id = 1) ===
        if ($user->role_id === 1) {
            $totalPelanggan = Pemakaian::where('periode_id', $periodeAktif->id)
                ->distinct('pelanggan_id')
                ->count('pelanggan_id');

            $totalPemakaian = Pemakaian::where('periode_id', $periodeAktif->id)
                ->sum('total_pakai');

            $sudahLunas = Pembayaran::whereHas('pemakaian', fn($q) => $q->where('periode_id', $periodeAktif->id))
                ->where('status', 'lunas')
                ->distinct('pemakaian_id')
                ->count('pemakaian_id');

            $belumLunas = Pembayaran::whereHas('pemakaian', fn($q) => $q->where('periode_id', $periodeAktif->id))
                ->where('status', 'belum_lunas')
                ->distinct('pemakaian_id')
                ->count('pemakaian_id');

            return [
                Card::make('Total Pelanggan', $totalPelanggan)
                    ->description('Periode: ' . $periodeAktif->nama_periode)
                    ->color('primary')
                    ->icon('heroicon-o-users'),

                Card::make('Total Pemakaian', number_format($totalPemakaian) . ' m³')
                    ->description('Semua pelanggan periode aktif')
                    ->color('info')
                    ->icon('heroicon-o-chart-bar'),

                Card::make('Sudah Lunas', $sudahLunas)
                    ->description('Tagihan sudah dibayar')
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),

                Card::make('Belum Lunas', $belumLunas)
                    ->description('Tagihan belum dibayar')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),
            ];
        }

        // === Jika Pelanggan (role_id = 3) ===
        if ($user->role_id === 3 && $user->pelanggan) {
            $pelangganId = $user->pelanggan->id;

            $totalPemakaian = Pemakaian::where('pelanggan_id', $pelangganId)
                ->count();

            $volumePemakaian = Pemakaian::where('pelanggan_id', $pelangganId)
                ->sum('total_pakai');

            $sudahLunas = Pembayaran::whereHas('pemakaian', fn($q) => $q->where('pelanggan_id', $pelangganId))
                ->where('status', 'lunas')
                ->count();

            $belumLunas = Pembayaran::whereHas('pemakaian', fn($q) => $q->where('pelanggan_id', $pelangganId))
                ->where('status', 'belum_lunas')
                ->count();

            return [
                Card::make('Total Pemakaian', $totalPemakaian)
                    ->description('Jumlah periode yang tercatat')
                    ->color('primary')
                    ->icon('heroicon-o-clipboard-document-list'),

                Card::make('Volume Pemakaian', number_format($volumePemakaian) . ' m³')
                    ->description('Total penggunaan air')
                    ->color('info')
                    ->icon('heroicon-o-chart-bar'),

                Card::make('Sudah Lunas', $sudahLunas)
                    ->description('Tagihan sudah dibayar')
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),

                Card::make('Belum Lunas', $belumLunas)
                    ->description('Tagihan belum dibayar')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),
            ];
        }

        return [];
    }
}

<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pemakaian;
use App\Models\Periode;
use App\Models\Pelanggan;
use App\Models\Pengaduan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class PetugasWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();
        $periodeAktif = Periode::where('status', 'aktif')->first();

        // Kalau tidak ada periode aktif
        if (! $periodeAktif) {
            return [
                Card::make('Tidak ada periode aktif', '-')
                    ->description('Harap buat periode terlebih dahulu')
                    ->color('danger')
                    ->icon('heroicon-o-exclamation-circle'),
            ];
        }

        // === Jika Petugas (role_id = 2) ===
        if ($user->role_id === 2) {
            $totalPelanggan = Pelanggan::count();

            $sudahDicatat = Pemakaian::where('periode_id', $periodeAktif->id)
                ->distinct('pelanggan_id')
                ->count('pelanggan_id');

            $belumDicatat = $totalPelanggan - $sudahDicatat;

            $pengaduanBelum = Pengaduan::where('status', 'Belum Diproses')->count();
            $pengaduanSelesai = Pengaduan::where('status', 'Selesai')->count();

            return [
                Card::make('Total Pelanggan Aktif', $totalPelanggan)
                    ->description('Periode: ' . $periodeAktif->nama_periode)
                    ->color('primary')
                    ->icon('heroicon-o-users'),

                Card::make('Sudah Dicatat', $sudahDicatat)
                    ->description('Pemakaian sudah dicatat')
                    ->color('success')
                    ->icon('heroicon-o-clipboard-document-check'),

                Card::make('Belum Dicatat', $belumDicatat)
                    ->description('Pemakaian belum dicatat')
                    ->color('warning')
                    ->icon('heroicon-o-clipboard-document'),

                Card::make('Pengaduan Belum Diproses', $pengaduanBelum)
                    ->description('Harus segera ditangani')
                    ->color('danger')
                    ->icon('heroicon-o-exclamation-triangle'),
            ];
        }

        return [];
    }
}

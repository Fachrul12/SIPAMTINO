<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pengaduan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class PengaduanWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();

        // === Admin & Petugas ===
        if ($user->role_id !== 3) {
            $total = Pengaduan::count();
            $belumDiproses = Pengaduan::where('status', 'Belum Diproses')->count();
            $selesai = Pengaduan::where('status', 'Selesai')->count();

            return [
                Card::make('Total Pengaduan', $total)
                    ->description('Semua pengaduan')
                    ->color('primary')
                    ->icon('heroicon-o-chat-bubble-left-right'),

                Card::make('Belum Diproses', $belumDiproses)
                    ->description('Menunggu penanganan')
                    ->color('warning')
                    ->icon('heroicon-o-exclamation-triangle'),

                Card::make('Selesai', $selesai)
                    ->description('Sudah diproses')
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
            ];
        }

        // === Pelanggan ===
        $total = Pengaduan::where('user_id', $user->id)->count();
        $belumDiproses = Pengaduan::where('user_id', $user->id)
            ->where('status', 'Belum Diproses')
            ->count();
        $selesai = Pengaduan::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->count();

        return [
            Card::make('Total Pengaduan', $total)
                ->description('Pengaduan milik Anda')
                ->color('primary')
                ->icon('heroicon-o-chat-bubble-left-right'),

            Card::make('Belum Diproses', $belumDiproses)
                ->description('Menunggu penanganan')
                ->color('warning')
                ->icon('heroicon-o-exclamation-triangle'),

            Card::make('Selesai', $selesai)
                ->description('Sudah diproses')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}

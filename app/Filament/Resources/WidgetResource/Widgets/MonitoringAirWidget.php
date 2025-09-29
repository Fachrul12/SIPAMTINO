<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\TurbiditySummary;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Redis;

class MonitoringAirWidget extends BaseWidget
{
    protected function getCards(): array
    {
        // Ambil data terbaru dari Redis
        $latest = Redis::get('turbidity:latest');
        $nilaiSekarang = $latest ? floatval($latest) : 0;

        // Ambil data statistik dari DB
        $avg = TurbiditySummary::avg('avg');
        $min = TurbiditySummary::min('min');
        $max = TurbiditySummary::max('max');

        // Tentukan label kondisi berdasarkan nilai NTU
        $kondisi = match (true) {
            $nilaiSekarang <= 5  => ['label' => 'Sangat Jernih – Aman dikonsumsi', 'color' => 'success', 'icon' => 'heroicon-o-sparkles'],
            $nilaiSekarang <= 25 => ['label' => 'Jernih – Layak konsumsi', 'color' => 'info', 'icon' => 'heroicon-o-adjustments-horizontal'],
            $nilaiSekarang <= 50 => ['label' => 'Kurang Jernih – Perlu penyaringan', 'color' => 'warning', 'icon' => 'heroicon-o-exclamation-triangle'],
            default              => ['label' => 'Keruh – Perlu perhatian', 'color' => 'danger', 'icon' => 'heroicon-o-fire'],
        };

        return [
            // Card 1 - Kekeruhan sekarang (Redis)
            Card::make('Kekeruhan Sekarang', number_format($nilaiSekarang, 2) . ' NTU')
                ->description($kondisi['label'] . ' (NTU = satuan kekeruhan air)')
                ->color($kondisi['color'])
                ->icon($kondisi['icon']),

            // Card 2 - Rata-rata
            Card::make('Rata-rata Harian', $avg ? number_format($avg, 2) . ' NTU' : '-')
                ->description('Rata-rata dari laporan setiap jam (NTU)')
                ->color('info')
                ->icon('heroicon-o-chart-bar'),

            // Card 3 - Nilai terendah
            Card::make('Terendah Tercatat', $min ? number_format($min, 2) . ' NTU' : '-')
                ->description('Air paling jernih (data historis per jam)')
                ->color('success')
                ->icon('heroicon-o-arrow-down'),

            // Card 4 - Nilai tertinggi
            Card::make('Tertinggi Tercatat', $max ? number_format($max, 2) . ' NTU' : '-')
                ->description('Air paling keruh (data historis per jam)')
                ->color('danger')
                ->icon('heroicon-o-arrow-up'),
        ];
    }
}

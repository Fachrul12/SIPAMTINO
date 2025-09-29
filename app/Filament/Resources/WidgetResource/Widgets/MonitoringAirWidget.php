<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Turbidity;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class MonitoringAirWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $terbaru = Turbidity::orderBy('recorded_at', 'desc')->first();
        $min     = Turbidity::min('turbidity');
        $max     = Turbidity::max('turbidity');

        $nilaiSekarang = $terbaru?->turbidity ?? 0;

        // Tentukan label kondisi berdasarkan nilai NTU
        $kondisi = match (true) {
            $nilaiSekarang <= 5  => ['label' => 'Sangat Jernih', 'color' => 'success', 'icon' => 'heroicon-o-sparkles'],
            $nilaiSekarang <= 25 => ['label' => 'Jernih', 'color' => 'info', 'icon' => 'heroicon-o-adjustments-horizontal'],
            $nilaiSekarang <= 50 => ['label' => 'Kurang Jernih', 'color' => 'warning', 'icon' => 'heroicon-o-exclamation-triangle'],
            default              => ['label' => 'Keruh', 'color' => 'danger', 'icon' => 'heroicon-o-fire'],
        };

        return [
            // Card 1 - Nilai sekarang
            Card::make('Kekeruhan Sekarang', number_format($nilaiSekarang, 2) . ' NTU')
                ->description($kondisi['label'])
                ->color($kondisi['color'])
                ->icon($kondisi['icon']),

            // Card 2 - Nilai terendah
            Card::make('Terendah Tercatat', $min ? number_format($min, 2) . ' NTU' : '-')
                ->description('Air paling jernih')
                ->color('success')
                ->icon('heroicon-o-arrow-down'),

            // Card 3 - Nilai tertinggi
            Card::make('Tertinggi Tercatat', $max ? number_format($max, 2) . ' NTU' : '-')
                ->description('Air paling keruh')
                ->color('danger')
                ->icon('heroicon-o-arrow-up'),
        ];
    }
}

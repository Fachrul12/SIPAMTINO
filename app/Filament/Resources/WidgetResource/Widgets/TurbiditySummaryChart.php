<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\TurbiditySummary;
use Filament\Widgets\ChartWidget;

class TurbiditySummaryChart extends ChartWidget
{
    protected static ?string $heading = 'Rata-rata Kekeruhan (Histori)';
    protected static ?string $pollingInterval = '60s'; // refresh tiap 1 menit

    protected function getData(): array
    {
        $query = TurbiditySummary::query();

        // Filter berdasarkan pilihan user
        $range = match ($this->filter) {
            '1d' => now()->subDay(),
            '1w' => now()->subWeek(),
            '1m' => now()->subMonth(),
            default => now()->subDay(),
        };

        $summaries = $query->where('period', '>=', $range)
            ->orderBy('period', 'asc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata (NTU)',
                    'data' => $summaries->pluck('avg')->toArray(),                    
                    'borderColor' => '#3b82f6',
                    'fill' => false,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Maksimum',
                    'data' => $summaries->pluck('max')->toArray(),
                    'borderColor' => '#ef4444',
                    'fill' => false,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Minimum',
                    'data' => $summaries->pluck('min')->toArray(),
                    'borderColor' => '#10b981',
                    'fill' => false,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $summaries->pluck('period')
                ->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M H:i'))
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            '1d' => '1 Hari',
            '1w' => '1 Minggu',
            '1m' => '1 Bulan',
        ];
    }
}

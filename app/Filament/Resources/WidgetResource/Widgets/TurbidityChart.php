<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Turbidity;
use Filament\Widgets\ChartWidget;

class TurbidityChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Kekeruhan Air (NTU)';

    // Refresh otomatis setiap 5 detik
    protected static ?string $pollingInterval = '5s';

    protected function getData(): array
    {
        $data = Turbidity::orderBy('recorded_at', 'asc')
            ->take(20)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Turbidity (NTU)',
                    'data' => $data->pluck('turbidity')->toArray(),
                    'borderColor' => '#3b82f6',
                    'fill' => false,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('recorded_at')
                ->map(fn($date) => $date->format('H:i:s'))
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Redis;

class TurbidityChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Kekeruhan Air (Real-time)';
    protected static ?string $pollingInterval = '1s'; 

    protected function getData(): array
    {
        // Ambil 20 data terakhir dari Redis buffer
        $data = Redis::lrange('turbidity:buffer', -20, -1);

        $values = array_map('floatval', $data);

        return [
            'datasets' => [
                [
                    'label' => 'Turbidity (NTU)',
                    'data' => $values,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59,130,246,0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => range(1, count($values)), // hanya urutan 1..20
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

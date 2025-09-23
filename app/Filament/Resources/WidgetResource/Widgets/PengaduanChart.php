<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pengaduan;
use Filament\Widgets\ChartWidget;

class PengaduanChart extends ChartWidget
{
    protected static ?string $heading = 'Status Pengaduan';

    protected function getData(): array
    {
        $belum = Pengaduan::where('status', 'Belum Diproses')->count();
        $selesai = Pengaduan::where('status', 'Selesai')->count();

        return [
            'datasets' => [
                [
                    'data' => [$belum, $selesai],
                    'backgroundColor' => ['#ef4444', '#22c55e'],
                ],
            ],
            'labels' => ['Belum Diproses', 'Selesai'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}

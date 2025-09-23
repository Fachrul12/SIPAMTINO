<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pemakaian;
use App\Models\Periode;
use Filament\Widgets\ChartWidget;

class PemakaianAirChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pemakaian Air per Periode';

    public ?string $filter = null;

    protected function getFilters(): ?array
    {
        // Ambil semua tahun yang tersedia di tabel periode
        return Periode::query()
            ->selectRaw('DISTINCT tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun', 'tahun')
            ->toArray();
    }

    protected function getData(): array
    {
        // Ambil tahun yang dipilih, default tahun terbaru
        $tahun = $this->filter ?? Periode::max('tahun');

        // Ambil semua periode (bulan) dalam tahun itu
        $periodes = Periode::where('tahun', $tahun)
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        $labels = [];
        $data = [];

        foreach ($periodes as $periode) {
            $labels[] = $periode->nama_periode;

            // Jumlahkan pemakaian per periode pakai kolom yang benar
            $data[] = Pemakaian::where('periode_id', $periode->id)
                ->sum('total_pakai');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemakaian Air (m³)',
                    'data' => $data,
                    'backgroundColor' => '#06b6d4',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

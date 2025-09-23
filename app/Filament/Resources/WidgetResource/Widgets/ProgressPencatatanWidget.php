<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Periode;
use Filament\Widgets\ChartWidget;


class ProgressPencatatanWidget extends ChartWidget
{
    protected static ?string $heading = 'Progress Pencatatan';

    public ?string $filter = null;

    protected function getFilters(): ?array
    {
        return Periode::orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->pluck('nama_periode', 'id')
            ->toArray();
    }

    protected function getData(): array
    {
        $periodeId = $this->filter ?? Periode::latest()->first()?->id;

        $total = Pelanggan::count();
        $sudah = Pemakaian::where('periode_id', $periodeId)
            ->distinct('pelanggan_id')
            ->count('pelanggan_id');
        $belum = $total - $sudah;

        return [
            'datasets' => [
                [
                    'data' => [$sudah, $belum],
                    'backgroundColor' => [
                        'rgba(34,197,94,0.8)',  // hijau
                        'rgba(229,62,62,0.3)',  // merah
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Sudah Dicatat', 'Belum Dicatat'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'default' => 1, // mobile = 1 kolom
            'md' => 1,
            'lg' => 1, // desktop = 1 kolom (jadi kalau ada 2 widget lain, otomatis sejajar)
        ];
    }

}

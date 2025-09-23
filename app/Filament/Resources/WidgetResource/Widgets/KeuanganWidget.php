<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pembayaran;
use App\Models\Periode;
use Filament\Widgets\ChartWidget;

class KeuanganWidget extends ChartWidget
{
    protected static ?string $heading = 'Keuangan';

    public ?string $filter = null;

    protected function getFilters(): ?array
    {
        return Periode::orderBy('tahun', 'desc')
            ->pluck('nama_periode', 'id')
            ->toArray();
    }

    protected function getData(): array
    {
        $periodeId = $this->filter ?? Periode::latest()->first()?->id;

        $pendapatan = Pembayaran::where('status', 'lunas')
            ->where('periode_id', $periodeId)
            ->sum('jumlah_bayar');

        $tagihanBelumBayar = Pembayaran::where('status', 'belum_lunas')
            ->where('periode_id', $periodeId)
            ->count();

        // Kalau tidak ada data sama sekali
        if ($pendapatan == 0 && $tagihanBelumBayar == 0) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Keuangan',
                    'data' => [
                        $pendapatan,
                        $tagihanBelumBayar,
                    ],
                    'backgroundColor' => [
                        'rgba(34,197,94,0.7)',   // hijau
                        'rgba(249,115,22,0.7)',  // oranye
                    ],
                    'borderColor' => [
                        'rgba(34,197,94,1)',
                        'rgba(249,115,22,1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [
                'Pendapatan',
                'Tagihan Belum Bayar',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public function getDescription(): ?string
    {
        $periodeId = $this->filter ?? Periode::latest()->first()?->id;

        $pendapatan = Pembayaran::where('status', 'lunas')
            ->where('periode_id', $periodeId)
            ->sum('jumlah_bayar');

        $tagihanBelumBayar = Pembayaran::where('status', 'belum_lunas')
            ->where('periode_id', $periodeId)
            ->count();

        if ($pendapatan == 0 && $tagihanBelumBayar == 0) {
            return "Belum ada data pada periode ini.";
        }

        return null;
    }
}

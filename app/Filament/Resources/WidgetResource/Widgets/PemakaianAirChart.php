<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pemakaian;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\ChartWidget;

class PemakaianAirChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pemakaian Air per Periode';

    public ?string $filter = null;

    protected function getFilters(): ?array
    {
        return Periode::query()
            ->selectRaw('DISTINCT tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun', 'tahun')
            ->toArray();
    }

    protected function getData(): array
    {
        $user = Auth::user();
        $tahun = $this->filter ?? Periode::max('tahun');

        // Ambil semua periode dalam tahun itu
        $periodes = Periode::where('tahun', $tahun)
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        $labels = [];
        $data = [];

        foreach ($periodes as $periode) {
            $labels[] = $periode->nama_periode;

            if (in_array($user->role_id, [1, 2])) {
                // Admin & Petugas → tampilkan total semua pelanggan
                $data[] = Pemakaian::where('periode_id', $periode->id)
                    ->sum('total_pakai');
            } elseif ($user->role_id === 3 && $user->pelanggan) {
                // Pelanggan → tampilkan hanya miliknya
                $data[] = Pemakaian::where('periode_id', $periode->id)
                    ->where('pelanggan_id', $user->pelanggan->id)
                    ->sum('total_pakai');
            } else {
                $data[] = 0; // fallback
            }
        }

        return [
            'datasets' => [
                [
                    'label' => $user->role_id === 3 
                        ? 'Pemakaian Air Saya (m³)' 
                        : 'Pemakaian Air Semua Pelanggan (m³)',
                    'data' => $data,
                    'backgroundColor' => $user->role_id === 3 ? '#06b6d4' : '#10b981',
                    'borderColor' => $user->role_id === 3 ? '#0284c7' : '#047857',
                    'borderWidth' => 2,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // bisa diubah 'line' kalau ingin trend
    }
}

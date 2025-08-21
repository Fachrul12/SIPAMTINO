<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        Periode::create([
            'nama_periode' => 'Periode 1',
            'bulan' => 'Januari',
            'tahun' => 2025,
            'status' => 'aktif',
        ]);

        Periode::create([
            'nama_periode' => 'Periode 2',
            'bulan' => 'Februari',
            'tahun' => 2025,
            'status' => 'nonaktif',
        ]);

        Periode::create([
            'nama_periode' => 'Periode 3',
            'bulan' => 'Maret',
            'tahun' => 2025,
            'status' => 'Nonaktif',
        ]);

        Periode::create([
            'nama_periode' => 'Periode 4',
            'bulan' => 'April',
            'tahun' => 2025,
            'status' => 'nonaktif',
        ]);

        Periode::create([
            'nama_periode' => 'Periode 5',
            'bulan' => 'Mei',
            'tahun' => 2025,
            'status' => 'Nonaktif',
        ]);

        Periode::create([
            'nama_periode' => 'Periode 6',
            'bulan' => 'Juni',
            'tahun' => 2025,
            'status' => 'nonaktif',
        ]);
    }
}

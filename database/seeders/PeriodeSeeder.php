<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        Periode::create([
            'nama_periode' => 'Periode Januari 2025',
            'bulan' => 'Januari',
            'tahun' => 2025,
            'status' => 'aktif',
        ]);

        Periode::create([
            'nama_periode' => 'Periode Desember 2024',
            'bulan' => 'Desember',
            'tahun' => 2024,
            'status' => 'nonaktif',
        ]);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class ProcessTurbidityHourly extends Command
{
    protected $signature = 'turbidity:process-hourly';
    protected $description = 'Ambil data dari Redis, hitung avg/max/min, lalu simpan ke MySQL tiap jam';

    public function handle()
    {
        // Ambil semua data buffer dari Redis
        $buffer = Redis::lrange('turbidity:buffer', 0, -1);

        if (empty($buffer)) {
            $this->warn('Tidak ada data turbidity di buffer Redis.');
            return;
        }

        // Konversi ke float
        $values = array_map('floatval', $buffer);

        $avg = array_sum($values) / count($values);
        $max = max($values);
        $min = min($values);

        // Simpan ke MySQL sesuai schema
        DB::table('turbidity_summaries')->insert([
            'avg'       => $avg,
            'min'       => $min,
            'max'       => $max,
            'period'    => now()->startOfHour(), // waktu periode jam ini
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        // Kosongkan buffer setelah diproses
        Redis::del('turbidity:buffer');

        $this->info("Turbidity hourly report disimpan. AVG={$avg}, MAX={$max}, MIN={$min}");
    }
}

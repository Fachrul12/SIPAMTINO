<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarif;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifs = [
            [
                'nama_tarif' => 'Rumah Tangga A',
                'biaya_per_m3' => 5000,  
                'beban' => 11000,              
            ],
            [
                'nama_tarif' => 'Rumah Tangga B',
                'biaya_per_m3' => 10000,
                'beban' => 11000,
                
            ],            
        ];

        foreach ($tarifs as $tarif) {
            Tarif::create($tarif);
        }
    }
}

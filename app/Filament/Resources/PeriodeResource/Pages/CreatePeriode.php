<?php

namespace App\Filament\Resources\PeriodeResource\Pages;

use App\Filament\Resources\PeriodeResource;
use App\Models\Periode;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePeriode extends CreateRecord
{
    protected static string $resource = PeriodeResource::class;

    protected function beforeCreate(): void
    {
        $bulan = $this->data['bulan'];
        $tahun = $this->data['tahun'];

        if (Periode::where('bulan', $bulan)->where('tahun', $tahun)->exists()) {
            Notification::make()
                ->title('Periode sudah ada')
                ->body("Periode untuk {$bulan} {$tahun} sudah dibuat sebelumnya.")
                ->danger()
                ->send();

            $this->halt(); // hentikan proses create
        }
    }
}

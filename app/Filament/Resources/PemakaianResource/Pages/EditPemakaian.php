<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use App\Filament\Resources\PemakaianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPemakaian extends EditRecord
{
    protected static string $resource = PemakaianResource::class;    


    protected function mutateFormDataBeforeSave(array $data): array
{
    // Gunakan data dari record jika field tidak dikirim dari form
    $pelangganId = $data['pelanggan_id'] ?? $this->record->pelanggan_id;
    $periodeId   = $data['periode_id'] ?? $this->record->periode_id;

    // Ambil meter_awal dari periode sebelumnya
    $lastPemakaian = \App\Models\Pemakaian::where('pelanggan_id', $pelangganId)
        ->where('periode_id', '<', $periodeId)
        ->latest('id')
        ->first();

    $meterAwal = $lastPemakaian ? $lastPemakaian->meter_akhir : 0;
    $data['meter_awal'] = $meterAwal;

    // Hitung total pemakaian
    $data['total_pakai'] = max(0, ($data['meter_akhir'] ?? $this->record->meter_akhir) - $meterAwal);

    // Hitung tagihan
    $pelanggan = \App\Models\Pelanggan::with('tarif')->find($pelangganId);
    if ($pelanggan && $pelanggan->tarif) {
        $data['tagihan'] = ($data['total_pakai'] * $pelanggan->tarif->biaya_per_m3)
                         + $pelanggan->tarif->beban;
    }

    return $data;
}




}

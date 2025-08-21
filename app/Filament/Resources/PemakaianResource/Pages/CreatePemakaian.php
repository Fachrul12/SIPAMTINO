<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use App\Filament\Resources\PemakaianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePemakaian extends CreateRecord
{
    protected static string $resource = PemakaianResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    // ambil meter_awal dari periode sebelumnya
    $lastPemakaian = \App\Models\Pemakaian::where('pelanggan_id', $data['pelanggan_id'])
        ->where('periode_id', '<', $data['periode_id'])
        ->latest('id')
        ->first();

    $data['meter_awal'] = $lastPemakaian ? $lastPemakaian->meter_akhir : 0;

    // hitung total_pakai
    $data['total_pakai'] = max(0, $data['meter_akhir'] - $data['meter_awal']);

    // hitung tagihan
    $pelanggan = \App\Models\Pelanggan::with('tarif')->find($data['pelanggan_id']);
    if ($pelanggan && $pelanggan->tarif) {
        $data['tagihan'] = ($data['total_pakai'] * $pelanggan->tarif->biaya_per_m3)
                         + $pelanggan->tarif->beban;
    }

    return $data;
}

protected function mutateFormDataBeforeSave(array $data): array
{
    return $this->mutateFormDataBeforeCreate($data);
}

}

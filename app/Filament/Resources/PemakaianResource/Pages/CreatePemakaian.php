<?php

namespace App\Filament\Resources\PemakaianResource\Pages;

use App\Filament\Resources\PemakaianResource;
use Filament\Actions;
use App\Models\Periode;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;



class CreatePemakaian extends CreateRecord
{
    protected static string $resource = PemakaianResource::class;

    public function mount(): void
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();

        if (! $periodeAktif) {
            Notification::make()
                ->title('Belum ada periode aktif saat ini')
                ->danger()
                ->send();

            $this->redirect(static::$resource::getUrl('index')); // kembali ke index, tidak ke create
        }

        parent::mount(); // hanya dijalankan kalau ada periode aktif
    }

 

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

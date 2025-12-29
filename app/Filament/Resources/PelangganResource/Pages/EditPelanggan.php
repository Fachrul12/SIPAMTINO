<?php

namespace App\Filament\Resources\PelangganResource\Pages;

use App\Filament\Resources\PelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPelanggan extends EditRecord
{
    protected static string $resource = PelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record;
        if ($record && $record->user) {
            $data['name'] = $record->user->name;
            $data['email'] = $record->user->email;
            $data['no_hp'] = $record->no_hp ?: $record->user->no_hp;
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
{
    $record = $this->record;

    if ($record && $record->user) {
        $userData = [
            'name' => $data['name'] ?? $record->user->name,
            'email' => $data['email'] ?? $record->user->email,
        ];

        // Update nomor HP di tabel users dan pelanggans
        if (!empty($data['no_hp'])) {
            $userData['no_hp'] = $data['no_hp'];
            $record->no_hp = $data['no_hp'];
        }

        // Update password hanya jika diisi
        if (!empty($data['password'])) {
            $userData['password'] = bcrypt($data['password']);
        }

        // Simpan ke tabel users
        $record->user->update($userData);

        // Simpan tarif pelanggan jika berubah
        $record->tarif_id = $data['tarif_id'] ?? $record->tarif_id;
        $record->save();
    }

    // Hapus field non-pelanggan agar tidak error saat disimpan di tabel pelanggan
    unset($data['name'], $data['email'], $data['password']);

    // Return hanya field milik tabel pelanggan
    return [
        'no_hp' => $data['no_hp'] ?? null,
        'tarif_id' => $data['tarif_id'] ?? null,
    ];
}

}

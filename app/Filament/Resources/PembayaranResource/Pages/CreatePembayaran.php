<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Models\Pembayaran;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePembayaran extends CreateRecord
{
    protected static string $resource = PembayaranResource::class;

    public function getTitle(): string
    {
        return 'Tambah Pembayaran';
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Find the existing pembayaran record to update
        $existingPembayaran = Pembayaran::where('pemakaian_id', $data['pemakaian_id'])
            ->where('periode_id', $data['periode_id'])
            ->where('status', 'belum_lunas')
            ->first();

        if ($existingPembayaran) {
            // Update existing record
            $existingPembayaran->update([
                'status' => 'lunas',
                'tanggal_bayar' => now(),
            ]);

            Notification::make()
                ->title('Pembayaran berhasil!')
                ->body('Status pembayaran telah diubah menjadi lunas.')
                ->success()
                ->send();

            return $existingPembayaran;
        }

        // If no existing record, create new (fallback)
        return Pembayaran::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

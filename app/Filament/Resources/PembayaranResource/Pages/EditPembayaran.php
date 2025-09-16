<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Models\Pembayaran;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    public function getTitle(): string
    {
        return 'Edit Pembayaran';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Jika status diubah menjadi lunas, set tanggal bayar
        if ($data['status'] === 'lunas' && $record->status !== 'lunas') {
            $data['tanggal_bayar'] = now();
            
            Notification::make()
                ->title('Pembayaran berhasil diubah menjadi lunas!')
                ->success()
                ->send();
        }

        $record->update($data);

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

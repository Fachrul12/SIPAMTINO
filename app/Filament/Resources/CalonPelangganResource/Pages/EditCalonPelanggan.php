<?php

namespace App\Filament\Resources\CalonPelangganResource\Pages;

use App\Filament\Resources\CalonPelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCalonPelanggan extends EditRecord
{
    protected static string $resource = CalonPelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

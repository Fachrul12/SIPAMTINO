<?php

namespace App\Filament\Resources\CalonPelangganResource\Pages;

use App\Filament\Resources\CalonPelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCalonPelanggans extends ListRecords
{
    protected static string $resource = CalonPelangganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

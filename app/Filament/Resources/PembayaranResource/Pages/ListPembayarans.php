<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Filament\Resources\PembayaranResource\Widgets\PembayaranStatsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembayarans extends ListRecords
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('proses_pembayaran')
                ->label('Proses Pembayaran Baru')
                ->icon('heroicon-o-credit-card')
                ->color('success')
                ->url(fn (): string => static::getResource()::getUrl('index')),
        ];
    }

    public function getTitle(): string
    {
        return 'Riwayat Pembayaran';
    }
}

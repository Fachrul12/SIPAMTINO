<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

class ViewPembayaran extends ViewRecord
{
    protected static string $resource = PembayaranResource::class;

    public function getTitle(): string
    {
        return 'Detail Pembayaran';
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Pelanggan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('pemakaian.pelanggan.user.name')
                                    ->label('Nama Pelanggan')
                                    ->weight('bold'),
                                    
                                TextEntry::make('periode.nama_periode')
                                    ->label('Periode')
                                    ->badge()
                                    ->color('gray'),
                            ])
                    ]),

                Section::make('Detail Pembayaran')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('jumlah_bayar')
                                    ->label('Jumlah Tagihan')
                                    ->money('IDR')
                                    ->size('lg')
                                    ->weight('bold'),

                                TextEntry::make('jumlah_dibayar')
                                    ->label('Jumlah Dibayar')
                                    ->money('IDR')
                                    ->placeholder('Belum dibayar')
                                    ->size('lg'),

                                TextEntry::make('kembalian')
                                    ->label('Kembalian')
                                    ->money('IDR')
                                    ->placeholder('—')
                                    ->size('lg')
                                    ->color('success'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Status Pembayaran')
                                    ->badge()
                                    ->formatStateUsing(fn ($state) => match ($state) {
                                        'belum_lunas' => 'Belum Lunas',
                                        'lunas' => 'Lunas',
                                        default => 'Belum Lunas',
                                    })
                                    ->color(fn ($state) => match ($state) {
                                        'belum_lunas' => 'danger',
                                        'lunas' => 'success',
                                        default => 'gray',
                                    }),

                                TextEntry::make('tanggal_bayar')
                                    ->label('Tanggal Pembayaran')
                                    ->dateTime('d/m/Y H:i')
                                    ->placeholder('Belum dibayar'),
                            ]),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('bayar')
                ->label('Proses Pembayaran')
                ->icon('heroicon-o-credit-card')
                ->color('success')
                ->url(fn (): string => static::getResource()::getUrl('index'))
                ->visible(fn ($record) => $record->status === 'belum_lunas'),
                
            Actions\Action::make('kembali')
                ->label('Kembali ke Riwayat')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(fn (): string => static::getResource()::getUrl('list')),
        ];
    }
}

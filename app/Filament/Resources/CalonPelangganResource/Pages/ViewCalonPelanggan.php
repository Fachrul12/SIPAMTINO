<?php

namespace App\Filament\Resources\CalonPelangganResource\Pages;

use App\Filament\Resources\CalonPelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Support\Facades\Storage;

class ViewCalonPelanggan extends ViewRecord
{
    protected static string $resource = CalonPelangganResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Data Calon Pelanggan')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Lengkap'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('no_hp')
                            ->label('Nomor HP'),
                        TextEntry::make('tarif.nama_tarif')
                            ->label('Tarif'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pending',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                default => $state,
                            }),
                        TextEntry::make('created_at')
                            ->label('Tanggal Pendaftaran')
                            ->dateTime('d F Y, H:i'),
                    ])
                    ->columns(2),
                    
                Section::make('File KTP')
                    ->schema([
                        ImageEntry::make('ktp_path')
                            ->label('KTP')
                            ->disk('public')
                            ->visible(fn ($record) => $record->ktp_path && in_array(pathinfo($record->ktp_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])),
                        TextEntry::make('ktp_path')
                            ->label('File KTP')
                            ->formatStateUsing(fn ($state) => $state ? 'File PDF - ' . basename($state) : 'Tidak ada file')
                            ->url(fn ($record) => $record->ktp_path ? Storage::url($record->ktp_path) : null)
                            ->openUrlInNewTab()
                            ->visible(fn ($record) => $record->ktp_path && pathinfo($record->ktp_path, PATHINFO_EXTENSION) === 'pdf'),
                    ])
                    ->visible(fn ($record) => !empty($record->ktp_path)),
                    
                Section::make('Status Pemrosesan')
                    ->schema([
                        TextEntry::make('processed_at')
                            ->label('Tanggal Diproses')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Belum diproses'),
                        TextEntry::make('processedBy.name')
                            ->label('Diproses Oleh')
                            ->placeholder('Belum diproses'),
                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Tidak ada keterangan'),
                    ])
                    ->visible(fn ($record) => $record->status !== 'pending'),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(false), // Disable edit untuk view only
        ];
    }
}

<?php

namespace App\Filament\Resources\PengaduanResource\Pages;

use App\Filament\Resources\PengaduanResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Illuminate\Support\Facades\Auth;


use Filament\Notifications\Notification;

class ViewPengaduan extends ViewRecord
{
    protected static string $resource = PengaduanResource::class;

    public function infolist(Infolists\Infolist $infolist): Infolists\Infolist
{
    if (Auth::user()->role_id === 1) {
        // Admin lihat detail lengkap
        return $infolist
            ->schema([
                Section::make('Detail Pengaduan')
                    ->schema([
                        Grid::make(2) // 2 kolom
                            ->schema([
                                TextEntry::make('id')->label('No. Pengaduan'),
                                TextEntry::make('user.name')->label('Nama Pelanggan'),
                                TextEntry::make('jenis_pengaduan')->label('Jenis'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn ($state) => $state === 'Selesai' ? 'success' : 'danger'),
                            ]),

                        TextEntry::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull(),

                        ImageEntry::make('foto')
                            ->label('Foto')
                            ->disk('public')
                            ->size(400)
                            ->square()
                            ->visibility('public')
                            ->getStateUsing(fn ($record) => $record->foto)
                            ->extraAttributes([
                                'style' => 'cursor: pointer; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);'
                            ])
                            ->columnSpanFull()
                            ->hiddenLabel(false),
                        
                    ]),
            ]);
    }

    // Pelanggan lihat detail lebih sederhana
    return $infolist
        ->schema([
            Section::make('Detail Pengaduan')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('id')->label('No. Pengaduan'),
                            TextEntry::make('jenis_pengaduan')->label('Jenis'),
                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn ($state) => $state === 'Selesai' ? 'success' : 'danger'),
                        ]),

                    TextEntry::make('deskripsi')
                        ->label('Deskripsi')
                        ->columnSpanFull(),

                    ImageEntry::make('foto')
                        ->label('Foto')
                        ->disk('public')
                        ->size(400)
                        ->square()
                        ->visibility('public')
                        ->getStateUsing(fn ($record) => $record->foto)
                        ->extraAttributes([
                            'style' => 'cursor: pointer; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);'
                        ])
                        ->columnSpanFull()
                        ->hiddenLabel(false),
                    
                ]),
        ]);
}
    /**
     * Tombol actions di halaman View
     */
    protected function getHeaderActions(): array
    {
        $actions = [];

        if (Auth::user()->role_id === 1) {
            // Hanya admin yang bisa ubah status
            $actions[] = Actions\Action::make('selesai')
                ->label('Tandai Selesai')
                ->visible(fn () => $this->record->status === 'Belum Diproses')
                ->action(function () {
                    $this->record->update(['status' => 'Selesai']);

                    Notification::make()
                        ->title('Pengaduan berhasil ditandai sebagai Selesai')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check-circle');
        }

        return $actions;
    }   
}

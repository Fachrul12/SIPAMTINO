<?php

namespace App\Filament\Resources\PengaduanResource\Pages;

use App\Filament\Resources\PengaduanResource;
use Filament\Resources\Pages\ViewRecord;
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
        $isAdmin = Auth::user()->role_id === 1;

        return $infolist
            ->schema([
                Section::make('Detail Pengaduan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('No. Pengaduan')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('jenis_pengaduan')
                                    ->label('Jenis')
                                    ->badge()
                                    ->color('info'),

                                // Admin bisa lihat nama pelanggan
                                TextEntry::make('user.name')
                                    ->label('Nama Pelanggan')
                                    ->visible($isAdmin),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn ($state) => $state === 'Selesai' ? 'success' : 'warning'),
                            ]),

                        TextEntry::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->placeholder('- Tidak ada deskripsi -')
                            ->extraAttributes([
                                'style' => 'font-size:14px; line-height:1.6; color:#374151;'
                            ]),

                        Section::make('Lampiran Foto')
                            ->schema([
                                ImageEntry::make('foto')
                                    ->label('')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->size(500) // lebar max
                                    ->extraAttributes([
                                        'style' => 'border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-top:12px; max-width:100%; height:auto;'
                                    ])
                                    ->getStateUsing(fn ($record) => $record->foto),
                            ])
                            ->collapsible()
                            ->collapsed(false)
                            ->columnSpanFull(),
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

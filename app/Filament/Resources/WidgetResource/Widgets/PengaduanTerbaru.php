<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Pengaduan;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Support\Facades\Auth;

class PengaduanTerbaru extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Pengaduan Terbaru';

    public function table(Tables\Table $table): Tables\Table
    {
        $user = Auth::user();

        // === Query untuk admin/petugas ===
        if (in_array($user->role_id, [1, 2])) {
            $query = Pengaduan::latest()->limit(5);
        } 
        // === Query untuk pelanggan (hanya miliknya) ===
        elseif ($user->role_id === 3) {
            $query = Pengaduan::where('user_id', $user->id)
                ->latest()
                ->limit(5);
        } else {
            // fallback, tidak ada data
            $query = Pengaduan::whereRaw('0 = 1');
        }

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->visible(in_array($user->role_id, [1, 2])), // sembunyikan kolom ini kalau pelanggan login

                Tables\Columns\TextColumn::make('jenis_pengaduan')
                    ->label('Jenis'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state === 'Selesai' ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
            ]);
    }
}

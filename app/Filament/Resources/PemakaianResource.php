<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemakaianResource\Pages;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class PemakaianResource extends Resource
{
    protected static ?string $model = Pemakaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Catat Pemakaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->label('Nama Pelanggan')
                    ->options(
                        Pelanggan::with('user')
                            ->whereHas('user', fn ($q) => $q->where('role_id', 3))
                            ->get()
                            ->pluck('user.name', 'id')
                    )
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->rules(fn ($get) => [
                        Rule::unique('pemakaians', 'pelanggan_id')
                            ->where(fn ($query) => $query->where('periode_id', $get('periode_id')))
                    ])
                    ->validationMessages([
                        'unique' => 'Pelanggan untuk periode yang dipilih sudah dibuat.',
                    ])
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $lastPemakaian = Pemakaian::where('pelanggan_id', $state)
                                ->latest('id')
                                ->first();
                            $set('meter_awal', $lastPemakaian ? $lastPemakaian->meter_akhir : 0);
                        }
                    }),

                Forms\Components\Select::make('periode_id')
                    ->label('Periode')
                    ->options(Periode::where('status', 'aktif')->pluck('nama_periode', 'id'))
                    ->required(),

                Forms\Components\TextInput::make('meter_awal')
                    ->label('Meter Awal')
                    ->numeric()
                    ->disabled(),

                Forms\Components\TextInput::make('meter_akhir')
                    ->label('Meter Akhir')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $meterAwal = $get('meter_awal') ?? 0;
                        $total = $state - $meterAwal;
                        $set('total_pakai', $total);

                        $pelangganId = $get('pelanggan_id');
                        if ($pelangganId) {
                            $pelanggan = Pelanggan::with('tarif')->find($pelangganId);
                            if ($pelanggan && $pelanggan->tarif) {
                                $biayaPerM3 = $pelanggan->tarif->biaya_per_m3;
                                $beban = $pelanggan->tarif->beban;
                                $tagihan = ($total * $biayaPerM3) + $beban;
                                $set('tagihan', $tagihan);
                            }
                        }
                    }),

                Forms\Components\TextInput::make('total_pakai')
                    ->label('Jumlah Pemakaian (m³)')
                    ->disabled(),

                Forms\Components\TextInput::make('tagihan')
                    ->label('Tagihan (Rp)')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.user.name')
                    ->label('Nama Pelanggan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('periode.nama_periode')
                    ->label('Periode')
                    ->sortable(),

                Tables\Columns\TextColumn::make('meter_awal')
                    ->label('Meter Awal'),

                Tables\Columns\TextColumn::make('meter_akhir')
                    ->label('Meter Akhir'),

                Tables\Columns\TextColumn::make('total_pakai')
                    ->label('Jumlah Pemakaian (m³)')
                    ->getStateUsing(fn ($record) => $record->meter_akhir - $record->meter_awal)
                    ->sortable(),

                Tables\Columns\TextColumn::make('tagihan')
                    ->label('Tagihan (Rp)')
                    ->getStateUsing(fn ($record) => 
                        (($record->meter_akhir - $record->meter_awal) * $record->pelanggan->tarif->biaya_per_m3)
                        + $record->pelanggan->tarif->beban
                    )
                    ->money('IDR'),

                BadgeColumn::make('pembayaran.status')
                    ->label('Status')
                    ->colors([
                        'danger'  => 'belum_bayar',
                        'success' => 'lunas',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'belum_bayar' => 'Belum Lunas',
                        'lunas' => 'Lunas',
                        default => 'Belum Lunas',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('periode_id')
                    ->label('Filter Periode')
                    ->relationship('periode', 'nama_periode')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPemakaians::route('/'),
            'create' => Pages\CreatePemakaian::route('/create'),
            'edit'   => Pages\EditPemakaian::route('/{record}/edit'),
        ];
    }
}

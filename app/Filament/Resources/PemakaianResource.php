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
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;



class PemakaianResource extends Resource
{
    protected static ?string $model = Pemakaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Pemakaian';

    /** =======================
     *  AUTHORIZATION
     *  ======================= */
    // public static function canViewAny(): bool
    // {
    //     return Auth::user()->role_id !== 3; // pelanggan tidak bisa akses
    // }

    // public static function canView($record): bool
    // {
    //     return Auth::user()->role_id !== 3;
    // }

    public static function canCreate(): bool
    {
        return Auth::user()->role_id === 2; // hanya petugas
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->role_id === 2;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role_id === 2;
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()->role_id === 2;
    }

    /** =======================
     *  FORM
     *  ======================= */
    public static function form(Form $form): Form
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();

        if (! $periodeAktif) {
            Notification::make()
                ->title('Belum ada periode aktif saat ini')
                ->danger()
                ->send();

            return $form->schema([]); // form kosong
        }

        return $form->schema([
            Forms\Components\Grid::make(12)
                ->schema([
                    // Kolom kiri (scanner)
                    Forms\Components\Section::make('Scan QR Code')
                        ->schema([
                            ViewField::make('scan_qr')
                                ->label('')
                                ->view('filament.forms.components.scan-qr'),
                        ])
                        ->columnSpan([
                            'default' => 12,
                            'md' => 4,    
                        ]),

                    // Kolom kanan (form data)
                    Forms\Components\Section::make('Data Pemakaian')
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
                                ->rules([
                                    Rule::unique('pemakaians', 'pelanggan_id')
                                        ->where(fn ($query) => $query->where('periode_id', Periode::where('status', 'aktif')->value('id')))
                                ])
                                
                                ->validationMessages([
                                    'unique' => 'Pelanggan untuk periode yang dipilih sudah dibuat.',
                                ])
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    if ($state) {
                                        $lastPemakaian = Pemakaian::where('pelanggan_id', $state)
                                            ->orderByDesc('id')
                                            ->first();

                                        $set('meter_awal', $lastPemakaian ? $lastPemakaian->meter_akhir : 0);
                                    }
                                }),

                            Forms\Components\Grid::make(2)->schema([
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
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('periode_id')
                                ->label('Periode')
                                ->options(Periode::where('status', 'aktif')->pluck('nama_periode', 'id'))
                                ->default(Periode::where('status', 'aktif')->value('id'))
                                ->disabled()
                                ->dehydrated(true)
                                ->required(),
                            
                            
                            Forms\Components\TextInput::make('total_pakai')
                                ->label('Jumlah Pemakaian (m³)')
                                ->disabled()
                                ->dehydrated(true),
                            ]),

                            Forms\Components\TextInput::make('tagihan')
                                ->label('Tagihan (Rp)')
                                ->disabled(),
                            ])
                            ->columnSpan([
                                'default' => 12, 
                                'md' => 8,      
                            ]),
            ]),
        ]);
    }

    /** =======================
     *  TABLE
     *  ======================= */
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
                    ->disabled()
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
                        'lunas'       => 'Lunas',
                        default       => 'Belum Lunas',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('periode_id')
                    ->label('Filter Periode')
                    ->options(Periode::pluck('nama_periode', 'id'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

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

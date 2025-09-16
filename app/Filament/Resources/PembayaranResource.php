<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use App\Models\Pelanggan;
use App\Models\Periode;
use App\Models\Pemakaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Model;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Pembayaran';
    protected static ?string $modelLabel = 'Pembayaran';
    protected static ?string $pluralModelLabel = 'Pembayaran';

    /** =======================
     *  AUTHORIZATION
     *  ======================= */
    public static function shouldRegisterNavigation(): bool
    {
    return in_array(Auth::user()->role_id, [1, 2]);
    }

    public static function canViewAny(): bool
    {
    return in_array(Auth::user()->role_id, [1, 2]);
    }

    public static function canCreate(): bool
    {
        return Auth::user()->role_id === 1 || Auth::user()->role_id === 2; // admin dan petugas
    }    

    public static function canEdit($record): bool
    {
        return Auth::user()->role_id === 1;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role_id === 1;
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()->role_id === 1;
    }

    /** =======================
     *  FORM
     *  ======================= */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pemakaian_id')
                    ->label('Pemakaian')
                    ->options(function () {
                        return Pemakaian::with(['pelanggan.user', 'periode'])
                            ->whereHas('pembayaran', function ($query) {
                                $query->where('status', 'belum_lunas');
                            })
                            ->get()
                            ->mapWithKeys(function ($pemakaian) {
                                return [
                                    $pemakaian->id => 
                                        ($pemakaian->pelanggan->user->name ?? 'N/A') . 
                                        ' - ' . 
                                        ($pemakaian->periode->nama_periode ?? 'N/A')
                                ];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $pembayaran = Pembayaran::where('pemakaian_id', $state)
                                ->where('status', 'belum_lunas')
                                ->first();
                            
                            if ($pembayaran) {
                                $set('periode_id', $pembayaran->periode_id);
                                $set('jumlah_bayar', $pembayaran->jumlah_bayar);
                            }
                        }
                    }),

                Forms\Components\Select::make('periode_id')
                    ->label('Periode')
                    ->options(Periode::pluck('nama_periode', 'id'))
                    ->disabled()
                    ->dehydrated(true),

                Forms\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('jumlah_bayar')
                                    ->label('Jumlah Tagihan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0, ',', '.')),

                                Forms\Components\TextInput::make('jumlah_dibayar')
                                    ->label('Jumlah Dibayar')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        $jumlahTagihan = $get('jumlah_bayar') ?? 0;
                                        $kembalian = max(0, (float)$state - (float)$jumlahTagihan);
                                        $set('kembalian', $kembalian);
                                    }),
                            ]),

                        Forms\Components\TextInput::make('kembalian')
                            ->label('Kembalian')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0, ',', '.')),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'belum_lunas' => 'Belum Lunas',
                                'lunas' => 'Lunas',
                            ])
                            ->default('lunas')
                            ->required(),

                        Forms\Components\DateTimePicker::make('tanggal_bayar')
                            ->label('Tanggal Bayar')
                            ->default(now()),
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
                Tables\Columns\TextColumn::make('pemakaian.pelanggan.user.name')
                    ->label('Pelanggan')
                    ->sortable()
                    ->searchable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('periode.nama_periode')
                    ->label('Periode')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_bayar')
                    ->label('Tagihan')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_dibayar')
                    ->label('Dibayar')
                    ->money('IDR')
                    ->placeholder('—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kembalian')
                    ->label('Kembalian')
                    ->money('IDR')
                    ->placeholder('—')
                    ->color('success'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => 'belum_lunas',
                        'success' => 'lunas',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'belum_lunas' => 'Belum Lunas',
                        'lunas' => 'Lunas',
                        default => 'Belum Lunas',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->label('Tanggal Bayar')
                    ->date('d/m/Y H:i')
                    ->placeholder('Belum dibayar')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'belum_lunas' => 'Belum Lunas',
                        'lunas' => 'Lunas',
                    ])
                    ->default(''),
                    
                Tables\Filters\SelectFilter::make('periode_id')
                    ->label('Filter Periode')
                    ->options(Periode::pluck('nama_periode', 'id'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('bayar')
                    ->label('Bayar')
                    ->icon('heroicon-o-credit-card')
                    ->color('success')
                    ->url(fn () => static::getResource()::getUrl('index'))
                    ->visible(fn ($record) => $record->status === 'belum_lunas'),
                    
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\BayarLangsung::route('/'),  // Langsung ke pembayaran langsung
            'list' => Pages\ListPembayarans::route('/list'),  // Pindah ke /list
            'create' => Pages\CreatePembayaran::route('/create'),
            'bayar-langsung' => Pages\BayarLangsung::route('/bayar-langsung'),
            'view' => Pages\ViewPembayaran::route('/{record}'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
    
}

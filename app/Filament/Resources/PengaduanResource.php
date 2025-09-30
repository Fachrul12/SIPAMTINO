<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaduanResource\Pages;
use App\Models\Pengaduan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Pengaduan';

    public static function canCreate(): bool
    {
        return Auth::user()->role_id === 3; // hanya pelanggan
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Buat Pengaduan')
                    ->schema([
                        Forms\Components\Select::make('jenis_pengaduan')
                            ->label('Jenis Pengaduan')
                            ->options([
                                'Pipa Bocor' => 'Pipa Bocor',
                                'Meteran Rusak' => 'Meteran Rusak',
                                'Meteran Bocor' => 'Meteran Bocor',
                                'Air Keruh' => 'Air Keruh',
                            ])
                            ->required()
                            ->columnSpan(12),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->placeholder('Jelaskan masalah yang Anda alami secara detail...')
                            ->columnSpan(12),

                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto')
                            ->image()
                            ->directory('pengaduan-foto')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])
                            ->maxSize(2048) // 2MB dalam kilobytes
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->helperText('Format: JPG, JPEG, PNG, GIF. Maksimal ukuran: 2MB')
                            ->columnSpan(12),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->formatStateUsing(function ($record) {
                        if (Auth::user()->role_id === 3) {
                            return \App\Models\Pengaduan::where('user_id', $record->user_id)
                                ->where('id', '<=', $record->id)
                                ->count();
                        }
                        return $record->id;
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pelanggan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis_pengaduan')
                    ->label('Jenis')
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'Belum Diproses',
                        'success' => 'Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->visible(fn ($record) => Auth::user()->role_id === 1 && $record->status === 'Belum Diproses')
                    ->action(fn ($record) => $record->update(['status' => 'Selesai']))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaduans::route('/'),
            'create' => Pages\CreatePengaduan::route('/create'),
            'view' => Pages\ViewPengaduan::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // filter milik sendiri jika pelanggan (role_id = 3)
        if (Auth::user()->role_id === 3) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Belum Diproses')->count();
    }

}

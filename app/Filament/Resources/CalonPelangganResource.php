<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalonPelangganResource\Pages;
use App\Filament\Resources\CalonPelangganResource\RelationManagers;
use App\Models\CalonPelanggan;
use App\Models\User;
use App\Models\Role;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\Alignment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;

class CalonPelangganResource extends Resource
{
    protected static ?string $model = CalonPelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Calon Pelanggan';
    protected static ?string $navigationGroup = 'Manajemen User';
    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return Auth::user()->role_id === 1; // Hanya admin
    }    


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->disabled()
                    ->dehydrated(false),
                    
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->disabled()
                    ->dehydrated(false),
                    
                Forms\Components\TextInput::make('no_hp')
                    ->label('Nomor HP')
                    ->disabled()
                    ->dehydrated(false),
                    
                Forms\Components\Select::make('tarif_id')
                    ->label('Tarif')
                    ->relationship('tarif', 'nama_tarif')
                    ->disabled()
                    ->dehydrated(false),
                    
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->disabled()
                    ->dehydrated(false),
                    
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('tarif.nama_tarif')
                    ->label('Tarif')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
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
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('processed_at')
                    ->label('Tanggal Proses')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Action::make('lihat_ktp')
                    ->label('Lihat KTP')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (CalonPelanggan $record): string => $record->ktp_path ? Storage::url($record->ktp_path) : '#')
                    ->openUrlInNewTab()
                    ->visible(fn (CalonPelanggan $record): bool => !empty($record->ktp_path)),
                    
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->form([
                        Textarea::make('keterangan')
                            ->label('Keterangan (opsional)')
                            ->rows(3),
                    ])
                    ->action(function (CalonPelanggan $record, array $data): void {
                        $record->approve(Auth::id(), $data['keterangan'] ?? null);
                        
                        Notification::make()
                            ->title('Berhasil!')
                            ->body('Calon pelanggan berhasil disetujui dan akun telah dibuat.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (CalonPelanggan $record): bool => $record->status === 'pending')
                    ->requiresConfirmation(),
                    
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->form([
                        Textarea::make('keterangan')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (CalonPelanggan $record, array $data): void {
                        $record->reject(Auth::id(), $data['keterangan']);
                        
                        Notification::make()
                            ->title('Berhasil!')
                            ->body('Calon pelanggan berhasil ditolak.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (CalonPelanggan $record): bool => $record->status === 'pending')
                    ->requiresConfirmation(),
                    
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (CalonPelanggan $record): bool => $record->status !== 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn (): bool => Auth::user()->role_id === 1),
                ]),
            ]);
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
            'index' => Pages\ListCalonPelanggans::route('/'),
            'view' => Pages\ViewCalonPelanggan::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }
    
}

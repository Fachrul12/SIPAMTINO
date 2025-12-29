<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Tarif;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;    
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Kelola Pelanggan';
    protected static ?string $navigationGroup = 'Manajemen User';

    public static function canAccess(): bool
    {
        return Auth::user()->role_id === 1;
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Pelanggan')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->dehydrated(true)
            ->rule(function ($record) {        
                $userId = $record?->user_id ?? null;        
                return Rule::unique('users', 'email')->ignore($userId);
    }),

            Forms\Components\TextInput::make('no_hp')
                ->label('Nomor HP')
                ->tel()
                ->maxLength(15)
                ->required(),

            Forms\Components\Select::make('tarif_id')
                ->label('Tarif')
                ->relationship('tarif', 'nama_tarif')
                ->required(),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(fn (string $context): bool => $context === 'create')
                ->dehydrated(true), // biar tetap dikirim ke CreatePelanggan
            
        ]);
}





    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama Pelanggan')->searchable(),
                Tables\Columns\TextColumn::make('user.no_hp')->label('Nomor HP'),
                Tables\Columns\TextColumn::make('user.email')->label('Email'),
                Tables\Columns\TextColumn::make('tarif.nama_tarif')->label('Tarif'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(), 
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->recordUrl(null);           
    }

    public static function infolist(Infolist $infolist): Infolist
    {   
    return $infolist
        ->schema([
            TextEntry::make('user.name')->label('Nama'),
            TextEntry::make('user.email')->label('Email'),
            TextEntry::make('user.no_hp')->label('Nomor HP'),
            TextEntry::make('tarif.nama_tarif')->label('Jenis Tarif'),

            ViewEntry::make('qr_code')
                ->label('QR Code')
                ->view('filament.qr-code'),
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
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeSave(array $data): array
{
    if (isset($data['id'])) {
        $pelanggan = Pelanggan::find($data['id']);
        if ($pelanggan && $pelanggan->user) {
            $userData = [
                'name' => $data['name'] ?? $pelanggan->user->name,
                'email' => $data['email'] ?? $pelanggan->user->email,
            ];

            if (isset($data['no_hp'])) {
                $userData['no_hp'] = $data['no_hp'];
                $pelanggan->no_hp = $data['no_hp'];
            }

            if (!empty($data['password'])) {
                $userData['password'] = bcrypt($data['password']);
            }

            $pelanggan->user->update($userData);

            $pelanggan->tarif_id = $data['tarif_id'];
            $pelanggan->save();
        }
    }

    // Return only Pelanggan fields for saving to Pelanggan table
    $pelangganData = [
        'no_hp' => $data['no_hp'] ?? null,
        'tarif_id' => $data['tarif_id'],
    ];
    unset($data['name'], $data['email'], $data['password']); // Remove non-Pelanggan fields
    return array_merge($data, $pelangganData); // But since id and others may be there, merge to keep
}

}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TarifResource\Pages;
use App\Filament\Resources\TarifResource\RelationManagers;
use App\Models\Tarif;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TarifResource extends Resource
{
    protected static ?string $model = Tarif::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Kelola Tarif';
    protected static ?string $navigationGroup = 'Manajemen Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_tarif')
                    ->label('Nama Tarif')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('biaya_per_m3')
                    ->label('Biaya per m³')
                    ->numeric()
                    ->required(),
                
                Forms\Components\TextInput::make('beban')
                    ->label('Beban')
                    ->numeric()
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_tarif')
                    ->label('Nama Tarif')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('biaya_per_m3')
                    ->label('Biaya / m³')
                    ->money('IDR', true),
                
                Tables\Columns\TextColumn::make('beban')
                    ->label('Beban')
                    ->money('IDR', true),
                
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTarifs::route('/'),
            'create' => Pages\CreateTarif::route('/create'),
            'edit' => Pages\EditTarif::route('/{record}/edit'),
        ];
    }
}

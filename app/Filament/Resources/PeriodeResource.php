<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodeResource\Pages;
use App\Filament\Resources\PeriodeResource\RelationManagers;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeriodeResource extends Resource
{
    protected static ?string $model = Periode::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Periode';
    protected static ?string $navigationGroup = 'Manajemen Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_periode')
                    ->label('Nama Periode')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Contoh: Januari 2025'),

                Forms\Components\Select::make('bulan')
                    ->label('Bulan')            
                    ->options([
                        'Januari' => 'Januari',
                        'Februari' => 'Februari',
                        'Maret' => 'Maret',
                        'April' => 'April',
                        'Mei' => 'Mei',
                        'Juni' => 'Juni',
                        'Juli' => 'Juli',
                        'Agustus' => 'Agustus',
                        'September' => 'September',
                        'Oktober' => 'Oktober',
                        'November' => 'November',
                        'Desember' => 'Desember',
                    ])
                    ->required()
                    ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule, callable $get) {
                        return $rule->where('tahun', $get('tahun'));
                    }),

                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(date('Y') + 5)
                    ->default(date('Y'))
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status Periode')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ])
                    ->default('nonaktif')
                    ->required()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        if ($state === 'aktif') {
                            // Jika periode ini diaktifkan, periode lain dibuat nonaktif
                            Periode::where('id', '!=', $get('id'))->update(['status' => 'nonaktif']);
                        }
                    }),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_periode')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bulan')->sortable(),
                Tables\Columns\TextColumn::make('tahun')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'aktif',
                        'danger' => 'nonaktif',
                    ])
                    ->sortable(),
            ])
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
            'index' => Pages\ListPeriodes::route('/'),
            'create' => Pages\CreatePeriode::route('/create'),
            'edit' => Pages\EditPeriode::route('/{record}/edit'),
        ];
    }
}

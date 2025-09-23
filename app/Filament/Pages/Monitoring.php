<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Resources\WidgetResource\Widgets\TurbidityChart;
use Illuminate\Support\Facades\Auth;

class Monitoring extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Monitoring';
    protected static string $view = 'filament.pages.monitoring';
    protected static ?string $title = 'Monitoring Kekeruhan';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return Auth::user()->role_id === 4;
    }


    public $latest;
    public $chartData;

    protected function getHeaderWidgets(): array
    {
        return [
            TurbidityChart::class,
        ];
    }
}

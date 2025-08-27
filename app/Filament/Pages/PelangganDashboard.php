<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class PelangganDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Pelanggan';

    protected static string $view = 'filament.pages.pelanggan-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role_id === 3;
    }
}

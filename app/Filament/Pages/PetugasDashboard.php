<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class PetugasDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Petugas';
    protected static string $routePath = '/petugas/dashboard';
    protected static string $view = 'filament.pages.petugas-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role_id === 2;
    }
}

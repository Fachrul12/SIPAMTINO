<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Admin';

    protected static string $view = 'filament.pages.admin-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role_id === 1;
    }
}

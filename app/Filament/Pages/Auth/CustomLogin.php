<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;

class CustomLogin extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->placeholder('Masukkan email Anda')
            ->prefixIcon('heroicon-o-envelope')
            ->extraInputAttributes([
                'tabindex' => 1,
                'class' => 'pl-12 pr-4 py-4'
            ]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Kata Sandi')
            ->password()
            ->required()
            ->placeholder('Masukkan kata sandi Anda')
            ->prefixIcon('heroicon-o-lock-closed')
            ->extraInputAttributes([
                'tabindex' => 2,
                'class' => 'pl-12 pr-4 py-4'
            ]);
    }

    protected function getRememberFormComponent(): Component
    {
        return \Filament\Forms\Components\Checkbox::make('remember')
            ->label('Ingat saya')
            ->extraAttributes([
                'class' => 'rounded text-blue-600 focus:ring-blue-500'
            ]);
    }
}

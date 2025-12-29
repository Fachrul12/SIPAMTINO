<?php

namespace App\Filament\Resources\PelangganResource\Pages;

use App\Filament\Resources\PelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePelanggan extends CreateRecord
{
    protected static string $resource = PelangganResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'no_hp' => $data['no_hp'],
        'password' => bcrypt($data['password']),
        'role_id' => \App\Models\Role::where('name', 'pelanggan')->value('id'),
    ]);

    $data['user_id'] = $user->id;

    unset($data['name'], $data['email'], $data['no_hp'], $data['password']);

    return $data;
}

protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}

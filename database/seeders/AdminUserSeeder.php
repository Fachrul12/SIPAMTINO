<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Ganti sesuai kebutuhan
            [
                'name' => 'Administrator',
                'password' => Hash::make('1234'), // Ganti password
                'role_id' => $adminRole->id,
            ]
        );

        $PetugasRole = Role::where('name', 'petugas')->first();

        User::firstOrCreate(
            ['email' => 'petugas@gmail.com'], // Ganti sesuai kebutuhan
            [
                'name' => 'Petugas',
                'password' => Hash::make('1234'), // Ganti password
                'role_id' => $PetugasRole->id,
            ]
        );

        $PelangganRole = Role::where('name', 'pelanggan')->first();

        User::firstOrCreate(
            ['email' => 'yoga@gmail.com'], // Ganti sesuai kebutuhan
            [
                'name' => 'Yoga',
                'password' => Hash::make('1234'), // Ganti password
                'role_id' => $PelangganRole->id,
            ]
        );

        $PelangganRole = Role::where('name', 'pelanggan')->first();

        User::firstOrCreate(
            ['email' => 'rehan@gmail.com'], // Ganti sesuai kebutuhan
            [
                'name' => 'Rehan',
                'password' => Hash::make('1234'), // Ganti password
                'role_id' => $PelangganRole->id,
            ]
        );
    }
}

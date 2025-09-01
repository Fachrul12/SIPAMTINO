<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test users for all roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure roles exist
        $adminRole = Role::firstOrCreate(['id' => 1], ['nama' => 'Admin']);
        $petugasRole = Role::firstOrCreate(['id' => 2], ['nama' => 'Petugas']);
        $pelangganRole = Role::firstOrCreate(['id' => 3], ['nama' => 'Pelanggan']);

        // Create test users
        $admin = User::firstOrCreate(
            ['email' => 'admin@sipamtino.com'],
            [
                'name' => 'Admin SIPAMTINO',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'email_verified_at' => now(),
            ]
        );

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@sipamtino.com'],
            [
                'name' => 'Petugas SIPAMTINO',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'email_verified_at' => now(),
            ]
        );

        $pelanggan = User::firstOrCreate(
            ['email' => 'pelanggan@sipamtino.com'],
            [
                'name' => 'Pelanggan SIPAMTINO',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'email_verified_at' => now(),
            ]
        );

        $this->info('Test users created successfully!');
        $this->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@sipamtino.com', 'password'],
                ['Petugas', 'petugas@sipamtino.com', 'password'],
                ['Pelanggan', 'pelanggan@sipamtino.com', 'password'],
            ]
        );
    }
}

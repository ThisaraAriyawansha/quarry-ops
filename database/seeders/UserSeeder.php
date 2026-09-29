<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@quarryops.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'preferred_language' => 'en',
            ]
        );
        $admin->syncRoles(['Admin']);

        $cashier = User::firstOrCreate(
            ['email' => 'cashier@quarryops.com'],
            [
                'name' => 'Cashier',
                'password' => Hash::make('password'),
                'preferred_language' => 'en',
            ]
        );
        $cashier->syncRoles(['Cashier']);
    }
}

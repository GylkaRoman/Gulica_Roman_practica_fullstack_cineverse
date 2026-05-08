<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@cineverse.com'
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'balance' => 100000,
            ]
        );
    }
}

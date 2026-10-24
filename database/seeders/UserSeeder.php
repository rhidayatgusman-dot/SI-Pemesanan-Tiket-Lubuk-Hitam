<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin - login via WhatsApp + password
        User::create([
            'name' => 'Admin',
            'no_wa' => '6281234567890',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}

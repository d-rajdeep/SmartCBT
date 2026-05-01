<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        
        User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}
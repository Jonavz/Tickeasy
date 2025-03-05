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
            'name' => 'Administrador',
            'last_name' => 'Principal',
            'email' => 'admin@tickeasy.com',
            'password' => Hash::make('admin123'),
            'role' => 1 // 1 - Administrador
        ]);
    }
}

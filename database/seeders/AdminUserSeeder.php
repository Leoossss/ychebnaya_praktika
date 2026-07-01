<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@motosalon.ru',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Пользователь',
            'email' => 'user@motosalon.ru',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
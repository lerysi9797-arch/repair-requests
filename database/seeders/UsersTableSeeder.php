<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём диспетчера
        User::create([
            'name' => 'Диспетчер',
            'email' => 'dispatcher@test.com',
            'password' => Hash::make('123'),
            'role' => 'dispatcher',
        ]);

        // Создаём мастеров
        User::create([
            'name' => 'Мастер Иван',
            'email' => 'ivan@test.com',
            'password' => Hash::make('123'),
            'role' => 'master',
        ]);

        User::create([
            'name' => 'Мастер Пётр',
            'email' => 'petr@test.com',
            'password' => Hash::make('123'),
            'role' => 'master',
        ]);
    }
}

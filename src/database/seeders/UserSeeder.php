<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => Hash::make('1qaz2wsx'),
            'role' => 1,
        ]);
        User::create([
            'name' => 'テスト用店長',
            'email' => 'Manager@example.com',
            'password' => Hash::make('Password123!'),
            'role' => 2,
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('1qaz2wsx'),
            'email_verified_at' => Carbon::now(),
            'role' => 3,
        ]);
    }
}
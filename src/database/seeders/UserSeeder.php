<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'ぬこ',
            'email' => 'kindhopes.field@gmail.com',
            'password' => Hash::make('1qaz2wsx'),
            'role' => 1,
        ]);
        User::create([
            'name' => '店長',
            'email' => 'abc@abc',
            'password' => Hash::make('1qaz2wsx'),
            'role' => 2,
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@com',
            'password' => Hash::make('1qaz2wsx'),
            'role' => 3,
        ]);
    }
}
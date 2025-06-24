<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 1,
            'remember_token' => Str::random(10),
        ];
    }

    public function role1()
    {
        return $this->state(fn(array $attributes) => ['role' => 1]);
    }

    public function role2()
    {
        return $this->state(fn(array $attributes) => ['role' => 2]);
    }

    public function role3()
    {
        return $this->state(fn(array $attributes) => ['role' => 3]);
    }

    public function unverified()
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => User::where('role', 1)->inRandomOrder()->first()->id,
            'shop_id' => Shop::inRandomOrder()->first()->id,
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => User::where('role', 1)->inRandomOrder()->first()->id,
            'reservation_id' => Reservation::inRandomOrder()->first()->id,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence,
        ];
    }
}
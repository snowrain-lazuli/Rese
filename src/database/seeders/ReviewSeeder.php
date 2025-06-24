<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Reservation;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reservation = Reservation::where('visited', 1)->inRandomOrder()->first();

        if ($reservation) {
            Review::create([
                'user_id' => $reservation->user_id,
                'reservation_id' => $reservation->id,
                'rating' => rand(3, 5),
                'comment' => 'とても良い体験でした。また利用したいです。',
            ]);
        }
    }
}
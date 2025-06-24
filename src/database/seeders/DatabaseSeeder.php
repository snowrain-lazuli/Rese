<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(2)->role1()->create();
        User::factory()->count(2)->role2()->create();
        User::factory()->count(2)->role3()->create();
        $this->call(UserSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(ReservationSeeder::class);
        Favorite::factory(3)->create();
        $this->call(ReviewSeeder::class);
    }
}
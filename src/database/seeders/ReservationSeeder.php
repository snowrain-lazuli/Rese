<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Shop;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 1)->get();
        $shops = Shop::all();

        foreach (range(1, 3) as $i) {
            Reservation::create([
                'user_id' => $users->random()->id,
                'shop_id' => $shops->random()->id,
                'reserved_date' => Carbon::now()->subDays($i)->toDateString(),
                'reserved_time' => Carbon::now()->subHours($i)->format('H:i:s'),
                'number_of_people' => rand(1, 10),
                'visited' => 1,
            ]);
        }

        foreach (range(1, 3) as $i) {
            Reservation::create([
                'user_id' => $users->random()->id,
                'shop_id' => $shops->random()->id,
                'reserved_date' => Carbon::now()->addDays($i)->toDateString(),
                'reserved_time' => Carbon::now()->addHours($i)->format('H:i:s'),
                'number_of_people' => rand(1, 10),
                'visited' => 0,
            ]);
        }
    }
}
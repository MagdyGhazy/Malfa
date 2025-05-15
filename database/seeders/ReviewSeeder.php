<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use App\Models\Review;

use App\Models\Room;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::inRandomOrder()->first();
        $activity = Activity::inRandomOrder()->first();
        $restaurant = Restaurant::inRandomOrder()->first();
        $room = Room::inRandomOrder()->first();
        $table = RestaurantTable::inRandomOrder()->first();
        $unit = Unit::inRandomOrder()->first();

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $activity->id,
            'model_type' => Activity::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is a review for an activity.',
        ]);

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $restaurant->id,
            'model_type' => Restaurant::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is a review for a restaurant.',
        ]);

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $room->id,
            'model_type' => Room::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is a review for a room.',
        ]);

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $table->id,
            'model_type' => RestaurantTable::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is a review for a table.',
        ]);

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $unit->id,
            'model_type' => RestaurantTable::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is a review for a table.',
        ]);
    }
}

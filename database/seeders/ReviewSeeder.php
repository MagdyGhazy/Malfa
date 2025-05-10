<?php

namespace Database\Seeders;

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
        $unit = Unit::inRandomOrder()->first();
        $room = Room::inRandomOrder()->first();

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $unit->id,
            'model_type' => Unit::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is a sample review message.',
        ]);

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $room->id,
            'model_type' => Room::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is another sample review message.',
        ]);

        Review::create([
            'user_id'    => $user->id,
            'model_id'   => $unit->id,
            'model_type' => Unit::class,
            'rate'       => rand(1, 5),
            'message'    => 'This is another sample review message.',
        ]);
    }
}

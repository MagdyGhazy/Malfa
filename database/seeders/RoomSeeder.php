<?php

namespace Database\Seeders;

use App\Models\Room;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Room::create([
                'unit_id'         => $i,
                'room_type'       => rand(1, 6),
                'price_per_night' => rand(300, 1000),
                'capacity'        => rand(1, 5),
                'description_en'  => 'Sample description EN ' . $i,
                'description_ar'  => 'وصف' . $i,
                'rules_en'        => 'rules EN ' . $i,
                'rules_ar'        => 'قوانين' . $i,
                'is_available'    => rand(1, 2),
            ]);
        }

    }
}

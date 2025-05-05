<?php

namespace Database\Seeders;

use App\Models\Unit;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <3; $i++) {
            Unit::create([
                'user_id'         => $i,
                'name'            => "Unit $i",
                'description_en'  => "Test description EN for unit $i",
                'description_ar'  => "وصف تجريبي للوحدة $i",
                'type'            => 1,
                'rating'          => rand(1, 5),
                'status'          => 1,
                'available_rooms' => [1, 2, 3],
            ]);
        }

    }
}
